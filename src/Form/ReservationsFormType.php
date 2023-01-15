<?php

namespace App\Form;

use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                ])
            ->add('Name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                ])
            ->add('LastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                ])
            ->add('nbcouverts')
            ->add('scheduledTime', DateTimeType::class, [
                'date_label' => 'Starts On',
                ])
            ->add('mentions_allergene', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                ])
            ->add('UserResa')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
