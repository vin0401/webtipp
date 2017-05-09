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
 * @ORM\Table(name="results")
 */
class Result
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
     * @var \WebtippBundle\Entity\Match
     *
     * @ORM\ManyToOne(targetEntity="Match", inversedBy="results")
     * @ORM\JoinColumn(name="id_match", referencedColumnName="id")
     */
    private $match;

    /**
     * @var \WebtippBundle\Entity\ResultType
     *
     * @ORM\ManyToOne(targetEntity="ResultType", inversedBy="results")
     * @ORM\JoinColumn(name="id_type", referencedColumnName="id")
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $idApi;

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
     * @var integer
     *
     * @ORM\Column(name="`order`", type="integer", options={"unsigned"=true})
     */
    private $order;

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
     * @return Result
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getType()->getName();
    }


    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getType()->getDescription();
    }

    /**
     * Set goalsTeamHome
     *
     * @param integer $goalsTeamHome
     *
     * @return Result
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
     * @return Result
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
     * Set order
     *
     * @param integer $order
     *
     * @return Result
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
     * Set match
     *
     * @param \WebtippBundle\Entity\Match $match
     *
     * @return Result
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
     * Set type
     *
     * @param \WebtippBundle\Entity\ResultType $type
     *
     * @return Result
     */
    public function setType(\WebtippBundle\Entity\ResultType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \WebtippBundle\Entity\ResultType
     */
    public function getType()
    {
        return $this->type;
    }
}
