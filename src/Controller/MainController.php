<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Tache;
use App\Entity\Category;
use Symfony\Component\Translation\LocaleSwitcher;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\MyCustomException;

class MainController extends AbstractController
{
    

    #[Route('/{_locale}', name: 'app_main')]
    public function accueil(LoggerInterface $logger): Response
    {
       try{
        $logger->info('connection à la bdd');
        return $this->render('main/index.html.twig');
       } 
       catch(EntityNotFoundException $e){
        $logger->error($e);
       }
         
    }

    // pour afficher element tache dans la table
    #[Route('/{_locale}/tasks', name: 'app_task')]
    public function index(EntityManagerInterface $entityManager, LoggerInterface $logger): Response
    {
    
        try{
        $logger->debug('User {userId} has logged in', [
            'userId' => $this->getUser()->getId()
        ]);
            $tasks = $entityManager->getRepository(Tache::class)->findBy(['user'=>$this->getUser()]);
        
        return $this->render('tasks/task.html.twig', [
            'tasks' => $tasks,
        ]);
        }catch(\Exception $e){
            $logger->error('le message d\'erreur est : {e}', [
                'e' => $e
            ]);
        }
         
            
           
        
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
