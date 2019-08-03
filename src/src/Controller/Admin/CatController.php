<?php

namespace App\Controller\Admin;

use App\Entity\Cat;
use App\Entity\CatImage;
use App\Entity\Image;
use App\Form\CatType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CatController extends AbstractController
{
    /**
     * @Route("/admin/cat", name="cat")
     */
    public function index(Request $request)
    {
        $cats = $this->getDoctrine()->getRepository(Cat::class)->findAll();

        return $this->render('admin/cat/index.html.twig', [
            'title' => 'Moje koty',
            'editController' => 'cat_edit',
            'items' => $cats,
            'imageDir' => 'uploads/cat/'
        ]);
    }

    /**
     * @Route("/admin/cat/add", name="cat_add")
     */
    public function add(Request $request)
    {
        $cat = new Cat();
        $form = $this->createForm(CatType::class, $cat);
        $form->add('uploadedImages', FileType::class, [
            'multiple' => true,
            'label' => 'Zdjęcia',
            'label_attr' => ['class' => 'd-block'],
            'attr' => ['class' => 'mb-3 img-upload'],
            'mapped' => false
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cat = $form->getData();
            $uploadedImages = $form->get('uploadedImages')->getData();

            foreach ($uploadedImages as $uploadedImage) {
                $image = new Image();

                $filename = sha1(uniqid(mt_rand(), true)) . '.' . $uploadedImage->guessExtension();
                $image->setFilePath($filename);
                $uploadedImage->move($this->getParameter('cat_images_dir'), $filename);

                $postImage = new CatImage();
                $postImage
                    ->setImage($image)
                    ->setCat($cat);

                $cat->addImage($postImage);

                unset($uploadedImage);
            }

            if (strlen($cat->getDescription()) > 100)
                $cat->setShortDescription(mb_substr($cat->getDescription(), 0, 100) . "...");
            else
                $cat->setShortDescription($cat->getDescription());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cat);
            $entityManager->flush();

            return $this->redirectToRoute('cat');
        }

        return $this->render('admin/cat/add/index.html.twig', [
            'title' => 'Dodaj kota',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/cat/edit/{id}", name="cat_edit")
     */
    public function edit(Request $request, $id)
    {
        $cat = $this->getDoctrine()->getRepository(Cat::class)->find($id);
        $images = $cat->getImages();
        $form = $this->createForm(CatType::class, $cat);

        $formFields = [];

        foreach ($images as $image) {
            $form->add($image->getImage()->getId(), CheckboxType::class, [
                'label_attr' => ['class' => 'image'],
                'mapped' => false,
                'required' => false,
            ]);
            $formFields[$image->getImage()->getFilePath()] = $image->getImage()->getId();
        }

        $form->add('uploadedImages', FileType::class, [
            'multiple' => true,
            'label' => 'Zdjęcia',
            'label_attr' => ['class' => 'd-block'],
            'attr' => ['class' => 'mb-3 img-upload'],
            'mapped' => false
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cat = $form->getData();
            $uploadedImages = $form->get('uploadedImages')->getData();

            /* @var PartnerImage $image */
            foreach ($images as $image) {
                $isChecked = $form->get($image->getImage()->getId())->getData();
                if ($isChecked) $cat->removeImage($image);
            }

            foreach ($uploadedImages as $uploadedImage) {
                $image = new Image();

                $filename = sha1(uniqid(mt_rand(), true)) . '.' . $uploadedImage->guessExtension();
                $image->setFilePath($filename);
                $uploadedImage->move($this->getParameter('cat_images_dir'), $filename);

                $postImage = new CatImage();
                $postImage
                    ->setImage($image)
                    ->setCat($cat);

                $cat->addImage($postImage);

                unset($uploadedImage);
            }

            if (strlen($cat->getDescription()) > 100)
                $cat->setShortDescription(mb_substr($cat->getDescription(), 0, 100) . "...");
            else
                $cat->setShortDescription($cat->getDescription());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cat);
            $entityManager->flush();

            return $this->redirectToRoute('cat');
        }

        return $this->render('admin/cat/edit/index.html.twig', [
            'title' => 'Edytuj kota',
            'form' => $form->createView(),
            'imageDir' => 'uploads/cat/',
            'formFields' => $formFields,
        ]);
    }
}
