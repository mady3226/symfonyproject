<?php

namespace App\Controller;

use App\Entity\Concurrence;
use App\Entity\Filtre;
use App\Entity\Produit;
use App\Form\ConcurrenceType;
use App\Form\FiltreType;
use App\Form\ProduitType;
use App\Repository\ConcurrenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcurrenceController extends AbstractController
{


    /**
     * @var ConcurrenceRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ConcurrenceRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @return Response
    */
    public function apercuconcurrence(Request $request) :Response
    {
        $article = new Concurrence();
        $filtre = new Filtre();

        $formulaire_produit = $this->createForm(ConcurrenceType::class,$article);
        $formulaire_filtre = $this->createForm(FiltreType::class,$filtre);
        $formulaire_produit->handleRequest($request);
        $formulaire_filtre->handleRequest($request);

        if ($formulaire_filtre->isSubmitted()&&$formulaire_filtre->isValid()){
            $apercuconcurrences = $this->repository->findAllByEtatOrderWithFilter($filtre->getProduit()->getId());

            return $this->render('ConcurrenceView/concurrence.html.twig',[
                'current_onglet'  =>  'concurrence',
                'articles'  =>  $apercuconcurrences,
                'produits'  =>  $article,
                'formulaire_produit'    =>  $formulaire_produit->createView(),
                'formulaire_filtre'    =>  $formulaire_filtre->createView()
            ]);
        }

        if($formulaire_produit->isSubmitted()&&$formulaire_produit->isValid()){
            $this->em->persist($article);
            $this->em->flush();
            $apercuconcurrences = $this->repository->findAllByEtatOrderWithFilter($article->getNom()->getId());

            return $this->render('ConcurrenceView/concurrence.html.twig',[
                'current_onglet'  =>  'concurrence',
                'articles'  =>  $apercuconcurrences,
                'produits'  =>  $article,
                'formulaire_produit'    =>  $formulaire_produit->createView(),
                'formulaire_filtre'    =>  $formulaire_filtre->createView()
            ]);
        }


        $apercuconcurrences = $this->repository->findAllByEtatOrder();
        return $this->render('ConcurrenceView/concurrence.html.twig',[
            'current_onglet'  =>  'concurrence',
            'articles'  =>  $apercuconcurrences,
            'produits'  =>  $article,
            'formulaire_produit'    =>  $formulaire_produit->createView(),
            'formulaire_filtre'    =>  $formulaire_filtre->createView()
        ]);
    }




    /**
     *
     * @Route("/admin/concurrence/edit/{id}",name="concurrence.edit", methods={"GET|POST"})
     * @param Concurrence $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifier(Concurrence $article, Request $request)
    {
        $formulaire = $this->createForm(ConcurrenceType::class,$article);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('apercuconcurrence');
        }
        return $this->render('ConcurrenceView/edit.html.twig',[
            'current_onglet'  =>  'concurrence',
            'article'  =>  $article,
            'form'  =>  $formulaire->createView()
        ]);
    }




    /**
     *
     * @Route("/admin/concurrence/{id}",name="concurrence.delete", methods={"DELETE"})
     * @param Concurrence $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Concurrence $article, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(),$request->get('_token')))
        {
            $this->em->remove($article);
            $this->em->flush();
        }
        return $this->redirectToRoute('apercuconcurrence');

    }
}
