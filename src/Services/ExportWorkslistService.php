<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use App\Entity\Workslist;

class ExportWorkslistService {

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
        $filename = $filenamePar?$filenamePar:$this->params->get('export_workslist_filename');
        // var_dump($filename);exit;

        $this->appLogger->info("IN: ExportWorkslistService.export: filename=" . $filename);

        file_put_contents($filename, "CODE,Task/Activity,Contract ref ,RESPONSIBLE&CONTACT_PERSON,start ,end\n");

        $repo = $this->manager->getRepository(Workslist::class);
        $listToShow = $repo->findAll();

        foreach ($listToShow as $x) {
            $ostr = "";
            $ostr = $ostr . $x->getActivityCodePrefix() . "-" . $x->getActivityCodeSuffix() . ",";
            $ostr = $ostr . $x->getDescription() . ",";
            $ostr = $ostr . $x->getWorkorder() . ",";
            $ostr = $ostr . $x->getResponsible() . "&" . $x->getDeputy() . ",";
            $ostr = $ostr . $x->getValidFrom()->format("Y") . ",";
            $ostr = $ostr . $x->getValidTo()->format("Y");

            file_put_contents($filename, $ostr . "\n", FILE_APPEND);
        }
    }
}

