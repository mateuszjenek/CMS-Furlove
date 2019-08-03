<?php

namespace App\Controller;

use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $message = new Message();
        $form = $this->createFormBuilder($message)
            ->add('senderName', TextType::class, [
                'label' => 'Nazwa',
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('senderEmail', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Wiadomość',
                'attr' => [
                    'class' => 'form-control mb-2',
                    'rows' => '5'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Wyślij',
                'attr' => ['class' => 'btn btn-primary mb-5']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            /* @var Message $message */
            $message = $form->getData();

            $mail = (new \Swift_Message('FurLove | '.$message->getSenderName()))
                ->setFrom($message->getSenderEmail())
                ->setTo('furlove.pl@gmail.com')
                ->setBody($message->getMessage(),'text/plain'
                );

            $mailer->send($mail);

            return $this->render('contact/index.html.twig', [
                'form' => $form->createView(),
                'sended' => true
            ]);
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
