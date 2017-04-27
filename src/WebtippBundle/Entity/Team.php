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
 * @ORM\Table(name="teams")
 */
class Team
{
    /**
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Season", mappedBy="seasons")
     */
    private $seasons;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

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
     * Set name
     *
     * @param string $name
     *
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->seasons = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add season
     *
     * @param \WebtippBundle\Entity\Season $season
     *
     * @return Team
     */
    public function addSeason(\WebtippBundle\Entity\Season $season)
    {
        $this->seasons[] = $season;

        return $this;
    }

    /**
     * Remove season
     *
     * @param \WebtippBundle\Entity\Season $season
     */
    public function removeSeason(\WebtippBundle\Entity\Season $season)
    {
        $this->seasons->removeElement($season);
    }

    /**
     * Get seasons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeasons()
    {
        return $this->seasons;
    }
}
