<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileFormType extends AbstractType
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
            ])
            ->add('about', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'It can be anything about yourself or something you have overcome.',
                    'style' => 'height: 150px'
                ]
            ])
            ->add('oldPlainPassword', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class, array(
                'constraints' => array(
                    new \Symfony\Component\Security\Core\Validator\Constraints\UserPassword(),
                ),
                'mapped' => false,
                'required' => true,
                'label' => 'Current Password',
            ));
//        ->add('avatar', FileType::class, [
//        'required' => false
//        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_profile_form_type';
    }
}
