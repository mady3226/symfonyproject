<?php

namespace App\Controller;

use App\Entity\Concurrence;
use App\Entity\Strategi;
use App\Form\ConcurrenceType;
use App\Form\ProduitType;
use App\Form\StrategiType;
use App\Repository\ConcurrenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculController extends AbstractController
{
    private $repository;


    public function __construct(ConcurrenceRepository $repository)
    {
        $this->repository = $repository;
    }





    /**
     * @Route("/algorithmecalcul", name="algorithmecalcul",methods={"GET|POST"})
     */
    public function index(Request $request): Response
    {
        /* C'est la méthode qui répresente l'action qui gère le calcul du prix de l'article*/
        $strategie = new Strategi();
        // génération des formulaires automatique à l'aide du composant form de symfony
        $formulaire_produit = $this->createForm(StrategiType::class, $strategie);
        $formulaire_produit->handleRequest($request);
        // Récuperation de tous les articles avec les vendeurs  trié en fonction de leurs états
        $articles = $this->repository->findAllByEtatOrder();

        if ($formulaire_produit->isSubmitted() && $formulaire_produit->isValid()) {
            // Nous rentrons dans cette condition valide le formule de calcul du prix d'un artige

            $articles = $this->repository->findAllByEtatOrderWithFilter($strategie->getProduit()->getId());
            // la méthode calculer prend en paramètre  le contenu du formulaire envoyé par l'utilisateur
            // et retourne le prix qui correspondra au prix de son article
            $prix = $this->calculer($strategie);

            if ($prix <= 0){
                return $this->render('bundles/TwigBundle/Exception/error0001.html.twig', [
                    'status_text' => 'erreur dans le calcul du prix : prix négatif ou nul',

                ]);
            }
            return $this->render('Algorithme/algorithmecalcul.html.twig', [
                'current_onglet' => 'algorithmecalcul',
                'articles' => $articles,
                'formulaire_produit' => $formulaire_produit->createView(),
                'zone_ready'    =>  'pret',
                'price' =>  $prix
            ]);
        }
        return $this->render('Algorithme/algorithmecalcul.html.twig', [
            'current_onglet' => 'algorithmecalcul',
            'articles' => $articles,
            'zone_ready'    =>  'nopret',
            'formulaire_produit' => $formulaire_produit->createView()
        ]);
    }

    /**
     * Calcule le prix de l'article  du vendeur
     * param Strategi $strategi (comprends le formulaire composé de (prix_plancer, l'article, l'état du produit du vendeur))
     * return int
     */
    private function calculer ($strategi) {
        $idArticle = $strategi->getProduit()->getId();
        $valeurEtat = $strategi->getEtat()->getValeur();
        $prixplancher = $strategi->getPrixPlancher();
        // Récuperation de tous les articles de même état que l'état du vendeur
        $Produitegaux = $this->repository->getAllProductByState($idArticle,$valeurEtat);
        $result = 0.0;
        if (!empty($Produitegaux)) {
            // S'il existe des articles de même état que celui du vendeur
            // Sachant que j'obtiens ce tableau trié à l'aide de Doctrine
            //Alors je retourne la première case ecece
            $result = $Produitegaux[0]->getPrix() - 0.01;
        } else {
            // Sinon il n'existe pas d'article avec le meme état que celui du vendeur
            // Donc à l'aide d'une autre requete je récupère tous les états superieurs, également triés
            $Produitsuperieur = $this->repository->getAllProductWithSupState($idArticle,$valeurEtat);
            if (!empty($Produitsuperieur)) {
                //s'il en existe, alors je retourne la première case soustrait de -1
                $result = $Produitsuperieur[0]->getPrix() - 1;
            }
        }
        // comparaison avec le prix plancher pour deduire le prix du vendeur
        return $prixplancher < $result ? $result : $prixplancher;
    }





}
