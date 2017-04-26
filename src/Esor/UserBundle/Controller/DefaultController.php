<?php

namespace Esor\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Esor\UserBundle\Form\RegistrationType;

class DefaultController extends Controller
{
    public function indexAction()
    {
       $service=$this->container->get("esor_user_registration");
        return $this->redirectToRoute('esor_test_home');

    }
}
