<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategoryFormType;
use Doctrine\ORM\EntityManagerInterface;



class CategoryController extends AbstractController
{
    #[Route('/{_locale}/add/category', name: 'app_add_category')]
    public function addCategory(Request $request, EntityManagerInterface $entity): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entity->persist($category);
            $entity->flush();

            return $this->redirectToRoute('app_category',[$this->addFlash(
                'success',
                'ajout de la catégorie réussie'
            )]);
        }

        return $this->render('category/index.html.twig', [
            'controller_name' => 'categoryController',
            'form'=>$form->createView(),
            
        ]);
}

#[Route('/{_locale}/edit/category/{id}', name: 'app_edit_category')]
    public function editCategory(Request $request, EntityManagerInterface $entity, int $id): Response
    {
        $category = $entity->getRepository(Category::class)->find($id);
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entity->persist($category);
            $entity->flush();

            return $this->redirectToRoute('app_category',[$this->addFlash(
                'success',
                'modification de la catégorie réussie'
            )]);
        }

        return $this->render('category/index.html.twig', [
            'controller_name' => 'categoryController',
            'form'=>$form->createView(),
            
        ]);
}

#[Route('/{_locale}/delete/category/{id}', name: 'app_deleteCat')]
public function deleteCat(EntityManagerInterface $entityManager, int $id): Response
{
    $category = $entityManager->getRepository(Category::class)->find($id);
        $entityManager->remove($category);
        $entityManager->flush();
    

return $this->redirectToRoute('app_category',[
$this->addFlash(
    'success',
    'suppression de la catégorie réussie')
]);

}

}