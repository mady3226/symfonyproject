<?php


namespace App\Tests\EtatTest;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class EtatControllerTest extends WebTestCase
{

    public function testHomePage()
    {
        $client = static::CreateClient ();
        $client->request('GET','/etat');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    }

    public function testHomePageContent()
    {
        $client = static::CreateClient ();
        $client->request('GET','/etat');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1','Formulaire de gestion des états des produits :');
        $this->assertSelectorTextContains('span','Ajouter');
        $this->assertSelectorExists('.btn.btn-secondary');


    }

    public function testTestPageModification()
    {
        $client = static::CreateClient ();
        $client->request('GET','/etat/edit/1');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1','Modification d\'un état :');

    }

    public function testDeleteProtection (){
        $client = static::CreateClient ();
        $client->request('GET','/etat/3');
        $this->assertResponseStatusCodeSame(405);
    }

    public function testDeleteRedirection (){
        $client = static::CreateClient ();
        $client->request('DELETE','/etat/3');
        $this->assertResponseRedirects();
    }



    public function testAdd(){

        $client = static::CreateClient ();
        $crawler = $client->request('GET','/etat');
        $form = $crawler->selectButton('Ajouter')->form([
            'etat[nom]' =>  'Excellent',
            'etat[valeur]'    =>  5,
        ]);

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('.btn.btn-secondary');

    }



}
