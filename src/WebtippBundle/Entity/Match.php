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
     * @var \WebtippBundle\Entity\Matchday
     *
     * @ORM\ManyToOne(targetEntity="Matchday", inversedBy="matches")
     * @ORM\JoinColumn(name="id_matchday", referencedColumnName="id")
     */
    private $matchday;

    /**
     * @var \WebtippBundle\Entity\Result
     *
     * @ORM\OneToMany(targetEntity="Result", mappedBy="match")
     */
    private $results;

    /**
     * @var \WebtippBundle\Entity\Bet
     *
     * @ORM\OneToMany(targetEntity="Bet", mappedBy="match")
     */
    private $bets;

    /**
     * @var \WebtippBundle\Entity\Team
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="matchesHome")
     * @ORM\JoinColumn(name="team_home", referencedColumnName="id")
     */
    private $teamHome;

    /**
     * @var \WebtippBundle\Entity\Team
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="matchesAway")
     * @ORM\JoinColumn(name="team_away", referencedColumnName="id")
     */
    private $teamAway;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     columnDefinition="ENUM('active', 'finished', 'pending')",
     *     options={"default" = "pending"}
     * )
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
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $dateUpdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="`order`", type="integer", options={"unsigned"=true})
     */
    private $order;

    /**
     * @return League
     */
    public function getSeason()
    {
        return $this->getMatchday()->getSeason();
    }

    /**
     * @return League
     */
    public function getLeague()
    {
        return $this->getMatchday()->getSeason()->getLeague();
    }

    /**
     * @param string|null $type
     *
     * @return Result
     */
    public function getResult($type = 'end')
    {
        foreach ($this->getResults() as $result) {
            if ($type === $result->getType()->getId()) {
                return $result;
            }
        }

        return false;
    }

    //* @return \Doctrine\Common\Collections\Collection
    /**
     * @return Bat|false
     */
    public function getUserBet(Group $group, User $user)
    {
        foreach ($user->getBets() as $bet) {
            if ($bet->getGroup() === $group && $this === $bet->getMatch()) {
                return $bet;
            }
        }

        return false;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->results = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set order
     *
     * @param integer $order
     *
     * @return Match
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
     * Add result
     *
     * @param \WebtippBundle\Entity\Result $result
     *
     * @return Match
     */
    public function addResult(\WebtippBundle\Entity\Result $result)
    {
        $this->results[] = $result;

        return $this;
    }

    /**
     * Remove result
     *
     * @param \WebtippBundle\Entity\Result $result
     */
    public function removeResult(\WebtippBundle\Entity\Result $result)
    {
        $this->results->removeElement($result);
    }

    /**
     * Get results
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResults()
    {
        return $this->results;
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

    /**
     * Set idApi
     *
     * @param integer $idApi
     *
     * @return Match
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
     * Set dateUpdate
     *
     * @param integer $dateUpdate
     *
     * @return Match
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
}
