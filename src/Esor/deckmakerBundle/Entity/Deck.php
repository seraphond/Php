<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/04/17
 * Time: 09:32
 */

namespace Esor\deckmakerBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Deck
 *
 * @ORM\Table(name="Deck")
 * @ORM\Entity(repositoryClass="Esor\CardBundle\Repository\DeckRepository")
 *
 */
class Deck
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
     * @ORM\Column(name="nom", type ="string",length =255)
     */
    private $nom;


    /**
     * @ORM\ManyToMany(targetEntity="Esor\deckmakerBundle\Entity\Card", cascade={"persist"})
     * @ORM\JoinTable(name="list_card")
     */

    private $cards;

    /**
     * @var int
     * @ORM\Column(name ="nb_card", type="integer")
     */
    private  $nb;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cards = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Deck
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nb
     *
     * @param integer $nb
     *
     * @return Deck
     */
    public function setNb($nb)
    {
        $this->nb = $nb;

        return $this;
    }

    /**
     * Get nb
     *
     * @return integer
     */
    public function getNb()
    {
        return $this->nb;
    }

    /**
     * Add card
     *
     * @param \Esor\deckmakerBundle\Entity\Card $card
     *
     * @return Deck
     */
    public function addCard(\Esor\deckmakerBundle\Entity\Card $card)
    {
        $this->cards[] = $card;

        return $this;
    }

    /**
     * Remove card
     *
     * @param \Esor\deckmakerBundle\Entity\Card $card
     */
    public function removeCard(\Esor\deckmakerBundle\Entity\Card $card)
    {
        $this->cards->removeElement($card);
    }

    /**
     * Get cards
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCards()
    {
        return $this->cards;
    }
}
