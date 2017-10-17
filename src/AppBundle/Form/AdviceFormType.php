<?php

namespace AppBundle\Form;

use AppBundle\Entity\Advice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdviceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Advice',
                'attr' => [
                    'placeholder' => 'Please be nice with your advice :)',
                    'style' => 'height: 100px'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advice::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_advice_form_type';
    }
}
