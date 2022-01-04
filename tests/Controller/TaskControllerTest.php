<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Task;


class TaskControllerTest extends WebTestCase
{
    private $client;
    private int $taskId;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->initTask();
    }

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Me connecter')->form();
        $this->client->submit($form, ['_username' => 'richard-petit@live.fr', '_password' => 'password']);
    }

    public function testList()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreate()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Titre de la tâche';
        $form['task[content]'] = 'Contenu de la tâche';
        $this->client->submit($form);


        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testEdit()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/tasks/'.$this->taskId.'/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Titre de la tâche';
        $form['task[content]'] = 'Contenu de la tâche';
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testDelete()
    {
        $this->loginUser();

        $this->client->request('GET', '/tasks/'.$this->taskId.'/delete');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    /**
     * @return void
     */
    public function initTask(): void
    {

        $container = $this->client->getContainer();
        $manager = $container->get('doctrine')->getManager();
        $taskRepository = $manager->getRepository(Task::class);
        $task = $taskRepository->getLastTask();
        
        $this->taskId = $task->getId();
    }

}
