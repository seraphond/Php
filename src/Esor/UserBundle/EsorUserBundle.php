<?php

namespace Esor\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EsorUserBundle extends Bundle
{

    public function  getParent()
    {
       return 'FOSUserBundle';
    }
}
