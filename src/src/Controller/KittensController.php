<?php

namespace App\Controller;

use App\Entity\Kitten;
use App\Entity\Litter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class KittensController extends AbstractController
{
    /**
     * @Route("/kittens", name="kittens")
     */
    public function index()
    {
        /**
         * @var Litter[] $litters
         */
        $litters = $this->getDoctrine()->getRepository(Litter::class)->findAll();

        usort($litters, function ($a, $b) {
            /**
             * @var Litter $a
             * @var Litter $b
             */
            $a = $a->getLitter();
            $b = $b->getLitter();

           if (strlen($a) > strlen($b)) return -1;
           else if (strlen($a) == strlen($b)) return $a < $b;
           else return 1;
        });

        return $this->render('kittens/index.html.twig', [
            'controller_name' => 'KittensController',
            'litters' => $litters,
        ]);
    }

    /**
     * TODO: Add KittenVideo Entity
     * @Route("/kittens/{id}", name="kitten_detail")
     */
    public function detail($id)
    {
        /* @var Kitten */
        $kitten = $this->getDoctrine()->getRepository(Kitten::class)->find($id);
        return $this->render('kittens/detail.html.twig', [
            'kitten' => $kitten,
        ]);
    }
}
