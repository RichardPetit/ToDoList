<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Me connecter')->form();
        $this->client->submit($form, ['email' => 'richard-petit@live.fr', 'password' => 'password']);
    }

    public function testList(): void
    {
        $this->loginUser();
        $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testEdit()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/users/3/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'test';
        $form['user[password][first]'] = 'password';
        $form['user[email]'] = 'test@gmail.fr';
        $form['user[roles][0]']->tick();
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

}