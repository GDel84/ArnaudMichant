<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'E-mail'
            ])
            ->add('mentionsAllergene', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                ])
            ->add('nbCouverts', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-select'
                ],
                'choices'  => [
                    '01' => null,
                    '02' => true,
                    '03' => false,
                    '04' => false,
                    '05' => false,
                    '06' => false,
                    '07' => false,
                    '08' => false,
                    '09' => false,
                    '10' => false,
                    '11' => false,
                    '12' => false,
                    '13' => false,
                    '14' => false,
                    '15' => false,
                    '16' => false,
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check'
                ],
                'label' => 'Accepter',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['
                    autocomplete' => 'new-password', 
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
