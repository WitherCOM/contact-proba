<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ContactController extends AbstractController
{

    public function index(): Response
    {
        $contact = new Contact();

        $form = $this->createFormBuilder($contact)
        ->add('name',TextType::class,['label'=>'Neved'])
        ->add('email',EmailType::class,['label'=>'E-mail címed'])
        ->add('text',TextareaType::class,['label'=>'Üzenet szövege'])
        ->add('send',SubmitType::class,['label'=>'Küldés'])
        ->setMethod('post')
        ->getForm();

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function contact(Request $request): Response
    {
        $contact = new Contact();

        $form = $this->createFormBuilder($contact)
        ->add('name',TextType::class,['label'=>'Neved'])
        ->add('email',EmailType::class,['label'=>'E-mail címed'])
        ->add('text',TextareaType::class,['label'=>'Üzenet szövege'])
        ->add('send',SubmitType::class,['label'=>'Küldés'])
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            $contact = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('index',['okay']);
        }

        return $this->redirectToRoute('index',['notokay']);
    }


}
