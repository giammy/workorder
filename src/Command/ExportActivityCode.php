<?php

// src/Command/ExportActivityCode.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Doctrine\Common\Persistence\ObjectManager;
use App\Services\ExportActivityCodeService;

class ExportActivityCode extends Command
{
    private $manager;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'export:activityCode';

    public function __construct(ObjectManager $manager,
                                ExportActivityCodeService $exportActivityCodeService) {
        $this->manager = $manager;
        $this->exportActivityCodeService = $exportActivityCodeService;
        parent::__construct();
    }

    protected function configure() {
      $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Export file activityCode*.csv.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('Export file activityCode*.csv.')

        ->addArgument('filename', InputArgument::OPTIONAL, 'CSV filename')
      ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $filename = $input->getArgument('filename');
        $output->writeln("Export activityCode to file: '" . ($filename?$filename:"EXPORT_ACTIVITYCODE_FILENAME") . "'");
        $this->exportActivityCodeService->export($filename);
    }
}
