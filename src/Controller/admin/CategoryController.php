<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    
     /**
      * @Route("admin/category/add", name="admin_category_add")
     */
 
     public function addCategory(Request $request): Response
    {

        $category = new Category();

        //dd($category);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
       // dd($form);
       $em = $this->getDoctrine()->getManager();
        // dd($category);
        $em->persist($category);
        $em->flush();

        return $this->redirectToRoute('home');

    }
        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView(),]);
    }
     /**
      * @Route("admin/category", name="admin_category")
     */ 
    public function index(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll(); 
        return $this->render('admin/category/index.html.twig', [
            'categories' => $category,
        ]);
    }
     /**
      * @Route("admin/category/modify/{id}", name="admin_category_modify",requirements={"id"="\d+"})
     */
 
    public function modifyCategory(Category $category,Request $request): Response
    {

        //dd($category);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
       // dd($form);
       $em = $this->getDoctrine()->getManager();
        // dd($category);
        $em->persist($category);
        $em->flush();

        return $this->redirectToRoute('admin_category');

    }
        return $this->render('admin/category/modify.html.twig', [
            'form' => $form->createView(),]);
    }
     /**
      * @Route("admin/category/delete/{id}", name="admin_category_delete",requirements={"id"="\d+"})
     */
 
    public function deleteCategory(Category $category): Response
    {

        $em=$this->getDoctrine()->getManager();
        $em->remove($category);        
        $em->flush();

        return $this->redirectToRoute('admin_category');

    
    }
}
