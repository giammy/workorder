<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use App\Entity\Workorder;

class ExportWorkorderService {

    private $params;
    private $manager;

    public function __construct(ObjectManager $manager,
                                ParameterBagInterface $params,
				LoggerInterface $appLogger) {
        $this->manager = $manager;
        $this->params = $params;
        $this->appLogger = $appLogger;
    }
    
    public function export($filenamePar) {
        $filename = $filenamePar?$filenamePar:$this->params->get('export_workorder_filename');
        $this->appLogger->info("IN: ExportWorkorderService.export: filename=" . $filename);
        file_put_contents($filename, "workorder\n");
        foreach ($this->manager->getRepository(Workorder::class)->findAll() as $x) {
            file_put_contents($filename, ($x->getLabel() . "\n"), FILE_APPEND);
        }
    }
}

