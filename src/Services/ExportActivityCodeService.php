<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use App\Entity\ActivityCode;

class ExportActivityCodeService {

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
        $filename = $filenamePar?$filenamePar:$this->params->get('export_activityCode_filename');
        $this->appLogger->info("IN: ExportActivityCodeService.export: filename=" . $filename);
        file_put_contents($filename, "activityCode,responsible\n");
        foreach ($this->manager->getRepository(ActivityCode::class)->findAll() as $x) {
            file_put_contents($filename, ($x->getLabel().",".$x->getResponsible()."\n"), FILE_APPEND);
        }
    }
}

