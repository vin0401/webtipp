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
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $idApi;

    /**
     * @var \WebtippBundle\Entity\Season
     *
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="matchdays")
     * @ORM\JoinColumn(name="id_season", referencedColumnName="id")
     */
    private $season;

    /**
     * @var \WebtippBundle\Entity\Match
     *
     * @ORM\OneToMany(targetEntity="Match", mappedBy="matchday")
     */
    private $matches;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="`order`", type="integer", options={"unsigned"=true})
     */
    private $order;

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
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $dateUpdate;

    /**
     * Get id
     *
     * @param string|null $type
     *
     * @return integer
     */
    public function getResults($type = null)
    {
        $results = [];
        foreach ($this->getMatches() as $match) {
            foreach ($match->getResults() as $result) {
                if ($type === null || $type === $result->getType()) {
                    $results[] = $result;
                }
            }
        }

        return $results;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->seasons = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set idApi
     *
     * @param integer $idApi
     *
     * @return Matchday
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
     * @return Matchday
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
     * Set order
     *
     * @param integer $order
     *
     * @return Matchday
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
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
     * Set dateUpdate
     *
     * @param integer $dateUpdate
     *
     * @return Matchday
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * Get dateUpdate
     *
     * @return integer
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Add season
     *
     * @param \WebtippBundle\Entity\Season $season
     *
     * @return Matchday
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

    /**
     * Set season
     *
     * @param \WebtippBundle\Entity\Season $season
     *
     * @return Matchday
     */
    public function setSeason(\WebtippBundle\Entity\Season $season = null)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return \WebtippBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Matchday
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }
}
