<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\JobOffer;
use App\Form\ApplicationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class OfferController extends AbstractController{
    
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }
    /**
     * @return Response
     * @Route("/", name="offer_index")
     */
    public function index(): Response{

        $offers = $this->manager->getRepository(JobOffer::class)
                  ->findAll();
        
        return $this->render('offer/index.html.twig', 
        [
            'offers' => $offers
        ]);
    }

    /**
     * @param JobOffer $offer
     * @param Request $request
     * @return Response
     * @Route("offer/{id}/apply", name="offer_apply_2")
     */
    public function apply(JobOffer $offer, Request $request){
        //Se pasa la entidad offer y symfony supone que el id de la url es el id de offer
        //Si se quiere una conversion diferente, para eso lo indicamos en @ParamConverter()

        /* Por lo que esto no es necesario el uso dl MANAGER
        if(!($offer = $this->manager->getRepository(JobOffer::class)
            ->find($id))){
            throw new NotFoundHttpException();
        } */
        
        //Creamos un objeto applicant vacio
        $applicant = new Applicant();

        //Se indica la clase del formulario y los datos que se le pasa
        $form = $this->createForm(ApplicationType::class, $applicant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //persist genera el sql pero no lo ejecuta, se queda en cola
            $this->manager->persist($applicant);
            $this->manager->flush();

            $this->addFlash('success','Your application has been received');
            return $this->redirectToRoute('offer_index');
        }
        return $this->render('offer/apply.html.twig',
        [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @Route("offer/{id}/apply", name="offer_apply_two")
     */
    public function applyTwo(int $id){

        if(!($offer = $this->manager->getRepository(JobOffer::class)
            ->find($id))){
            throw new NotFoundHttpException();
        }

        return $this->render('offer/apply.html.twig',
        [
            'offer' => $offer
        ]);
    }

    /**
     * @IsGranted("ROLE_COMPANY_OWNER")
     * @Route("/company/", name="company_offers_index")
     * @return Response
     */
    public function companyOffers() : Response
    {
        $user = $this->getUser();

        $company = $user->getcompany();

        if(!$company){
            return $this->redirect('company_create');
        }

        return $this->render('offer/company_index.html.twig',
        [
            'offers' => $company ? $company->getJobOffers() : [],
        ]
        );
    }
}