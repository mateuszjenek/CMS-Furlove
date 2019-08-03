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

class KittenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Imię',
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('sex', ChoiceType::class, [
                'choices'  => [
                    'Chłopczyk' => 'M',
                    'Dziewczynka' => 'F',
                ],
                'label' => 'Płeć',
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('state', ChoiceType::class, [
                'choices'  => [
                    'Szuka domu' => 0,
                    'Zarezerwowany' => 1,
                    'Zarezerwowany - Wpłacona zaliczka' => 2,
                ],
                'label' => 'Stan',
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('stateMessage', TextType::class, [
                'label' => 'Opis stanu',
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('weight', NumberType::class, [
                'label' => 'Waga',
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'Data urodzenia'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Opis kotka',
                'attr' => [
                    'class' => 'form-control mb-2',
                    'rows' => '5'
                ]
            ])
            ->add('isDisplay', CheckboxType::class, [
                'label' => 'Czy wyświetlać? ',
                'required' => false,
                'attr' => ['class' => 'ml-3']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Wyślij',
                'attr' => ['class' => 'btn btn-primary mb-5']
            ]);
    }

}