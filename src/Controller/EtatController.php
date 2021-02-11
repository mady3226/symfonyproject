<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Form\EtatType;
use App\Repository\ConcurrenceRepository;
use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtatController extends AbstractController
{


    /**
     * @var EtatRepository
    */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ConcurrenceRepository
     */
    private $concurrencerepository;


    public function __construct(EtatRepository $repository, EntityManagerInterface $em, ConcurrenceRepository $concurrenceRepository )
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->concurrencerepository = $concurrenceRepository;
    }



    /**
     * @return Response
     */
    public function etat(Request $request) : Response
    {

        $etat = new Etat();
        $formulaire = $this->createForm(EtatType::class,$etat);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            $correctionnom = trim ( $etat->getNom()," \n\r\t\v\0");
            $etat->setNom($correctionnom);
            $this->em->persist($etat);
            $this->em->flush();
            $this->addFlash('success','Bien ajouté avec succès');
        }
        $etats = $this->repository->findAll();
        return $this->render('Etat/etat.html.twig',[
            'current_onglet'    => 'etat',
            'etats'  =>  $etats,
            'form'  =>  $formulaire->createView()
        ]);
    }

    /**
     *
     * @Route("/etat/edit/{id}",name="etat.edit", methods={"GET|POST"})
     * @param Etat $etat
     * @return \Symfony\Component\HttpFoundation\Response
    */
    public function modifier(Etat $etat, Request $request)
    {
        $formulaire = $this->createForm(EtatType::class,$etat);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            $this->em->flush();
            $this->addFlash('success','Bien modifié avec succès');
            return $this->redirectToRoute('etat');
        }
        return $this->render('Etat/edit.html.twig',[
            'current_onglet'  =>  'etat',
            'etat'  =>  $etat,
            'form'  =>  $formulaire->createView()
        ]);
    }

    /**
     *
     * @Route("/etat/{id}",name="etat.delete", methods={"DELETE"})
     * @param Etat $etat
     * @return \Symfony\Component\HttpFoundation\Response
    */
    public function delete(Etat $etat, Request $request)
    {

        if ($this->isCsrfTokenValid('delete' . $etat->getId(),$request->get('_token')))
        {
            // vérification de clé étrangère d'etat avant suppression
            $arrayetat = $this->concurrencerepository->findAllByEtat($etat->getId());
            if (empty($arrayetat)){
                $this->em->remove($etat);
                $this->em->flush();
                $this->addFlash('success','Bien supprimé avec succès');
            }else {
                $this->addFlash('success','Suppresion impossible : au moins un produit est lié à cet état');
            }
        }
        return $this->redirectToRoute('etat');

    }

}
