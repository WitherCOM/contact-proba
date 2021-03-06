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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

class ContactController extends AbstractController
{

    public function index(SessionInterface $session): Response
    {
        $form = $this->createFormBuilder($session->get('formData'))
        ->add('name',TextType::class,['label'=>'Neved','required' => false])
        ->add('email',EmailType::class,['label'=>'E-mail címed','required' => false])
        ->add('text',TextareaType::class,['label'=>'Üzenet szövege','required' => false])
        ->add('send',SubmitType::class,['label'=>'Küldés'])
        ->setMethod('post')
        ->getForm();
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function contact(SessionInterface $session,Request $request): Response
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
            $this->addFlash('notice','okay');
            return $this->redirectToRoute('index');
        }
        $tempData = $form->getData();
        $session->set('formData',$tempData);
        $this->addFlash('notice','notokay');
        return $this->redirectToRoute('index',);
    }


}
