<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 26/04/17
 * Time: 17:32
 */

namespace Esor\deckmakerBundle\Entity;


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
     * @var string
     * @Assert\Length(min=1)
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $couleur;

    /**
     * @var string
     * @Assert\Length(min=1)
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $type;
}