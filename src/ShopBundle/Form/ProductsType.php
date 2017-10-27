<?php

namespace ShopBundle\Form;

use ShopBundle\Entity\Products;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Название товара',
                'attr' => array('class' => 'form-control')
            ))
            ->add('section',EntityType::class, array(
                'class' => 'ShopBundle\Entity\Sections',
                'label' => 'Категория',
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control'),
                //'data' => $options['em']->getReference('WideWebVisicomBundle:Category', $options['category'] )
            ))
            ->add('code', null, array(
                'label' => 'Символьный код для url',
                'attr' => array('class' => 'form-control')
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Описание',
                'attr' => array('class' => 'form-control')
            ))
            ->add('price', null, array(
                'label' => 'Цена',
                'attr' => array('class' => 'form-control')
            ))
            ->add('picture', FileType::class,array(
                'label' => 'Изображение',
                'data_class' => null,
                'attr' => array('class' => 'form-control')
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'shop_bundle_products_type';
    }
}
