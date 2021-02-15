<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Vendeur;
use App\Form\ProduitType;
use App\Form\VendeurType;
use App\Repository\ConcurrenceRepository;
use App\Repository\VendeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VendeurController extends AbstractController
{

    /**
     * @var VendeurRepository
     */
    private $repository;
    /**
     *
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ConcurrenceRepository
     */
    private $concurrencerepository;

    public function __construct(VendeurRepository $repository, EntityManagerInterface $em,  ConcurrenceRepository $concurrenceRepository)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->concurrencerepository = $concurrenceRepository;
    }


    /**
     *
     * @return Response
     */
    public function vendeur(Request $request): Response
    {

        $vendeur = new Vendeur();
        $formulaire = $this->createForm(VendeurType::class,$vendeur);

        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            $correctionnom = trim ( $vendeur->getNom()," \n\r\t\v\0");
            $vendeur->setNom($correctionnom);
            $this->addFlash('success','Bien ajouté avec succès');
            $this->em->persist($vendeur);
            $this->em->flush();
        }
        $vendeurs = $this->repository->findAll();
        return $this->render('Vendeur/vendeur.html.twig',[
            'current_onglet'  =>  'vendeur',
            'vendeurs'  =>  $vendeurs,
            'form'  =>  $formulaire->createView()
        ]);
    }


    /**
     *
     * @Route("/admin/vendeur/edit/{id}",name="vendeur.edit", methods={"GET|POST"})
     * @param Vendeur $vendeur
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifier(Vendeur $vendeur, Request $request)
    {
        $formulaire = $this->createForm(VendeurType::class,$vendeur);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            $this->em->flush();
            $this->addFlash('success','Bien modifié avec succès');

            return $this->redirectToRoute('vendeur');
        }

        return $this->render('Vendeur/edit.html.twig',[
            'vendeur'  =>  $vendeur,
            'current_onglet'  =>  'vendeur',
            'form'  =>  $formulaire->createView()
        ]);
    }

    /**
     *
     * @Route("/admin/vendeur/{id}",name="vendeur.delete", methods={"DELETE"})
     * @param Vendeur $vendeur
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Vendeur $vendeur, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $vendeur->getId(),$request->get('_token')))
        {
            // vérification de clé étrangère de vendeur avant suppression
            $arrayvendeur = $this->concurrencerepository->findAllByVendeur($vendeur->getId());
            if (empty($arrayvendeur)){
                $this->em->remove($vendeur);
                $this->em->flush();
                $this->addFlash('success','Bien supprimé avec succès');
            }else {
                $this->addFlash('success','Suppresion impossible : ce vendeur est lié à au moins un article');
            }

        }
        return $this->redirectToRoute('vendeur');
    }


}
