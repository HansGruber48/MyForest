<?php

namespace App\Controller\admin;

use App\Form\PostType;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    /**
    * @Route("/admin", name="admin_home")
    */

    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/post/add", name="post_add")
     */
    public function addPost(Request $request): Response
    {

        $post = new Post();

        //dd($category);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          // init user value par dfault
          //connected
          //Active a false

            $post->setUser($this->getUser());
            $post->setActive(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('home');
        } 

        return $this->render('admin/add.html.twig', [
            'form' => $form->createView(),]);
    }

}

