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
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $id;

    /**
     * @var \WebtippBundle\Entity\Season
     *
     * @ORM\ManyToMany(targetEntity="Season", mappedBy="teams")
     */
    private $seasons;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $idApi;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @var \WebtippBundle\Entity\Match
     *
     * @ORM\OneToMany(targetEntity="Match", mappedBy="teamHome")
     */
    private $matchesHome;

    /**
     * @var \WebtippBundle\Entity\Match
     *
     * @ORM\OneToMany(targetEntity="Match", mappedBy="teamAway")
     */
    private $matchesAway;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $shortName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $teamIconUrl;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->seasons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matchesHome = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matchesAway = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Team
     */
    public function setIdApi($idApi)
    {
        $this->idApi = $idApi;

        return $this;
    }

    /**
     * Get idApi
     *
     * @return integer
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
     * Set shortName
     *
     * @param string $shortName
     *
     * @return Team
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Set teamIconUrl
     *
     * @param string $teamIconUrl
     *
     * @return Team
     */
    public function setTeamIconUrl($teamIconUrl)
    {
        $this->teamIconUrl = $teamIconUrl;

        return $this;
    }

    /**
     * Get teamIconUrl
     *
     * @return string
     */
    public function getTeamIconUrl()
    {
        return $this->teamIconUrl;
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

    /**
     * Add matchesHome
     *
     * @param \WebtippBundle\Entity\Match $matchesHome
     *
     * @return Team
     */
    public function addMatchesHome(\WebtippBundle\Entity\Match $matchesHome)
    {
        $this->matchesHome[] = $matchesHome;

        return $this;
    }

    /**
     * Remove matchesHome
     *
     * @param \WebtippBundle\Entity\Match $matchesHome
     */
    public function removeMatchesHome(\WebtippBundle\Entity\Match $matchesHome)
    {
        $this->matchesHome->removeElement($matchesHome);
    }

    /**
     * Get matchesHome
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatchesHome()
    {
        return $this->matchesHome;
    }

    /**
     * Add matchesAway
     *
     * @param \WebtippBundle\Entity\Match $matchesAway
     *
     * @return Team
     */
    public function addMatchesAway(\WebtippBundle\Entity\Match $matchesAway)
    {
        $this->matchesAway[] = $matchesAway;

        return $this;
    }

    /**
     * Remove matchesAway
     *
     * @param \WebtippBundle\Entity\Match $matchesAway
     */
    public function removeMatchesAway(\WebtippBundle\Entity\Match $matchesAway)
    {
        $this->matchesAway->removeElement($matchesAway);
    }

    /**
     * Get matchesAway
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatchesAway()
    {
        return $this->matchesAway;
    }
}
