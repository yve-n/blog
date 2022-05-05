<?php

namespace App\Controller;
use App\Entity\Post;
use App\Form\PostType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function postCategory(Request $request, ManagerRegistry $doctrine, PostRepository $postRepository): Response
    {
        $post = new Post();
        $post->setCreatedAt(date('Y-m-d'));
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('post');
        }

        return $this->render('post/index.html.twig', [
            'form' => $form->createView(),
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/post/delete/{id}", name="delete_post")
     */
    public function deletePost(Request $request, ManagerRegistry $doctrine, PostRepository $postRepository): Response
    {
        $post = $postRepository->findOneBy(['id'=> $request->get('id')]);
        if($post){
            $postRepository->remove($post);

            return $this->redirectToRoute('category');
        }
        return $this->render('post/index.html.twig', []);
    }

    /**
     * @Route("/post/update/{id}", name="update_post")
     */
    public function updatePost(Request $request, ManagerRegistry $doctrine, PostRepository $postRepository): Response
    {
        $post = $postRepository->findOneBy(['id'=> $request->get('id')]);

        if($post){
            $formUpdatePost = $this->createForm(PostType::class, $post);
            $formUpdatePost->handleRequest($request);

            if($formUpdatePost->isSubmitted() && $formUpdatePost->isValid()) {
                $em = $doctrine->getManager();
                $em->persist($formUpdatePost->getData());
                $em->flush();

                return $this->redirectToRoute('post');
            }
        } else {
            return $this->redirectToRoute('post');
        }

        return $this->render('post/edit.html.twig', [
            'formUpdatePost' => $formUpdatePost->createView(),
        ]);
    }
}
