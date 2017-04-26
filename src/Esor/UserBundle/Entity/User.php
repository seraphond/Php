<?php

namespace Esor\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * use FOS\UserBundle\Model\User as BaseUser;
 * @ORM\Entity(repositoryClass="Esor\UserBundle\Repository\UserRepository")
 */
class User Extends BaseUser{
    /**

     * @ORM\Column(name="id", type="integer")

     * @ORM\Id

     * @ORM\GeneratedValue(strategy="AUTO")

     */

    protected $id;

}
