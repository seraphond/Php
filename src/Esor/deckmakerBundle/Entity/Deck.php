<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/04/17
 * Time: 09:32
 */

namespace Esor\deckmakerBundle\Entity;


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
     * @ORM\Column(name="nom", type ="string",lentgh =255)
     */
    private $nom;


    /**
     * @ORM\ManyToMany(targetEntity="Esor\deckmakerBundle\Entity\Card", cascade={"persist"})
     * @ORM\JoinTable(name="list_card")
     */

    private $cards;

    /**
     * @var int
     * @ORM\Column(name ="nb_card, type="integer")
     */
    private  $nb;
}