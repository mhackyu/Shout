<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShoutType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, [
                'attr' => [
                    'placeholder' => 'Make it short and catchy'
                ]
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Content',
                'attr' => [
                    'placeholder' => 'What you want to shout?',
                    'style' => 'height: 150px'
                ]
            ])
            ->add('shoutCategory', EntityType::class, [
                'label' => 'Type of Problem',
                'class' => 'AppBundle\Entity\ShoutCategory',
                'choice_label' => 'name',
                'placeholder' => '-Select One-'
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Shout'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_shout';
    }


}
