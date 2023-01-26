<?php

namespace App\Form;

use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
                'widget' => 'single_text',
                'hours' => function( \DateTime $dateTime) {
                    $dayOfWeek = $dateTime->format('w');
                    switch ($dayOfWeek) {
                        case 0: // Sunday
                            return [11, 12, 13, 18, 19, 20, 21];
                        case 1: // Monday
                            return [12, 13, 14, 15];
                        case 2: // Tuesday
                            return [];
                        case 3: // Wednesday
                            return [18, 19, 20, 21];
                        case 4: // Thursday
                            return [11, 12, 13, 18, 19, 20, 21];
                        case 5: // Friday
                            return [11, 12, 13, 18, 19, 20, 21];
                        case 6: // Saturday
                            return [11, 12, 13, 18, 19, 20, 21];
                    }
                },
                ])
            /*->add('minutes', HiddenType::class, [
                    'data' => '0'
                ])*/
            ->add('mentions_allergene', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
