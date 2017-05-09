<?php
/**
 * Author: Daniel Richardt <d.richardt@dpmr-dev.de>
 * Date: 26.04.2017
 * Time: 19:49
 */
namespace WebtippBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="matchdays")
 */
class Matchday
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id", options={"unsigned"=true})
     */
    private $id;

    /**
     * @var \WebtippBundle\Entity\Group
     *
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="matchdays")
     * @ORM\JoinColumn(name="id_group", referencedColumnName="id")
     */
    private $group;

    /**
     * @var \WebtippBundle\Entity\Match
     *
     * @ORM\OneToMany(targetEntity="Match", mappedBy="matchday")
     */
    private $matches;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $dateStart;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $dateEnd;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->matches = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dateStart
     *
     * @param integer $dateStart
     *
     * @return Matchday
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return integer
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param integer $dateEnd
     *
     * @return Matchday
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return integer
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set group
     *
     * @param \WebtippBundle\Entity\Group $group
     *
     * @return Matchday
     */
    public function setGroup(\WebtippBundle\Entity\Group $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \WebtippBundle\Entity\Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Add match
     *
     * @param \WebtippBundle\Entity\Match $match
     *
     * @return Matchday
     */
    public function addMatch(\WebtippBundle\Entity\Match $match)
    {
        $this->matches[] = $match;

        return $this;
    }

    /**
     * Remove match
     *
     * @param \WebtippBundle\Entity\Match $match
     */
    public function removeMatch(\WebtippBundle\Entity\Match $match)
    {
        $this->matches->removeElement($match);
    }

    /**
     * Get matches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatches()
    {
        return $this->matches;
    }
}
