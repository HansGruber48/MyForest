<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PageController extends AbstractController
{
    /**
     * @Route("/about", name="page_about")
     */
    public function about(): Response
    {
        return $this->render('page/about.html.twig', [
            'controller_name' => 'PageController About',
        ]);
    }
    /**
     * @Route("/contact", name="page_contact")
     */
    public function contact(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('page/contact.html.twig', [
            'controller_name' => 'PageController Contact',
            'contactForm' => $form->createView(),
        ]);
    }
}
