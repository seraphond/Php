<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/04/17
 * Time: 09:56
 */

namespace Esor\deckmakerBundle\Form;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Esor\TestBundle\Form\ImageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class CardType extends AbstractType{

    /**
     * {@inheritdoc}
     */

     public function buildForm(FormBuilderInterface $builder, array $options){
         $builder
             ->add('titre' ,TextType::class)
             ->add('cout' ,TextType::class)
             ->add('type', ChoiceType::class , array(
                 'multiple' => true,
                 'expanded' => true,
                 'choices'  => array(
                     'Rituel'=>'Rituel',
                     'Ephemère'=>'Ephemère',
                     'Enchantement' => 'Enchantement',
                     'Créature' => 'Créature',
                     'Artefact' => 'Artefact',
                     'Jeton' => 'Jeton'

                 )
             ))
             ->add('Couleur', ChoiceType::class,array(
                 'multiple' => true,
                 'expanded' => true,
                 'choices' => array(
                     'Rouge' => "Rouge",
                     'Blanc'=> "Blanc",
                     'Noir'=> "Noir",
                     'Bleu' => "Bleu",
                     'Vert' => "Vert",
                     'Artefact' =>"Artefact",
                     'incolore' => "Incolore",
                     'Multicolore' =>">Multicolore"
                 )
             ))
             ->add('image',ImageType::class, array('required' => false))
             ->add('Envoyer', SubmitType::class);

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Esor\deckmaker\Entity\Card'
        ));
    }
    public function getBlockPrefix()
    {
        return 'esordeckmaker_homepage';
    }
}