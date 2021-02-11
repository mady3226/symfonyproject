<?php


namespace App\Tests\EtatTest;


use App\Controller\EtatController;
use App\Entity\Etat;
use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class EtatTest extends TestCase
{

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var EtatRepository
     */
    private $repo;



    public function testCreaton(){
        $etat = new Etat();

        $etat->setNom('Bon');
        $etat->setValeur(1);


       $this->assertEquals(1,$etat->getValeur());
       $this->assertEquals('Bon',$etat->getNom());
    }

}
