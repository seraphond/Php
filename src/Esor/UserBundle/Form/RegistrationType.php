<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25/04/17
 * Time: 11:25
 */

namespace Esor\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('email')

        ;
    }
    public function getName()
    {
        return 'esor_user_registration';
    }
}