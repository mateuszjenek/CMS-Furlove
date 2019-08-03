<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Post;
use App\Entity\PostImage;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/admin/post", name="post")
     */
    public function index(Request $request)
    {
        $items = $this->getDoctrine()->getRepository(Post::class)->findAll();

        return $this->render('admin/post/index.html.twig', [
            'title' => 'Posty',
            'editController' => 'post_edit',
            'items' => $items,
            'imageDir' => 'uploads/post/'
        ]);
    }


    /**
     * @Route("/admin/post/add", name="post_add")
     */
    public function add(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->add('uploadedImages', FileType::class, [
            'multiple' => true,
            'label' => 'Zdjęcia',
            'label_attr' => ['class' => 'd-block'],
            'attr' => ['class' => 'mb-3 img-upload'],
            'mapped' => false
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var Post $post */
            $post = $form->getData();
            $uploadedImages = $form->get('uploadedImages')->getData();

            foreach ($uploadedImages as $uploadedImage) {
                $image = new Image();

                $filename = sha1(uniqid(mt_rand(), true)) . '.' . $uploadedImage->guessExtension();
                $image->setFilePath($filename);
                $uploadedImage->move($this->getParameter('post_images_dir'), $filename);

                $postImage = new PostImage();
                $postImage
                    ->setImage($image)
                    ->setPost($post);

                $post->addImage($postImage);

                unset($uploadedImage);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post');
        }

        return $this->render('admin/post/add/index.html.twig', [
            'title' => "Dodaj post",
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/post/edit/{id}", name="post_edit")
     */
    public function edit(Request $request, $id)
    {
        /* @var \App\Entity\Post $post */
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $images = $post->getImages();
        $form = $this->createForm(PostType::class, $post);

        $formFields = [];

        /* @var PostImage $image */
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
            'label' => 'Dodaj zdjęcia',
            'label_attr' => ['class' => 'd-block'],
            'attr' => ['class' => 'mb-3 img-upload'],
            'mapped' => false,
            'required' => false,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $uploadedImages = $form->get('uploadedImages')->getData();

            /* @var PostImage $image */
            foreach ($images as $image) {
                $isChcecked = $form->get($image->getImage()->getId())->getData();
                dump($isChcecked);
                if ($isChcecked) $post->removeImage($image);
            }

            foreach ($uploadedImages as $uploadedImage) {
                $image = new Image();

                $filename = sha1(uniqid(mt_rand(), true)) . '.' . $uploadedImage->guessExtension();
                $image->setFilePath($filename);
                $uploadedImage->move($this->getParameter('post_images_dir'), $filename);

                $postImage = new PostImage();
                $postImage
                    ->setImage($image)
                    ->setPost($post);

                $post->addImage($postImage);

                unset($uploadedImage);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post');
        }

        return $this->render('admin/post/edit/index.html.twig', [
            'title' => "Edytuj post",
            'form' => $form->createView(),
            'imageDir' => 'uploads/post/',
            'formFields' => $formFields,
        ]);
    }
}
