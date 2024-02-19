<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Tache;
use App\Entity\Category;
use Symfony\Component\Translation\LocaleSwitcher;

class MainController extends AbstractController
{
    

    #[Route('/{_locale}', name: 'app_main')]
    public function accueil(): Response
    {
        
        
        return $this->render('main/index.html.twig');
    }
    // pour afficher element tache dans la table
    #[Route('/{_locale}/tasks', name: 'app_task')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tasks = $entityManager->getRepository(Tache::class)->findBy(['user'=>$this->getUser()]);
        
        return $this->render('tasks/task.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/{_locale}/category', name: 'app_category')]
    public function category(EntityManagerInterface $entityManager): Response
    {
        $category = $entityManager->getRepository(Category::class)->findAll();
        
        return $this->render('add_category/category.html.twig', [
            'category' => $category,
            
        ]);
    }


    

    

}
