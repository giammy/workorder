<?php

// src/Command/ExportWorkslist.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Doctrine\Common\Persistence\ObjectManager;
use App\Services\ExportWorkslistService;

class ExportWorkslist extends Command
{
    private $manager;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'export:workslist';

    public function __construct(ObjectManager $manager,
                                ExportWorkslistService $exportWorkslistService) {
        $this->manager = $manager;
        $this->exportWorkslistService = $exportWorkslistService;
        parent::__construct();
    }

    protected function configure() {
      $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Export file workslist*.csv.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('Export file workslist*.csv.')

        ->addArgument('filename', InputArgument::OPTIONAL, 'CSV filename')
      ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $filename = $input->getArgument('filename');
        $output->writeln("Export workslist to file: '" . ($filename?$filename:"EXPORT_WORKSLIST_FILENAME") . "'");
        $this->exportWorkslistService->export($filename);
    }
}
