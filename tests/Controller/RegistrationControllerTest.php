<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class RegistrationControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Connexion')->form();
        $this->client->submit($form, ['email' => 'richard-petit@live.fr', 'password' => 'password']);
    }

    public function testRegister()
    {
        $this->loginUser();

        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'NouveauTest';
        $form['user[password]'] = 'password';
        $form['user[email]'] = 'tests@tests.com';
        $form['user[roles][0]']->tick();
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

//    public function testRegistration()
//    {
//        $this->assertTrue(true);
//    }
}