<?php

// src/Command/ExportWorkorder.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Doctrine\Common\Persistence\ObjectManager;
use App\Services\ExportWorkorderService;

class ExportWorkorder extends Command
{
    private $manager;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'export:workorder';

    public function __construct(ObjectManager $manager,
                                ExportWorkorderService $exportWorkorderService) {
        $this->manager = $manager;
        $this->exportWorkorderService = $exportWorkorderService;
        parent::__construct();
    }

    protected function configure() {
      $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Export file workorder*.csv.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('Export file workorder*.csv.')

        ->addArgument('filename', InputArgument::OPTIONAL, 'CSV filename')
      ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $filename = $input->getArgument('filename');
        $output->writeln("Export workorder to file: '" . ($filename?$filename:"EXPORT_WORKORDER_FILENAME") . "'");
        $this->exportWorkorderService->export($filename);
    }
}
