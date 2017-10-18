<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'email@domain.com'
                ]
            ])
            ->add('username', TextType::class, [
                'label_attr' => [
                    'class' => 'mt-0'
                ],
                'attr' => [
                    'placeholder' => 'username'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password', 'label_attr' => ['class' => 'mt-0'], 'attr' => ['placeholder' => 'password']],
                'second_options' => ['label' => 'Repeat Password', 'label_attr' => ['class' => 'mt-0'], 'attr' => ['placeholder' => 'repeat password']],
            ])
            ->add('firstName', TextType::class, [
                'attr' => [
                    'placeholder' => 'Juan'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label_attr' => [
                    'class' => 'mt-0'
                ],
                'attr' => [
                    'placeholder' => 'Dela Cruz'
                ]
            ])
            ->add('dob', BirthdayType::class, [
                'label' => 'Birthday',
                'label_attr' => [
                    'class' => 'mt-0',
                ],
                'attr' => [
                    'placeholder' => 'Dela Cruz',
                ]
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 'male', 'Female' => 'female'
                ],
                'label_attr' => [
                    'class' => 'mt-0'
                ],
                'attr' => [
                    'placeholder' => 'Gender'
                ]
            ]);

//            ->add('termsAccepted', CheckboxType::class, array(
//                'mapped' => false,
//                'constraints' => new IsTrue(),
//            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_user_type';
    }
}
