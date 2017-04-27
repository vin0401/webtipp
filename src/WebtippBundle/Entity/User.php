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
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="BettingGame", inversedBy="betting_games")
     * @ORM\JoinTable(name="users_betting_games")
     */
    private $bettingGames;

    /**
     * @ORM\Column(type="string", unique=true, length=100)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nameFirst;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nameLast;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('male', 'female')")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", unique=true, length=100)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('admin', 'normal')", options={"default" = "normal"})
     */
    private $type;

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
     * Set login
     *
     * @param string $login
     *
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return User
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set nameFirst
     *
     * @param string $nameFirst
     *
     * @return User
     */
    public function setNameFirst($nameFirst)
    {
        $this->nameFirst = $nameFirst;

        return $this;
    }

    /**
     * Get nameFirst
     *
     * @return string
     */
    public function getNameFirst()
    {
        return $this->nameFirst;
    }

    /**
     * Set nameLast
     *
     * @param string $nameLast
     *
     * @return User
     */
    public function setNameLast($nameLast)
    {
        $this->nameLast = $nameLast;

        return $this;
    }

    /**
     * Get nameLast
     *
     * @return string
     */
    public function getNameLast()
    {
        return $this->nameLast;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return User
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
     * Constructor
     */
    public function __construct()
    {
        $this->bettingGames = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add bettingGame
     *
     * @param \WebtippBundle\Entity\BettingGame $bettingGame
     *
     * @return User
     */
    public function addBettingGame(\WebtippBundle\Entity\BettingGame $bettingGame)
    {
        $this->bettingGames[] = $bettingGame;

        return $this;
    }

    /**
     * Remove bettingGame
     *
     * @param \WebtippBundle\Entity\BettingGame $bettingGame
     */
    public function removeBettingGame(\WebtippBundle\Entity\BettingGame $bettingGame)
    {
        $this->bettingGames->removeElement($bettingGame);
    }

    /**
     * Get bettingGames
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBettingGames()
    {
        return $this->bettingGames;
    }
}
