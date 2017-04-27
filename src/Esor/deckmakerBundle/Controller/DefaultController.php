<?php

namespace Esor\deckmakerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EsordeckmakerBundle:Default:index.html.twig');
    }
}
