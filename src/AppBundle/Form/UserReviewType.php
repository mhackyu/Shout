<?php

namespace AppBundle\Form;

use AppBundle\Entity\UserReview;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('review', TextareaType::class, [
                'label' => 'You',
                'attr' => [
                    'placeholder' => 'Add review to this user',
                    'style' => 'height: 80px'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserReview::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_user_review_type';
    }
}
