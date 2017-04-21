<?php
/**
 * Created by PhpStorm.
 * User: erwan
 * Date: 20/04/17
 * Time: 10:07
 */


namespace Esor\TestBundle\Entity;

/**
 * @ORM\Entity
 * @ORM\Table(name="AdvertSkill")
 */
class AdvertSkill
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="level", type="string", length=255)
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="Esor\TestBundle\Entity\Advert")
     * @ORM\JoinColumn(nullable=false)
     */
    private $advert;

    /**
     * @ORM\ManyToOne(targetEntity="Esor\TestBundle\Entity\Skill")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;

    // ... vous pouvez ajouter d'autres attributs bien sûr

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
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return AdvertSkill
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \Esor\TestBundle\Entity\Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * Set advert
     *
     * @param \Esor\TestBundle\Entity\Advert $advert
     *
     * @return AdvertSkill
     */
    public function setAdvert(\Esor\TestBundle\Entity\Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get skill
     *
     * @return \Esor\TestBundle\Entity\Skill
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * Set skill
     *
     * @param \Esor\TestBundle\Entity\Skill $skill
     *
     * @return AdvertSkill
     */
    public function setSkill(\Esor\TestBundle\Entity\Skill $skill)
    {
        $this->skill = $skill;

        return $this;
    }
}
