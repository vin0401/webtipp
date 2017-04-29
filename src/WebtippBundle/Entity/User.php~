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
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id", options={"unsigned"=true})
     */
    private $id;

    /**
     * @var \WebtippBundle\Entity\Group
     *
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
     * @ORM\JoinTable(
     *  name="user_groups",
     *  joinColumns={
     *      @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="id_group", referencedColumnName="id")
     *  }
     * )
     */
    protected $groups;

    /**
     * @var \WebtippBundle\Entity\Right
     *
     * @ORM\ManyToMany(targetEntity="Right", inversedBy="users")
     * @ORM\JoinTable(
     *  name="user_rights",
     *  joinColumns={
     *      @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="id_right", referencedColumnName="id")
     *  }
     * )
     */
    protected $rights;

    /**
     * @var \WebtippBundle\Entity\Bet
     *
     * @ORM\OneToMany(targetEntity="Bet", mappedBy="user")
     */
    private $bets;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=100)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $nameFirst;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $nameLast;

    /**
     * @var string
     *
     * @ORM\Column(type="string", columnDefinition="ENUM('male', 'female')")
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=100)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(type="string", columnDefinition="ENUM('active', 'inactive')")
     */
    private $state;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rights = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add group
     *
     * @param \WebtippBundle\Entity\Group $group
     *
     * @return User
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
     * Add right
     *
     * @param \WebtippBundle\Entity\Right $right
     *
     * @return User
     */
    public function addRight(\WebtippBundle\Entity\Right $right)
    {
        $this->rights[] = $right;

        return $this;
    }

    /**
     * Remove right
     *
     * @param \WebtippBundle\Entity\Right $right
     */
    public function removeRight(\WebtippBundle\Entity\Right $right)
    {
        $this->rights->removeElement($right);
    }

    /**
     * Get rights
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * Add bet
     *
     * @param \WebtippBundle\Entity\Bet $bet
     *
     * @return User
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
     * @return User
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
