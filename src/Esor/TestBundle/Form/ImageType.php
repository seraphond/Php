<?php

namespace Esor\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class);
        /*->add('url', TextType::class, array('required' => false))
        ->add('alt', TextType::class, array('required' => false));*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Esor\TestBundle\Entity\Image'
        ));
    }

    public function getBlockPrefix()
    {
        return 'esor_test_bundle_image_type';
    }
}
