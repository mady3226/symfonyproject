<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CalculControllerTest extends WebTestCase
{

    // Tests sur les contenus de la page de réalisation du calcul du prix du produi
    // Vérification de l'accéssibilité de la page et ces entêtes
    public function testHomePage()
    {
        $client = static::CreateClient ();
        $client->request('GET','/algorithmecalcul');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('.table.table-striped');
        $this->assertSelectorTextContains('h1','Sellermania Algorithme ');
        $this->assertSelectorTextContains('.btn.btn-success','Calculer');
    }

    /* cette methode teste la fonctionnalitée principale du projet,
     * c'est à dire à l'aide d'un formulaire (champs : article, prix_plancher et l'état de l'article)
     * je vais lancer le serveur de calcul du prix du vendeur et ensuite retourne le prix calculé
    */
    public function testAlgorithme () {


        $client = static::CreateClient ();
        $crawler = $client->request('POST','/algorithmecalcul');
        $form = $crawler->selectButton('Calculer')->form([
            'strategi[prix_plancher]'   =>  15,
            'strategi[produit]'   =>  1,     // article a premier de la liste
            'strategi[etat]'   =>  6  // très bon état
        ]);

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);


        // mon test est celui de l'exemple dans l'énoncé du sujet,
        // donc 19.99 être affiché dans la même page

        $this->assertSelectorTextContains('div.text-primary','19.99 €');

    }

}
