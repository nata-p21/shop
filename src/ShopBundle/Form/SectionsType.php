<?php

namespace ShopBundle\Form;

use ShopBundle\Entity\Sections;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SectionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Название',
                'attr' => ['class' => 'form-control']])
            ->add('code', null,[
                'label' => 'Код для url',
                'attr' => ['class' => 'form-control']])
            ->add('picture', FileType::class,array('label' => 'Изображение','data_class' => null, 'attr' => array('class' => 'form-control')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Sections::class
        ));
    }

    public function getBlockPrefix()
    {
        return 'shop_bundle_sections_type';
    }
}
