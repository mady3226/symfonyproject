<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class VendeurControllerTest extends WebTestCase
{


    public function testHomePage()
    {
        $client = static::CreateClient ();
        $client->request('GET','/vendeur');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    }

    // test de la page d'acceil de la gestion des vendeurs
    public function testHomePageContent()
    {
        $client = static::CreateClient ();
        $client->request('GET','/vendeur');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1','Formulaire de gestion des concurrents/vendeurs :');
        $this->assertSelectorTextContains('span','Ajouter');
        $this->assertSelectorExists('.btn.btn-secondary');
    }


    public function testTestPageModification()
    {
        $client = static::CreateClient ();
        $client->request('GET','/vendeur/edit/13');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('h1','Modification d\'un vendeur : ');
    }

    public function testDeleteProtection (){
        $client = static::CreateClient ();
        $client->request('GET','/vendeur/3');
        $this->assertResponseStatusCodeSame(405);
    }


    // test de vérification de suppression de donner à travers l'url

    public function testDeleteRedirection (){
        $client = static::CreateClient ();
        $client->request('DELETE','/vendeur/3');
        $this->assertResponseRedirects();
    }


    // Ces tests vérifient le non acceptation des doublons dans la base de données
        // Pour tester enlever les commentaires et changer les non des vendeurs
        /*


    public function testAdd(){


        $client = static::CreateClient ();
        $crawler = $client->request('GET','/vendeur');
        $form = $crawler->selectButton('Ajouter')->form([
            'vendeur[nom]' =>  'NoDoublon_',
        ]);

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('.alert.alert-success');
        $this->assertSelectorExists('.btn.btn-secondary');


        $form = $crawler->selectButton('Ajouter')->form([
            'vendeur[nom]' =>  'NoDoublon_',
        ]);

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('span','this value is already used');

    }*/



}
