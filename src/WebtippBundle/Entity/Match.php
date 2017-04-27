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
 * @ORM\Table(name="season_matchday_matches")
 */
class Match
{
    /**
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Matchday")
     * @ORM\JoinColumn(name="id_matchday", referencedColumnName="id")
     */
    private $matchday;

    /**
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="id_team_home", referencedColumnName="id")
     */
    private $teamHome;

    /**
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="id_team_away", referencedColumnName="id")
     */
    private $teamAway;

    /**
     * @ORM\Column(type="integer")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="integer")
     */
    private $dateEnd;


    /**
     * @ORM\Column(type="integer")
     */
    private $goalsTeamHome;

    /**
     * @ORM\Column(type="integer")
     */
    private $goalsTeamAway;

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
     * @return Match
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
     * @return Match
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
     * Set goalsTeamHome
     *
     * @param integer $goalsTeamHome
     *
     * @return Match
     */
    public function setGoalsTeamHome($goalsTeamHome)
    {
        $this->goalsTeamHome = $goalsTeamHome;

        return $this;
    }

    /**
     * Get goalsTeamHome
     *
     * @return integer
     */
    public function getGoalsTeamHome()
    {
        return $this->goalsTeamHome;
    }

    /**
     * Set goalsTeamAway
     *
     * @param integer $goalsTeamAway
     *
     * @return Match
     */
    public function setGoalsTeamAway($goalsTeamAway)
    {
        $this->goalsTeamAway = $goalsTeamAway;

        return $this;
    }

    /**
     * Get goalsTeamAway
     *
     * @return integer
     */
    public function getGoalsTeamAway()
    {
        return $this->goalsTeamAway;
    }

    /**
     * Set matchday
     *
     * @param \WebtippBundle\Entity\Matchday $matchday
     *
     * @return Match
     */
    public function setMatchday(\WebtippBundle\Entity\Matchday $matchday = null)
    {
        $this->matchday = $matchday;

        return $this;
    }

    /**
     * Get matchday
     *
     * @return \WebtippBundle\Entity\Matchday
     */
    public function getMatchday()
    {
        return $this->matchday;
    }

    /**
     * Set teamHome
     *
     * @param \WebtippBundle\Entity\Team $teamHome
     *
     * @return Match
     */
    public function setTeamHome(\WebtippBundle\Entity\Team $teamHome = null)
    {
        $this->teamHome = $teamHome;

        return $this;
    }

    /**
     * Get teamHome
     *
     * @return \WebtippBundle\Entity\Team
     */
    public function getTeamHome()
    {
        return $this->teamHome;
    }

    /**
     * Set teamAway
     *
     * @param \WebtippBundle\Entity\Team $teamAway
     *
     * @return Match
     */
    public function setTeamAway(\WebtippBundle\Entity\Team $teamAway = null)
    {
        $this->teamAway = $teamAway;

        return $this;
    }

    /**
     * Get teamAway
     *
     * @return \WebtippBundle\Entity\Team
     */
    public function getTeamAway()
    {
        return $this->teamAway;
    }
}
