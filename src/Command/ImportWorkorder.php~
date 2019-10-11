<?php

// src/Command/ImportActivityCode.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\ActivityCode;

class ImportActivityCode extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'import:activityCode';

    private $manager;

    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
        parent::__construct();
    }

    protected function configure() {
      $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Import ActivityCode from CSV')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('Import ActivityCode from CSV')

        ->addArgument('filename', InputArgument::REQUIRED, 'CSV filename')
      ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $filename = $input->getArgument('filename');
        $output->writeln('Import CSV from file: ' . $filename);

        $dateFormat = 'Y-m-d H:i:sO';
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

                $output->write("Importing " . $rowNo . ": ");
                for ($c=0; $c < $num; $c++) {
                    $output->write('"' . $row[$c] . '",');
                }
                $output->writeln("");

		// store data in db
                $acc = new ActivityCode();
                $acc->setLabel($row[0]);
                $acc->setResponsible($row[1]);
                $this->manager->persist($acc);
                $this->manager->flush();

                $rowNo++;
            }
            fclose($fp);
        }
    }
}

