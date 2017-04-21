<?php
/**
 * Created by PhpStorm.
 * User: erwan
 * Date: 19/04/17
 * Time: 16:33
 */

namespace Esor\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="application")
 * @ORM\Entity(repositoryClass="Esor\TestBundle\Repository\ApplicationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Application
{

    /**
     * @ORM\ManyToOne(targetEntity="Esor\TestBundle\Entity\Advert" , inversedBy="applications")
     * @ORM\JoinColumn(nullable=false)
     *
     */

    private $advert;
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;
    /**
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->date = new \Datetime();
    }

    /**
     * @ORM\PrePersist
     */

    public function increase()
    {
        $this->getAdvert()->increaseApplication();
    }

    public function getAdvert()
    {
        return $this->advert;
    }

    public function setAdvert(Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * @ORM\PreRemove
     */
    public function decrease()
    {
        $this->getAdvert()->decreaseApplication();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate(\Datetime $date)
    {
        $this->date = $date;

        return $this;
    }
}
