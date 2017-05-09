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
 * @ORM\Table(name="groups")
 */
class Group
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id", options={"unsigned"=true})
     */
    private $id;

    /**
     * @var \WebtippBundle\Entity\User
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
     */
    private $users;

    /**
     * @var \WebtippBundle\Entity\Right
     *
     * @ORM\OneToMany(targetEntity="Right", mappedBy="group")
     */
    private $rights;

    /**
     * @var \WebtippBundle\Entity\Matchday
     *
     * @ORM\OneToMany(targetEntity="Matchday", mappedBy="group")
     */
    private $matchdays;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $season;
    
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $points_full;
    
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $points_part;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $createDate;

    /**
     * @var \WebtippBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="create_user", referencedColumnName="id")
     */
    private $createUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rights = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matchdays = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Group
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
     * Set season
     *
     * @param string $season
     *
     * @return Group
     */
    public function setSeason($season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return string
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set pointsFull
     *
     * @param integer $pointsFull
     *
     * @return Group
     */
    public function setPointsFull($pointsFull)
    {
        $this->points_full = $pointsFull;

        return $this;
    }

    /**
     * Get pointsFull
     *
     * @return integer
     */
    public function getPointsFull()
    {
        return $this->points_full;
    }

    /**
     * Set pointsPart
     *
     * @param integer $pointsPart
     *
     * @return Group
     */
    public function setPointsPart($pointsPart)
    {
        $this->points_part = $pointsPart;

        return $this;
    }

    /**
     * Get pointsPart
     *
     * @return integer
     */
    public function getPointsPart()
    {
        return $this->points_part;
    }

    /**
     * Set createDate
     *
     * @param integer $createDate
     *
     * @return Group
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return integer
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set createUser
     *
     * @param integer $createUser
     *
     * @return Group
     */
    public function setCreateUser($createUser)
    {
        $this->createUser = $createUser;

        return $this;
    }

    /**
     * Get createUser
     *
     * @return integer
     */
    public function getCreateUser()
    {
        return $this->createUser;
    }

    /**
     * Add user
     *
     * @param \WebtippBundle\Entity\User $user
     *
     * @return Group
     */
    public function addUser(\WebtippBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \WebtippBundle\Entity\User $user
     */
    public function removeUser(\WebtippBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add right
     *
     * @param \WebtippBundle\Entity\Right $right
     *
     * @return Group
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
     * Add matchday
     *
     * @param \WebtippBundle\Entity\Matchday $matchday
     *
     * @return Group
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
}
