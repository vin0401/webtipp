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
 * @ORM\Table(name="matches")
 */
class Match
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id", options={"unsigned"=true})
     */
    private $id;

    /**
     * @var \WebtippBundle\Entity\Matchday
     *
     * @ORM\ManyToOne(targetEntity="Matchday", inversedBy="matches")
     * @ORM\JoinColumn(name="id_matchday", referencedColumnName="id")
     */
    private $matchday;

    /**
     * @var \WebtippBundle\Entity\Bet
     *
     * @ORM\OneToMany(targetEntity="Bet", mappedBy="match")
     */
    private $bets;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $teamHome;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $teamAway;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true}, nullable=true)
     */
    private $goalsTeamHome;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true}, nullable=true)
     */
    private $goalsTeamAway;

    /**
     * @var string
     *
     * @ORM\Column(type="string", columnDefinition="ENUM('active', 'inactive')", options={"default" = "active"})
     */
    private $state;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $dateStart;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $dateEnd;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bets = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set teamHome
     *
     * @param string $teamHome
     *
     * @return Match
     */
    public function setTeamHome($teamHome)
    {
        $this->teamHome = $teamHome;

        return $this;
    }

    /**
     * Get teamHome
     *
     * @return string
     */
    public function getTeamHome()
    {
        return $this->teamHome;
    }

    /**
     * Set teamAway
     *
     * @param string $teamAway
     *
     * @return Match
     */
    public function setTeamAway($teamAway)
    {
        $this->teamAway = $teamAway;

        return $this;
    }

    /**
     * Get teamAway
     *
     * @return string
     */
    public function getTeamAway()
    {
        return $this->teamAway;
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
     * Set type
     *
     * @param string $type
     *
     * @return Match
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * Add bet
     *
     * @param \WebtippBundle\Entity\Bet $bet
     *
     * @return Match
     */
    public function addBet(\WebtippBundle\Entity\Bet $bet)
    {
        $this->bets[] = $bet;

        return $this;
    }

    /**
     * Remove bet
     *
     * @param \WebtippBundle\Entity\Bet $bet
     */
    public function removeBet(\WebtippBundle\Entity\Bet $bet)
    {
        $this->bets->removeElement($bet);
    }

    /**
     * Get bets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBets()
    {
        return $this->bets;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Match
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
