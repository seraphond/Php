<?php

namespace Esor\TestBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$pattern = 'D%';
        $builder
            //->add('date', DateTimeType::class, ['attr' => ['class' => 'form-control']])
            ->add('titre', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('auteur', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('contenu', TextareaType::class, ['attr' => ['class' => 'form-control']])
            //->add('published', CheckboxType::class, array('required' => false))
            ->add('image', ImageType::class, array('required' => false) )
            /*
             *  Rappel :
 ** - 1er argument : nom du champ, ici « categories », car c'est le nom de l'attribut
 ** - 2e argument : type du champ, ici « CollectionType » qui est une liste de quelque chose
 ** - 3e argument : tableau d'options du champ
 */
            /*->add('categories', CollectionType::class, array(
                'entry_type'   => CategoryType::class,
                'allow_add'    => true,
                'allow_delete' => true))

            */
            ->add('categories', EntityType::class, array(
                'class' => 'EsorTestBundle:Category',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                //Sert a filtrer les catégories via le patern
                /* 'query_builder' => function(CategoryRepository $repository) use($pattern) {
                    return $repository->getLikeQueryBuilder($pattern);
                }*/
            ))
            ->add('save', SubmitType::class);

        // On ajoute une fonction qui va écouter un évènement
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,    // 1er argument : L'évènement qui nous intéresse : ici, PRE_SET_DATA
            function (FormEvent $event) { // 2e argument : La fonction à exécuter lorsque l'évènement est déclenché
                // On récupère notre objet Advert sous-jacent

                $advert = $event->getData();
                if (null === $advert) {

                    return; // On sort de la fonction sans rien faire lorsque $advert vaut null

                }
                if (!$advert->getPublished() || null === $advert->getId()) {

                    // Alors on ajoute le champ published

                    $event->getForm()->add('published', CheckboxType::class, array('required' => false));

                } else {

                    // Sinon, on le supprime

                    $event->getForm()->remove('published');

                }
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Esor\TestBundle\Entity\Advert'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'esor_testbundle_advert';
    }


}
