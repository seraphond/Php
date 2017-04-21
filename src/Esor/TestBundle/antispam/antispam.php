<?php
/**
 * Created by PhpStorm.
 * User: erwan
 * Date: 19/04/17
 * Time: 10:57
 */

namespace Esor\TestBundle\antispam;

class  antispam
{
    private $mailer;
    private $minlenth;

    public function __construct(\Swift_Mailer $mailer, $minLength)

    {
        $this->mailer = $mailer;
        $this->minLength = (int)$minLength;
    }

    /**
     * Vérifie si le texte est un spam ou non
     *
     * @param string $text
     * @return bool
     */
    public function isSpam($text)
    {
        return strlen($text) > $this->minLength;
    }
}