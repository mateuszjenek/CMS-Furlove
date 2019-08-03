<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StrainController extends AbstractController
{
    /**
     * @Route("/strain", name="strain")
     */
    public function index()
    {
        return $this->render('strain/index.html.twig', [
            'controller_name' => 'StrainController',
        ]);
    }
}
