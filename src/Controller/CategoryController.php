<?php

namespace App\Controller;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function postCategory(Request $request, ManagerRegistry $doctrine, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('category');
        }

        return $this->render('category/index.html.twig', [
            'form' => $form->createView(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}
