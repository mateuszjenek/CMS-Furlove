<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Partner;
use App\Entity\PartnerImage;
use App\Form\PartnerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PartnerController extends AbstractController
{
    /**
     * @Route("/admin/partner", name="partner")
     */
    public function index()
    {
        $partners = $this->getDoctrine()->getRepository(Partner::class)->findAll();

        return $this->render('admin/partner/index.html.twig', [
            'title' => 'Partnerzy',
            'items' => $partners,
            'editController' => 'partner_edit',
            'imageDir' => 'uploads/partner/',

        ]);
    }

    /**
     * @Route("/admin/partner/add", name="partner_add")
     */
    public function add(Request $request)
    {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);
        $form->add('uploadedImages', FileType::class, [
            'multiple' => true,
            'label' => 'Zdjęcia',
            'label_attr' => ['class' => 'd-block'],
            'attr' => ['class' => 'mb-3 img-upload'],
            'mapped' => false
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partner = $form->getData();
            $uploadedImages = $form->get('uploadedImages')->getData();

            foreach ($uploadedImages as $uploadedImage) {
                $image = new Image();

                $filename = sha1(uniqid(mt_rand(), true)) . '.' . $uploadedImage->guessExtension();
                $image->setFilePath($filename);
                $uploadedImage->move($this->getParameter('partner_images_dir'), $filename);

                $postImage = new PartnerImage();
                $postImage
                    ->setImage($image)
                    ->setPartner($partner);

                /* @var Partner $partner */
                $partner->addImage($postImage);

                unset($uploadedImage);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('partner');
        }
        return $this->render('admin/partner/add/index.html.twig', [
            'title' => 'Dodaj partnera',
            'form' => $form->createView(),
            'imageDir' => 'uploads/partner/'
        ]);
    }

    /**
     * @Route("/admin/partner/edit/{id}", name="partner_edit")
     */
    public function edit(Request $request, $id)
    {
        /* @var Partner $partner */
        $partner = $this->getDoctrine()->getRepository(Partner::class)->find($id);
        $images = $partner->getImages();
        $form = $this->createForm(PartnerType::class, $partner);

        $formFields = [];

        /* @var PartnerImage $image */
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
            $partner = $form->getData();
            $uploadedImages = $form->get('uploadedImages')->getData();

            /* @var PartnerImage $image */
            foreach ($images as $image) {
                $isChecked = $form->get($image->getImage()->getId())->getData();
                if ($isChecked) $partner->removeImage($image);
            }

            foreach ($uploadedImages as $uploadedImage) {
                $image = new Image();

                $filename = sha1(uniqid(mt_rand(), true)) . '.' . $uploadedImage->guessExtension();
                $image->setFilePath($filename);
                $uploadedImage->move($this->getParameter('partner_images_dir'), $filename);

                $partnerImage = new PartnerImage();
                $partnerImage
                    ->setImage($image)
                    ->setPartner($partner);

                /* @var Partner $partner */
                $partner->addImage($partnerImage);

                unset($uploadedImage);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('partner');
        }

        return $this->render('admin/partner/edit/index.html.twig', [
            'title' => "Edytuj Partnera",
            'form' => $form->createView(),
            'imageDir' => 'uploads/partner/',
            'formFields' => $formFields,
        ]);
    }
}
