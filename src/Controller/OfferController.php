<?php

namespace App\Controller;

use App\Entity\JobOffer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

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
     * @return Response
     * @Route("offer/{id}/apply", name="offer_apply")
     */
    public function apply(JobOffer $offer){
        //Se pasa la entidad offer y symfony supone que el id de la url es el id de offer
        //Si se quiere una conversion diferente, para eso lo indicamos en @ParamConverter()

        /* Por lo que esto no es necesario el uso dl MANAGER
        if(!($offer = $this->manager->getRepository(JobOffer::class)
            ->find($id))){
            throw new NotFoundHttpException();
        } */

        return $this->render('offer/apply.html.twig',
        [
            'offer' => $offer
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
}