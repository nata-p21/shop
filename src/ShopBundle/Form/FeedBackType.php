<?php

namespace ShopBundle\Form;

use ShopBundle\Entity\Feedback;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedBackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Имя',
                'attr' => array('class' => 'form-control')
            ))
            ->add('phone', null, array(
                'label' => 'Телефон',
                'attr' => array('class' => 'form-control')
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'attr' => array('class' => 'form-control')
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Сообщение',
                'attr' => array('class' => 'form-control')
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class
        ]);

    }

    public function getBlockPrefix()
    {
        return 'shop_bundle_feed_back_type';
    }
}
