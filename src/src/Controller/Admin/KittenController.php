<?php

namespace App\Controller\Admin;

use App\Entity\Cat;
use App\Entity\Image;
use App\Entity\Kitten;
use App\Entity\KittenImage;
use App\Entity\Litter;
use App\Form\KittenType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class KittenController extends AbstractController
{
    /**
     * @Route("/admin/kitten", name="kitten")
     */
    public function index()
    {
        $kittens = $this->getDoctrine()->getRepository(Kitten::class)->findAll();

        return $this->render('admin/kitten/index.html.twig', [
            'title' => 'Kocięta',
            'editController' => 'kitten_edit',
            'items' => $kittens,
            'imageDir' => 'uploads/kitten/'
        ]);
    }

    /**
     * @Route("/admin/kitten/add", name="kitten_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request)
    {
        $kitten = new Kitten();
        $form = $this->getForm($kitten);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var Kitten $kitten */
            $kitten = $form->getData();
            $uploadedImages = $form->get('uploadedImages')->getData();
            $litterId = $form->get('litter')->getData();
            $litterMother = $form->get('litterMother')->getData();
            $litterFather = $form->get('litterFather')->getData();
            $litterName = $form->get('litterName')->getData();

            $this->addImages($uploadedImages, $kitten);
            $this->setShortDescription($kitten);
            $this->setLitter($litterId, $litterName, $litterMother, $litterFather, $kitten);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($kitten);
            $entityManager->flush();

            return $this->redirectToRoute('kitten');
        }

        return $this->render('admin/kitten/add/index.html.twig', [
            'title' => "Dodaj kocię",
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/kitten/edit/{id}", name="kitten_edit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, $id)
    {
        $kitten = $this->getDoctrine()->getRepository(Kitten::class)->find($id);
        $form = $this->getForm($kitten);
        $images = $kitten->getImages();
        $formFields = [];

        /* @var KittenImage $image */
        foreach ($images as $image) {
            $form->add($image->getImage()->getId(), CheckboxType::class, [
                'label_attr' => ['class' => 'image'],
                'mapped' => false,
                'required' => false,
            ]);
            $formFields[$image->getImage()->getFilePath()] = $image->getImage()->getId();
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var Kitten $kitten */
            $kitten = $form->getData();
            $uploadedImages = $form->get('uploadedImages')->getData();
            $litterId = $form->get('litter')->getData();
            $litterMother = $form->get('litterMother')->getData();
            $litterFather = $form->get('litterFather')->getData();
            $litterName = $form->get('litterName')->getData();

            /* @var KittenImage $image */
            foreach ($images as $image) {
                $isChecked = $form->get($image->getImage()->getId())->getData();
                if ($isChecked) $kitten->removeImage($image);
            }

            $this->addImages($uploadedImages, $kitten);
            $this->setShortDescription($kitten);
            $this->setLitter($litterId, $litterName, $litterMother, $litterFather, $kitten);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($kitten);
            $entityManager->flush();

            return $this->redirectToRoute('kitten');
        }

        return $this->render('admin/kitten/edit/index.html.twig', [
            'title' => "Edytuj kocię",
            'form' => $form->createView(),
            'imageDir' => 'uploads/kitten/',
            'formFields' => $formFields,
        ]);
    }

    /**
     * @return array
     */
    private function getLitterChoices(): array
    {
        $litters = $this->getDoctrine()->getRepository(Litter::class)->findAll();
        $litterChoices = [];
        foreach ($litters as $litter)
            $litterChoices[$litter->getLitter()] = $litter->getId();
        $litterChoices['nowy'] = -1;
        return $litterChoices;
    }

    /**
     * @param string $sex
     * @return array
     */
    private function getCatsChoices(string $sex): array
    {
        $cats = $this->getDoctrine()->getRepository(Cat::class)->findBy(['sex' => $sex]);
        $catsChoices = [];
        foreach ($cats as $cat)
            $catsChoices[$cat->getName()] = $cat->getId();
        return $catsChoices;
    }

    /**
     * @param array $uploadedImages
     * @param Kitten $kitten
     */
    private function addImages(array $uploadedImages, Kitten $kitten): void
    {
        /* @var File $uploadedImage */
        foreach ($uploadedImages as $uploadedImage) {
            $image = new Image();

            $filename = sha1(uniqid(mt_rand(), true)) . '.' . $uploadedImage->guessExtension();
            $image->setFilePath($filename);
            $uploadedImage->move($this->getParameter('kitten_images_dir'), $filename);

            $kittenImage = new KittenImage();
            $kittenImage
                ->setImage($image)
                ->setKitten($kitten);

            $kitten->addImage($kittenImage);

            unset($uploadedImage);
        }
    }

    /**
     * @param Kitten $kitten
     */
    private function setShortDescription(Kitten $kitten): void
    {
        if (strlen($kitten->getDescription()) > 100)
            $kitten->setShortDescription(mb_substr($kitten->getDescription(), 0, 100) . "...");
        else
            $kitten->setShortDescription($kitten->getDescription());
    }

    /**
     * @param int $litter
     * @return bool
     */
    private function isUserChooseNewLitter(int $litter): bool
    {
        return $litter == -1;
    }

    /**
     * @param string $litterName
     * @param string $litterMother
     * @param string $litterFather
     * @return Litter
     */
    private function createNewLitter(string $litterName, string $litterMother, string $litterFather): Litter
    {
        /**
         * @var Cat $mother
         * @var Cat $father
         */

        $catRepo = $this->getDoctrine()->getRepository(Cat::class);
        $mother = $catRepo->find($litterMother);
        $father = $catRepo->find($litterFather);
        $litter = (new Litter)
            ->setLitter($litterName)
            ->setMother($mother)
            ->setFather($father);
        return $litter;
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function getForm($kitten) : \Symfony\Component\Form\FormInterface
    {
        $form = $this->createForm(KittenType::class, $kitten);
        $form
            ->add('litter', ChoiceType::class, [
                'choices' => $this->getLitterChoices(),
                "mapped" => false,
                'label' => 'Miot',
                'attr' => ['class' => 'form-control mb-2 litter']
            ])
            ->add('litterMother', ChoiceType::class, [
                'choices' => $this->getCatsChoices('F'),
                "mapped" => false,
                'label' => 'Matka',
                'attr' => ['class' => 'form-control mb-2 newLitter'],
                'label_attr' => ['class' => 'newLitter'],
            ])
            ->add('litterFather', ChoiceType::class, [
                'choices' => $this->getCatsChoices('M'),
                'label' => 'Ojciec',
                "mapped" => false,
                'attr' => ['class' => 'form-control mb-2 newLitter'],
                'label_attr' => ['class' => 'newLitter'],
            ])
            ->add('litterName', TextType::class, [
                'label' => 'Oznaczenie miotu',
                "mapped" => false,
                'attr' => ['class' => 'form-control mb-2 newLitter'],
                'label_attr' => ['class' => 'newLitter'],
            ])
            ->add('uploadedImages', FileType::class, [
                'mapped' => false,
                'multiple' => true,
                'label' => 'Zdjęcia',
                'label_attr' => ['class' => 'd-block'],
                'attr' => ['class' => 'mb-3 img-upload']
            ]);
        return $form;
    }

    /**
     * @param int $litterId
     * @param string $litterName
     * @param string $litterMother
     * @param string $litterFather
     * @param Kitten $kitten
     */
    private function setLitter(int $litterId, ?string $litterName, string $litterMother, string $litterFather, Kitten $kitten): void
    {
        /* @var ?Litter $litter */
        $litter = null;
        if ($this->isUserChooseNewLitter($litterId)) {
            if ($litterName == null) {
                assert("LitterName is null");
            }
            $litter = $this->createNewLitter($litterName, $litterMother, $litterFather);
        } else {
            $litter = $this->getDoctrine()->getRepository(Litter::class)->find($litterId);

        }
        $kitten->setLitter($litter);
    }
}
