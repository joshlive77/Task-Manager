<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TaskType;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskController extends AbstractController
{
    public function index()
    {
        // prueba de entidades y relacion
        $em = $this->getDoctrine()->getManager();
        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $task_repo->findAll();

        $user_repo = $this->getDoctrine()->getRepository(User::class);
        $users = $user_repo->findBy([], ['id' => 'DESC']);
        // $users = $users->getTasks();

        // foreach ($tasks as $task) {
        //     echo $task->getUser()->getEmail().': '.$task->getTitle()."<br>";
        // }
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
            'tasks' => $tasks,
            'usuarios' => $users
        ]);
    }

    public function detail(Task $task){
        if (!$task) {
            return $this->redirectToRoute('tasks');
        }
        else{
            return $this->render('task/detail.html.twig', [
                'task' => $task
            ]);
        }
    }

    public function creation(Request $request, UserInterface $user){
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $task->setCreatedAt(new \DateTime('now'));
            $task->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('task_detail', ['id' => $task->getId()])
            );
        }
        return $this->render('task/creation.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function myTasks(UserInterface $user){
        $tasks = $user->getTasks();
        return $this->render('task/my-tasks.html.twig', [
            'tasks' => $tasks
        ]);
    }

    public function edit(Request $request, UserInterface $user, Task $task){
        if (!$user || $user->getId() != $task->getUser()->getId()) {
            return $this->redirectToRoute('tasks');
        }
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // $task->setCreatedAt(new \DateTime('now'));
            // $task->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('task_detail', ['id' => $task->getId()])
            );
        }
        return $this->render('task/creation.html.twig',[
            'edit' => true,
            'form' => $form->createView()
        ]);       
    }

    public function delete(Task $task, UserInterface $user){
        if (!$user || $user->getId() != $task->getUser()->getId()) {
            return $this->redirectToRoute('tasks');
        }
        if (!$task) {
            return $this->redirectToRoute('tasks');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('tasks');
    }
}
