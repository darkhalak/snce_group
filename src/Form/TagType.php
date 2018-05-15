<?php
/**
 * @author Daniele Agrelli <daniele.agrelli@gmail.com> on 15/05/18 09:57.
 * @copyright Copyright © Daniele Agrelli 2018
 */

namespace App\Form;


use App\Entity\Tag;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Tag::class,
        ));
    }
}