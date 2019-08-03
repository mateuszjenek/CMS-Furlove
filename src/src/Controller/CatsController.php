<?php

namespace App\Controller;

use App\Entity\Cat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CatsController extends AbstractController
{
    /**
     * @Route("/cats", name="cats")
     */
    public function index()
    {
        $cats = $this->getDoctrine()->getRepository(Cat::class)->findBy(['isOur' => true]);

        return $this->render('cats/index.html.twig', [
            'cats' => $cats,
        ]);
    }

    /**
     * @Route("/cats/{id}", name="cat_detail")
     */
    public function detail($id)
    {
        $cat = $this->getDoctrine()->getRepository(Cat::class)->find($id);

        return $this->render('cats/detail.html.twig', [
            'cat' => $cat,
        ]);
    }
}
