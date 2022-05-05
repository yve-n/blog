<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function showCategories(PostRepository $postRepository): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }
}
