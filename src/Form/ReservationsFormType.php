<?php

namespace App\Form;

use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('eamil')
            ->add('Name')
            ->add('LastName')
            ->add('nbcouverts')
            ->add('scheduledTime')
            ->add('mentions_allergene')
            ->add('ReservationUsers')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
