<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPlainPassword', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class, array(
                'constraints' => array(
                    new \Symfony\Component\Security\Core\Validator\Constraints\UserPassword(),
                ),
                'mapped' => false,
                'required' => true,
                'label' => 'Current Password',
                'attr' => [
                    'placeholder' => 'current password'
                ]
            ))
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password', 'label_attr' => ['class' => 'mt-0'], 'attr' => ['placeholder' => 'password']],
                'second_options' => ['label' => 'Repeat Password', 'label_attr' => ['class' => 'mt-0'], 'attr' => ['placeholder' => 'repeat password']],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_change_password_form_type';
    }
}
