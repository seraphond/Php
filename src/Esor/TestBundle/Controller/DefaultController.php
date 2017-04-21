<?php

namespace Esor\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EsorTestBundle:Default:index.html.twig');
    }
}
