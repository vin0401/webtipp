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
 * @ORM\Table(name="bets")
 */
class Bet
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id", options={"unsigned"=true})
     */
    private $id;

    /**
     * @var \WebtippBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="bets")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \WebtippBundle\Entity\Group
     *
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="bets")
     * @ORM\JoinColumn(name="id_group", referencedColumnName="id")
     */
    private $group;

    /**
     * @var \WebtippBundle\Entity\Match
     *
     * @ORM\ManyToOne(targetEntity="Match", inversedBy="bets")
     * @ORM\JoinColumn(name="id_match", referencedColumnName="id")
     */
    private $match;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $goalsTeamHome;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $goalsTeamAway;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     columnDefinition="ENUM('won', 'part', 'lost', 'pending')",
     *     options={"default" = "normal"}
     * )
     */
    private $state;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true, options={"unsigned"=true})
     */
    private $score;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $dateCreate;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $dateUpdate;

    /**
     * @return Matchday
     */
    public function getMatchday()
    {
        return $this->getMatch()->getMatchday();
    }

    /**
     * @return string
     */
    public function format()
    {
        return ($this->getGoalsTeamHome() . ':' . $this->getGoalsTeamAway());
    }

    /**
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return Team
     */
    public function getTeamHome()
    {
        return $this->getMatch()->getTeamHome();
    }

    /**
     * @return Team
     */
    public function getTeamAway()
    {
        return $this->getMatch()->getTeamAway();
    }

    /**
     * @return int
     */
    public function getResultGoalsTeamAway()
    {
        $result = $this->getMatch()->getResult();

        return $result->getGoalsTeamHome();
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
     * Set goalsTeamHome
     *
     * @param integer $goalsTeamHome
     *
     * @return Bet
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
     * @return Bet
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
     * Set state
     *
     * @param string $state
     *
     * @return Bet
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

    /**
     * Set dateCreate
     *
     * @param integer $dateCreate
     *
     * @return Bet
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return integer
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set dateUpdate
     *
     * @param integer $dateUpdate
     *
     * @return Bet
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
     * Set user
     *
     * @param \WebtippBundle\Entity\User $user
     *
     * @return Bet
     */
    public function setUser(\WebtippBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \WebtippBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set match
     *
     * @param \WebtippBundle\Entity\Match $match
     *
     * @return Bet
     */
    public function setMatch(\WebtippBundle\Entity\Match $match = null)
    {
        $this->match = $match;

        return $this;
    }

    /**
     * Get match
     *
     * @return \WebtippBundle\Entity\Match
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Set group
     *
     * @param \WebtippBundle\Entity\Group $group
     *
     * @return Bet
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
     * Set score
     *
     * @param integer $score
     *
     * @return Bet
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }
}
