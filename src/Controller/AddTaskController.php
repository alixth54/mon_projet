<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Entity\User;
use App\Form\TacheType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddTaskController extends AbstractController
{
    #[Route('/{_locale}/add/task', name: 'app_add_task')]
    public function addTask(Request $request, EntityManagerInterface $entity): Response
    {
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $tache->setUser($this->getUser());
            // $tache->setUser();
            $entity->persist($tache);
            $entity->flush();

            return $this->redirectToRoute('app_task',[$this->addFlash(
                'success',
                'ajout de la tâche réussi'
            )]);
        }

        return $this->render('tasks/index.html.twig', [
            'controller_name' => 'AddTaskController',
            'form'=>$form->createView(),
            
        ]);
    }

    // pour supprimer element tache dans la table
    #[Route('/{_locale}/main/{id}', name: 'app_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $task = $entityManager->getRepository(Tache::class)->find($id);
            $entityManager->remove($task);
            $entityManager->flush();
        
    
    return $this->redirectToRoute('app_task',[
    $this->addFlash(
        'success',
        'suppression de la tâche réussie')
    ]);
    
}

#[Route('/{_locale}/edit/task/{id}', name: 'app_edit_task')]
    public function editTask(Request $request, EntityManagerInterface $entity, int $id): Response
    {
        $tache = $entity->getRepository(Tache::class)->find($id);
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entity->persist($tache);
            $entity->flush();
            return $this->redirectToRoute('app_task',[$this->addFlash(
                'success',
                'modification de la tâche réussie'
            )]);
        }

        return $this->render('tasks/index.html.twig', [
            'controller_name' => 'AddTaskController',
            'form'=>$form->createView(),
            
        ]);
    }
}
