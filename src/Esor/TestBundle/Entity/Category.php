<?php
/**
 * Created by PhpStorm.
 * User: erwan
 * Date: 19/04/17
 * Time: 17:18
 */

namespace Esor\TestBundle\Entity;

/**
 * @ORM\Entity(repositoryClass="Esor\TestBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
