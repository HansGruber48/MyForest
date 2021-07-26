<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
     /**
     * @Route("/", name="home")
     */
    public function home(PostRepository $postRepository): Response
    {
        
            $posts = $postRepository->findAll();                 
             return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController home',
            'posts'=>  $posts,
                       
        ]);
    }
       /**
     * @Route("/post", name="post_home")
     */
    public function posts(PostRepository $postRepository): Response
    {
        
       $posts = $postRepository->findAll();
                            
             return $this->render('post/post.html.twig', [
            'controller_name' => 'PostController home',
            'posts'=>  $posts,
            
        ]);
    }
 
    

    /**
     * @Route("/post/{slug}", name="post_view",methods={"GET"})
     */
    public function view(Post $post): Response
    { 
                    
        return $this->render('post/view.html.twig', [
            'post' => $post,
         //'bg_image' => $posts->getImage(),
        
        ]);
    }

    
    /**
     * @Route("/form", name="formulaire")
     */

    public function add_article(Request $request): Response
    { 
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $post->setUser($this->getUser());
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }     
        return $this->render('post/form.html.twig', [
            'post' => $post,
            'form' => $form->createView()
       //  'bg_image' => $posts->getImage(),
            //'oldposts' => $oldposts,
        ]);
    }
  }
