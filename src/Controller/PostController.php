<?php

namespace App\Controller;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="app_post")
     */
    public function index(PostRepository $postRepository): Response
    {
        $user_id = 1;
        $post = $postRepository->findByUser_id($user_id);
        $posts = $postRepository->findAll();
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'posts'           => $post,
            'all'             => $posts
        ]);
    }
}
