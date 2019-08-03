<?php
/**
 * Created by PhpStorm.
 * User: jenek
 * Date: 2019-02-19
 * Time: 12:48
 */

namespace App\Form;


use App\Entity\Litter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'nazwa',
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('link', TextType::class, [
                'label' => 'Strona WWW',
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Opis',
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