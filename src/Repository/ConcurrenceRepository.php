<?php

namespace App\Repository;

use App\Entity\Concurrence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Concurrence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concurrence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concurrence[]    findAll()
 * @method Concurrence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcurrenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concurrence::class);
    }


     /**
      * @return Concurrence[] Returns an array of Article objects in order from good state to less good state
      */

    public function findAllByEtatOrder () {
        return $this->createQueryBuilder('a')
            ->addSelect('etat')
            ->addSelect('vendeur')
            ->innerJoin('a.etat','etat')
            ->innerJoin('a.vendeur','vendeur')
            ->addorderBy('etat.valeur', 'DESC')
            ->addorderBy('a.prix', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllByEtatAndPriceOrder ($idproduit) {
        return $this->createQueryBuilder('a')
            ->addSelect('etat')
            ->addSelect('vendeur')
            ->innerJoin('a.nom','produit')
            ->andWhere('produit.id = '.$idproduit)
            ->innerJoin('a.etat','etat')
            ->innerJoin('a.vendeur','vendeur')
            ->addorderBy('etat.valeur', 'DESC')
            ->addorderBy('a.prix', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllByEtatOrderWithFilter ($idproduit) {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.nom','nom')
            ->andWhere('nom.id = '.$idproduit)
            ->addSelect('etat')
            ->addSelect('vendeur')
            ->innerJoin('a.etat','etat')
            ->innerJoin('a.vendeur','vendeur')
            ->addorderBy('etat.valeur', 'DESC')
            ->addorderBy('a.prix', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllByEtat ($idEtat) {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.etat','nom')
            ->andWhere('nom.id = '.$idEtat)
            ->addSelect('etat')
            ->addSelect('vendeur')
            ->innerJoin('a.etat','etat')
            ->innerJoin('a.vendeur','vendeur')
            ->getQuery()
            ->getResult();
    }

    public function findAllByVendeur ($idVendeur) {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.vendeur','nom')
            ->andWhere('nom.id = '.$idVendeur)
            ->getQuery()
            ->getResult();
    }

    public function findAllByEtatOrderWithFilterByName ($nomproduit) {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.nom','nom')
            ->andWhere('nom.nom = '.$nomproduit)
            ->addSelect('etat')
            ->addSelect('vendeur')
            ->innerJoin('a.etat','etat')
            ->innerJoin('a.vendeur','vendeur')
            ->addorderBy('etat.valeur', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getAllProductWithSupState($idArticle,$valeurEtat) {
        return  $this->createQueryBuilder('a')
            ->innerJoin('a.nom','nom')
            ->andWhere('nom.id = '.$idArticle)
            ->innerJoin('a.etat','etat')
            ->andWhere('etat.valeur > '.$valeurEtat)
            ->orderBy('a.prix','ASC')
            ->getQuery()
            ->getResult();


    }

    public function getAllProductByState($idArticle,$valeurEtat) {
        return  $this->createQueryBuilder('a')
            ->innerJoin('a.nom','nom')
            ->andWhere('nom.id = '.$idArticle)
            ->innerJoin('a.etat','etat')
            ->andWhere('etat.valeur = '.$valeurEtat)
            ->orderBy('a.prix','ASC')
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
