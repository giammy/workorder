<?php

// src/Command/ImportWorkslist.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Entity\Workslist;

class ImportWorkslist extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'import:workslist';

    private $manager;
    private $params;

    public function __construct(ObjectManager $manager,
                                ParameterBagInterface $params) {
        $this->manager = $manager;
        $this->params = $params;
        parent::__construct();
    }

    protected function configure() {
      $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Import Workslist from CSV')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('Import Workslist from CSV')

        ->addArgument('mode', InputArgument::REQUIRED, 'import mode: APPEND (do db) or OVERWRITE (reset current table)')
        ->addArgument('filename', InputArgument::REQUIRED, 'CSV filename')
      ;
    }

    protected function getDateFromMonth($month, $defaultMonth, $defaultDay) {
        $intMonth = intval($month);
        $date = new \DateTime();
	if ($intMonth>0 && $intMonth<13) {
            $date->setDate($date->format("Y"), $intMonth, $defaultDay);
        } else {
            $date->setDate($date->format("Y"), $defaultMonth, $defaultDay);
        }
        return($date);
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $mode = $input->getArgument('mode');
        $filename = $input->getArgument('filename');
        $output->writeln('Import CSV from file: ' . $filename . " mode: " . $mode);
	$dateFormat = $this->params->get('date_format');

        if ($mode == "OVERWRITE") {
            $list = $this->manager->getRepository(Workslist::class)->findAll();
	    foreach ($list as $x) {
                $this->manager->remove($x);
            }
            $this->manager->flush();
        } 

        $rowNo = 1;
        $fieldsNo = 0;
        // $fp is file pointer to filename
        if (($fp = fopen($filename, "r")) !== FALSE) {
            while (($row = fgetcsv($fp, 1000, ",")) !== FALSE) {
                $num = count($row);
                if ($rowNo == 1) {
                    $fieldsNo = $num;
                    $rowNo++;
                    continue;
		}

		if ($num != $fieldsNo) {
                    $output->writeln('ERROR: Row #' . $rowNo . " has " . $num . " fields (expected " . $fieldsNo);
                    exit;
                }

                $output->writeln("Importing " . $rowNo . ': "' . implode('","', $row) . '"');

		// store data in db
                $acc = new Workslist();

                // OLD FORMAT v1 ($fieldsNo == 6)
                // 0=activityCode, 1=desc, 2=wo, 3=resp&deputy, 4=startMonth, 5=endMonth
                // NEW FORMAT v2 ($fieldsNo == 7)
                // 0=activityCode, 1=desc, 2=wo, 3=resp, 4=deputy, 5=start, 6=end

                $x = explode('-',$row[0]);
                $acc->setActivityCodePrefix($x[0]);
                $acc->setActivityCodeSuffix($x[1]);
                $acc->setDescription($row[1]);
                $acc->setWorkorder($row[2]);
                if ($fieldsNo == 6) {
                    $x = explode('&',$row[3]);
                    $acc->setResponsible($x[0]);
                    if (array_key_exists(1,$x)) {
                        $acc->setDeputy($x[1]);
                    } else {
                        $acc->setDeputy(null);
		    }
                    $acc->setValidFrom($this->getDateFromMonth($row[4],12,1));
                    $acc->setValidTo($this->getDateFromMonth($row[5],12,28));
                } else {
                    $acc->setResponsible($row[3]);
                    $acc->setResponsible($row[4]);
                    $acc->setValidFrom(date_create_from_format($dateFormat, $row[5]));
                    $acc->setValidTo(date_create_from_format($dateFormat, $row[6]));
		}
                $acc->setLastChangeAuthor("importer");
                $acc->setLastChangeDate(new \Datetime());
                $acc->setInternalNote("");
                $acc->setVersion($this->params->get('workslist_current_db_format_version'));
                $acc->setCreated(new \Datetime());
                $acc->setIsAnOldCopy(false);
                $this->manager->persist($acc);
                $this->manager->flush();

                $rowNo++;
            }
            fclose($fp);
        }
    }
}

