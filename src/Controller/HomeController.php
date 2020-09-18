<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Psr\Log\LoggerInterface;
use App\Entity\ActivityCode;
use App\Entity\Workorder;
use App\Entity\Workslist;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Services\ExportWorkslistService;

class HomeController extends AbstractController
{
    private $params;
    private $exportWorkslistService;
    public function __construct(ParameterBagInterface $params,
                                ExportWorkslistService $exportWorkslistService) {
        $this->params = $params;
        $this->exportWorkslistService = $exportWorkslistService;
    }

    /**
     * @Route("/", name="home")
     */
    public function homeAction(LoggerInterface $appLogger)
    {
        $username = $this->get('security.token_storage')->getToken()->getUser()->getUsername();
        $appLogger->info("IN: homeAction: username='" . $username . "'");

        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
            'username' => $username,
        ]);
    }

    /**
     * @Route("/showall/{item}", name="showall")
     */
    public function showallAction(LoggerInterface $appLogger, $item="0")
    {
	$item=intval($item);

        $username = $this->get('security.token_storage')->getToken()->getUser()->getUsername();
	$allowedUsers = preg_split('/, */', $this->params->get('users_cfo'));
        if (in_array($username, $allowedUsers)) {
            $appLogger->info("IN: showallAction: username='" . $username . "' allowed");
            $repo = $this->getDoctrine()->getRepository(Workslist::class);
	    $listToShow = $repo->findAll(); 

            // echo("<pre>");var_dump($listToShow);exit;
	    return $this->render('showall.html.twig', [
                'controller_name' => 'ShowallController',
                'list' => $listToShow,
                'username' => $this->get('security.token_storage')->getToken()->getUser()->getUsername(),
                ]);
        } else {
            $appLogger->info("IN: showallAction: username='" . $username . "' NOT allowed");
            return $this->redirectToRoute('home');
        }
    }


    /**
     * @Route("/editUser/{id}", name="editUser")
     */
    public function editUserAction(Request $request, \Swift_Mailer $mailer, LoggerInterface $appLogger, $id="-1")
    {
        //$appLogger->info("IN: editUserAction");
        $id = intval($id);
        $repo = $this->getDoctrine()->getRepository(Workslist::class);
        $repoAC = $this->getDoctrine()->getRepository(ActivityCode::class);
        $repoWO = $this->getDoctrine()->getRepository(Workorder::class);

        // if id == -1 -> new user, else edit id user TODO
	$account = $repo->find($id);
        $oldAccount = $account;
        if (!$account) {
            // id does not exist: create new user
            $account = new Workslist();
            $account->setCreated(new \DateTime());
            $account->setIsAnOldCopy(false);
            $account->setVersion($this->params->get('workslist_current_db_format_version'));
            $account->setLastChangeDate(new \DateTime());
            $account->setValidFrom(new \DateTime());
	    $account->setValidTo(new \DateTime('2099-12-31 11:59:59'));
        }

	$acAll = $repoAC->findAll();
	$woAll = $repoWO->findAll();

        $activityCodePrefixChoices = [];
	foreach($acAll as $x) {
	    $l = $x->getLabel();
            $activityCodePrefixChoices[$l] = $l;
	}
        asort($activityCodePrefixChoices);

        $workorderChoices = [];
	foreach($woAll as $x) {
	    $l = $x->getLabel();
            $workorderChoices[$l] = $l;
	}
	asort($workorderChoices);

        $form = $this->createFormBuilder($account)
            ->add('activityCodePrefix', ChoiceType::class, array(
                         'placeholder' => "Scegliere codice",
			 'choices'  => $activityCodePrefixChoices,))
            ->add('activityCodeSuffix', TextType::class, array(
                         'required' => true,))
            ->add('description', TextType::class, array(
                         'required' => false,))
            ->add('workorder', ChoiceType::class, array(
                         'placeholder' => "Scegliere workorder",
			 'choices'  => $workorderChoices,))
            // responsible is associated to activityCodePrefix
            ->add('deputy', TextType::class, array(
                         'required' => false,))
            ->add('validFrom', DateType::class, array('data' => $account->getValidFrom()))
            ->add('validTo', DateType::class, array(
                                  'years' => range(date('Y')-1, date('Y')+100),
                                  'data' => $account->getValidTo(),
                                 ))
            ->getForm();

	$form->handleRequest($request);

        $appLogger->info("IN: editWorkorderAction: username='" .
            $this->get('security.token_storage')->getToken()->getUser()->getUsername() .
            "' isSubmitted=" . ($form->isSubmitted()?"TRUE":"FALSE") . 
            " isValid=" . ($form->isSubmitted()?($form->isValid()?"TRUE":"FALSE"):"---") .
            " form activityCodePrefix='" . $account->getActivityCodePrefix()
            );

	if ($form->isSubmitted() && $form->isValid()) {
             // $form->getData() holds the submitted values
             // but, the original variable has also been updated
	     $account = $form->getData();
	     $account->setLastChangeAuthor($this->get('security.token_storage')->getToken()->getUser()->getUsername());
	     $account->setLastChangeDate(new \Datetime());
             $x = $repoAC->findByLabel($account->getActivityCodePrefix());
	     $account->setResponsible($x[0]->getResponsible());

             $em = $this->getDoctrine()->getManager();
             $em->persist($account);
             $em->flush();

	     // use default filename from environment variable EXPORT_WORKSLIST_FILENAME
             $this->exportWorkslistService->export(null); 

             // TODO pagina ringraziamento?
             return $this->redirectToRoute('home');
    	}

        return $this->render('editUser.html.twig', [
            'form' => $form->createView(),
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

   /*
    * api/public area
    */



}
