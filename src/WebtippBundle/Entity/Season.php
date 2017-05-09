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
 * @ORM\Table(name="seasons")
 */
class Season
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
     * @var \WebtippBundle\Entity\Group
     *
     * @ORM\OneToMany(targetEntity="Group", mappedBy="season")
     */
    private $groups;

    /**
     * @var \WebtippBundle\Entity\League
     *
     * @ORM\ManyToOne(targetEntity="League", inversedBy="seasons")
     * @ORM\JoinColumn(name="id_league", referencedColumnName="id")
     */
    private $league;

    /**
     * @var \WebtippBundle\Entity\Matchday
     *
     * @ORM\OneToMany(targetEntity="Matchday", mappedBy="season")
     * @ORM\OrderBy({"order" = "ASC"})
     */
    private $matchdays;

    /**
     * @var \WebtippBundle\Entity\Team
     *
     * @ORM\ManyToMany(targetEntity="Team", inversedBy="seasons")
     * @ORM\JoinTable(
     *  name="season_teams",
     *  joinColumns={
     *      @ORM\JoinColumn(name="id_season", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="id_team", referencedColumnName="id")
     *  }
     * )
     */
    private $teams;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matchdays = new \Doctrine\Common\Collections\ArrayCollection();
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param string $idApi
     *
     * @return Season
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
     * Set year
     *
     * @param integer $year
     *
     * @return Season
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Add group
     *
     * @param \WebtippBundle\Entity\Group $group
     *
     * @return Season
     */
    public function addGroup(\WebtippBundle\Entity\Group $group)
    {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * Remove group
     *
     * @param \WebtippBundle\Entity\Group $group
     */
    public function removeGroup(\WebtippBundle\Entity\Group $group)
    {
        $this->groups->removeElement($group);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set league
     *
     * @param \WebtippBundle\Entity\League $league
     *
     * @return Season
     */
    public function setLeague(\WebtippBundle\Entity\League $league = null)
    {
        $this->league = $league;

        return $this;
    }

    /**
     * Get league
     *
     * @return \WebtippBundle\Entity\League
     */
    public function getLeague()
    {
        return $this->league;
    }

    /**
     * Add matchday
     *
     * @param \WebtippBundle\Entity\Matchday $matchday
     *
     * @return Season
     */
    public function addMatchday(\WebtippBundle\Entity\Matchday $matchday)
    {
        $this->matchdays[] = $matchday;

        return $this;
    }

    /**
     * Remove matchday
     *
     * @param \WebtippBundle\Entity\Matchday $matchday
     */
    public function removeMatchday(\WebtippBundle\Entity\Matchday $matchday)
    {
        $this->matchdays->removeElement($matchday);
    }

    /**
     * Get matchdays
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatchdays()
    {
        return $this->matchdays;
    }

    /**
     * Add team
     *
     * @param \WebtippBundle\Entity\Team $team
     *
     * @return Season
     */
    public function addTeam(\WebtippBundle\Entity\Team $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \WebtippBundle\Entity\Team $team
     */
    public function removeTeam(\WebtippBundle\Entity\Team $team)
    {
        $this->teams->removeElement($team);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Add league
     *
     * @param \WebtippBundle\Entity\Matchday $league
     *
     * @return Season
     */
    public function addLeague(\WebtippBundle\Entity\Matchday $league)
    {
        $this->league[] = $league;

        return $this;
    }

    /**
     * Remove league
     *
     * @param \WebtippBundle\Entity\Matchday $league
     */
    public function removeLeague(\WebtippBundle\Entity\Matchday $league)
    {
        $this->league->removeElement($league);
    }
}
