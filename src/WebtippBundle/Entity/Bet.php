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
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="BettingGame")
     * @ORM\JoinColumn(name="id_betting_game", referencedColumnName="id")
     */
    private $bettingGame;

    /**
     * @ORM\ManyToOne(targetEntity="Match")
     * @ORM\JoinColumn(name="id_match", referencedColumnName="id")
     */
    private $match;

    /**
     * @ORM\Column(type="integer")
     */
    private $goalsTeamHome;

    /**
     * @ORM\Column(type="integer")
     */
    private $goalsTeamAway;

    /**
     * @ORM\Column(type="integer")
     */
    private $dateCreate;

    /**
     * @ORM\Column(type="integer")
     */
    private $dateUpdate;

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
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Bet
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idBettingGame
     *
     * @param integer $idBettingGame
     *
     * @return Bet
     */
    public function setIdBettingGame($idBettingGame)
    {
        $this->idBettingGame = $idBettingGame;

        return $this;
    }

    /**
     * Get idBettingGame
     *
     * @return integer
     */
    public function getIdBettingGame()
    {
        return $this->idBettingGame;
    }

    /**
     * Set idMatch
     *
     * @param integer $idMatch
     *
     * @return Bet
     */
    public function setIdMatch($idMatch)
    {
        $this->idMatch = $idMatch;

        return $this;
    }

    /**
     * Get idMatch
     *
     * @return integer
     */
    public function getIdMatch()
    {
        return $this->idMatch;
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
     * Set bettingGame
     *
     * @param \WebtippBundle\Entity\BettingGame $bettingGame
     *
     * @return Bet
     */
    public function setBettingGame(\WebtippBundle\Entity\BettingGame $bettingGame = null)
    {
        $this->bettingGame = $bettingGame;

        return $this;
    }

    /**
     * Get bettingGame
     *
     * @return \WebtippBundle\Entity\BettingGame
     */
    public function getBettingGame()
    {
        return $this->bettingGame;
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
}
