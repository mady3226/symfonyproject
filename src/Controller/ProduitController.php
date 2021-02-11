<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ConcurrenceRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{


    /**
     * @var ProduitRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    private $concurrencerepository;

    public function __construct(ProduitRepository $repository, EntityManagerInterface $em, ConcurrenceRepository $concurrenceRepository)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->concurrencerepository = $concurrenceRepository;
    }


    /**
     * @return Response
     */
    public function produit(Request $request) : Response
    {

        $produit = new Produit();
        $formulaire = $this->createForm(ProduitType::class,$produit);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid())
        {
            $correctionnom = trim ( $produit->getNom()," \n\r\t\v\0");
            $produit->setNom($correctionnom);
            $this->addFlash('success','Bien ajouté avec succès');
            $this->em->persist($produit);
            $this->em->flush();

        }
        $produits = $this->repository->findAll();
        return $this->render('produit/produit.html.twig',[
            'current_onglet'  =>  'produit',
            'produits'  =>  $produits,
            'form'  =>  $formulaire->createView()
        ]);
    }


    /**
     *
     * @Route("/produit/edit/{id}",name="produit.edit", methods={"GET|POST"})
     * @param Produit $produit
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifier(Produit $produit, Request $request)
    {
        $formulaire = $this->createForm(ProduitType::class,$produit);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            $this->em->flush();
            $this->addFlash('success','Bien modifié avec succès');
            return $this->redirectToRoute('produit');
        }
        return $this->render('produit/edit.html.twig',[
            'current_onglet'  =>  'produit',
            'produit'  =>  $produit,
            'form'  =>  $formulaire->createView()
        ]);
    }

    /**
     *
     * @Route("/produit/{id}",name="produit.delete", methods={"DELETE"})
     * @param Produit $produit
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Produit $produit, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(),$request->get('_token')))
        {
            // vérification de clé étrangère de produit avant suppression
            $arrayproduit = $this->concurrencerepository->findAllByEtatOrderWithFilter($produit->getId());
            if (empty($arrayproduit)){
                $this->em->remove($produit);
                $this->em->flush();
                $this->addFlash('success','Bien supprimé avec succès');
            }else {
                $this->addFlash('success','Suppresion impossible : un vendeur/concurrent est lié à ce produit');
            }

        }
        return $this->redirectToRoute('produit');

    }


}
