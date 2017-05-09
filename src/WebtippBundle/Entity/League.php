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
 * @ORM\Table(name="leagues")
 */
class League
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=100)
     */
    private $idApi;

    /**
     * @var \WebtippBundle\Entity\Season
     *
     * @ORM\OneToMany(targetEntity="Season", mappedBy="league")
     */
    private $seasons;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->seasons = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set idApi
     *
     * @param integer $idApi
     *
     * @return League
     */
    public function setIdApi($idApi)
    {
        $this->idApi = $idApi;

        return $this;
    }

    /**
     * Get idApi
     *
     * @return string
     */
    public function getIdApi()
    {
        return $this->idApi;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return League
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
     * Add season
     *
     * @param \WebtippBundle\Entity\Season $season
     *
     * @return League
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

    /**
     * Get season
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeason()
    {
        return $this->season;
    }
}
