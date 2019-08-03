<?php
/**
 * Created by PhpStorm.
 * User: jenek
 * Date: 2019-02-23
 * Time: 15:06
 */

namespace App\Form;


use App\Entity\Cat;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LitterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('litter', TextType::class, [
                'label' => 'Oznaczenie miotu',
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('mother', EntityType::class, [
                'label' => 'Matka',
                'attr' => ['class' => 'form-control mb-2'],
                'choice_label' => 'name',
                'class' => Cat::class,
                'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->where("c.sex = 'F'");
                }
            ])
            ->add('father', EntityType::class, [
                'label' => 'Ojciec',
                'attr' => ['class' => 'form-control mb-2'],
                'choice_label' => 'name',
                'class' => Cat::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where("c.sex = 'M'");
                }
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Wyślij',
                'attr' => ['class' => 'btn btn-primary mb-5']
            ]);
    }
}