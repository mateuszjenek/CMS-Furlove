<?php
/**
 * Created by PhpStorm.
 * User: jenek
 * Date: 2019-02-23
 * Time: 15:06
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Tytuł',
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Treść',
                'attr' => [
                    'class' => 'form-control mb-2',
                    'rows' => '5'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Wyślij',
                'attr' => ['class' => 'btn btn-primary mb-5']
            ]);
    }
}