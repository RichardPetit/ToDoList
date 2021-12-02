<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class TaskController extends AbstractController
{
    /**
     * @param EntityManagerInterface $em
     * @return Response
     */
    #[Route('/tasks', name: 'task_list')]
    public function list(EntityManagerInterface $em): Response
    {
        return $this->render('task/list.html.twig', [
            'tasks' => $em->getRepository('App:Task')->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @param Security $security
     * @param EntityManagerInterface $em
     * @return mixed
     */
    #[Route('/tasks/create', name: 'task_create')]
    public function create(Request $request, Security $security, EntityManagerInterface $em)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task->setAuthor($security->getUser());
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Task $task
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return mixed
     */
    #[Route('/tasks/{id}/edit', name: 'task_edit')]
    public function edit(Task $task, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @param Task $task
     * @param EntityManagerInterface $em
     * @return mixed
     */
    #[Route('/tasks/{id}/toggle', name: 'task_toggle')]
    public function toggle(Task $task, EntityManagerInterface $em)
    {
        $task->toggle(!$task->isDone());
//        $this->getDoctrine()->getManager()->flush();
        $em->persist($task);
        $em->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @param Task $task
     * @param EntityManagerInterface $em
     * @return mixed
     */
    #[Route('/tasks/{id}/delete', name: 'task_delete')]
    public function delete(Task $task, EntityManagerInterface $em)
    {
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
