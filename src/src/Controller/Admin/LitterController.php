<?php

namespace App\Controller\Admin;

use App\Entity\Litter;
use App\Form\LitterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LitterController extends AbstractController
{
    /**
     * @Route("/admin/litter", name="litter")
     */
    public function index(Request $request)
    {
        $litters = $this->getDoctrine()->getRepository(Litter::class)->findAll();

        return $this->render('admin/litter/index.html.twig', [
            'title' => 'Mioty',
            'editController' => 'litter_add',
            'items' => $litters,
        ]);
    }

    /**
     * @Route("/admin/litter/add", name="litter_add")
     */
    public function add(Request $request)
    {
        $litter = new Litter();
        $form = $this->createForm(LitterType::class, $litter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $litter = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($litter);
            $entityManager->flush();

            //return $this->redirectToRoute('litter');
        }

        return $this->render('admin/litter/add/index.html.twig', [
            'title' => 'Dodaj Miot',
            'form' => $form->createView()
        ]);
    }
}
