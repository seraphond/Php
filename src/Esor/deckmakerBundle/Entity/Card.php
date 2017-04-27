<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 26/04/17
 * Time: 17:32
 */

namespace Esor\deckmakerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Card
 *
 * @ORM\Table(name="Card")
 * @ORM\Entity(repositoryClass="Esor\CardBundle\Repository\CardRepository")
 *
 */
class Card
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     * @Assert\Length(min=1)
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var int
     * @Assert\NotBlank()
     * @ORM\Column(name="contenu", type="integer")
     */
    private $cout;

    /**
     * @ORM\OneToOne(targetEntity="Esor\TestBundle\Entity\Image", cascade={"persist", "remove"})
     * @Assert\Valid()
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * @var array
     * @Assert\Length(min=1)
     * @ORM\Column(name="couleur", type="string", length=255)
     */
    private $couleur;

    /**
     * @var array
     * @Assert\Length(min=1)
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Card
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set cout
     *
     * @param integer $cout
     *
     * @return Card
     */
    public function setCout($cout)
    {
        $this->cout = $cout;

        return $this;
    }

    /**
     * Get cout
     *
     * @return integer
     */
    public function getCout()
    {
        return $this->cout;
    }

    /**
     * Set couleur
     *
     * @param string $couleur
     *
     * @return Card
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Card
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set image
     *
     * @param \Esor\TestBundle\Entity\Image $image
     *
     * @return Card
     */
    public function setImage(\Esor\TestBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Esor\TestBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
