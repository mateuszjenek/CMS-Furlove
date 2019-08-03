<?php

namespace App\Controller;

use App\Entity\Kitten;
use App\Entity\Partner;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * TODO: Add links to partners
     */
    public function index()
    {
        $kittens = $this->getDoctrine()->getRepository(Kitten::class)->findBy(['isDisplay' => true]);

        $partners = $this->getDoctrine()->getRepository(Partner::class)->findAll();

        $posts = $this->getDoctrine()->getRepository(Post::class)->findBy([],['id'=>'DESC'],2,0);

        return $this->render('home/index.html.twig', [
            'kittens' => $kittens,
            'partners' => $partners,
            'posts' => $posts,
        ]);
    }
}
