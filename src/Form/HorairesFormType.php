<?php

namespace App\Form;

use App\Entity\Horaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType as TypeTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HorairesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DayWeek')
            ->add('hourly', TypeTimeType::class, [
                'placeholder' => [
                    'hour' => 'Hour', 'minute' => 'Minute', 
                ],
            ])
            ->add('hourlyAfter', TypeTimeType::class, [
                'placeholder' => [
                    'hour' => 'Hour', 'minute' => 'Minute', 
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Horaires::class,
        ]);
    }
}
