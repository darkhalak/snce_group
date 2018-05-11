<?php
/**
 * @author Daniele Agrelli <daniele.agrelli@gmail.com> on 09/05/18 11:36.
 * @copyright Copyright © Daniele Agrelli 2018
 */

namespace App\Form;


use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Image'])
            ->add('description', TextareaType::class, ['label' => 'Description','required'=>false])
            ->add('img_path', FileType::class, ['label' => 'Image','required'=>false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}