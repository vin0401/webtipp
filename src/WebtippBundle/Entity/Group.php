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
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id", options={"unsigned"=true})
     */
    private $id;

    /**
     * @var \WebtippBundle\Entity\UserGroupMapping
     *
     * @ORM\OneToMany(targetEntity="UserGroupMapping", mappedBy="group")
     */
    private $userGroupMappings;

    /**
     * @var \WebtippBundle\Entity\Right
     *
     * @ORM\OneToMany(targetEntity="Right", mappedBy="group")
     */
    private $rights;

    /**
     * @var \WebtippBundle\Entity\Bet
     *
     * @ORM\OneToMany(targetEntity="Bet", mappedBy="group")
     */
    private $bets;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="groups")
     * @ORM\JoinColumn(name="id_season", referencedColumnName="id")
     */
    private $season;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $name;

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
     * @var string
     *
     * @ORM\Column(
     *     type="string", nullable=false, columnDefinition="ENUM('public', 'closed')", options={"default":"closed"}
     *     )
     */
    private $type = 'closed';

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $dateCreate;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dateUpdate;

    /**
     * @var \WebtippBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="create_user", referencedColumnName="id")
     */
    private $createUser;

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatchdays()
    {
        return $this->getSeason()->getMatchdays();
    }

    /**
     * @param string $type
     *
     * @return Right
     */
    public function getRight($type = 'normal')
    {
        foreach ($this->getRights() as $right) {
            if ($right->getType() === $type) {
                return $right;
            }
        }

        return false;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rights = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dateCreate
     *
     * @param integer $dateCreate
     *
     * @return Group
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
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        $users = new \Doctrine\Common\Collections\ArrayCollection();

        foreach ($this->userGroupMappings as $userGroupMapping) {
            $users[] = $userGroupMapping->getUser();
        }
        
        return $users;
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
     * Set season
     *
     * @param \WebtippBundle\Entity\Season $season
     *
     * @return Group
     */
    public function setSeason(\WebtippBundle\Entity\Season $season = null)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return \WebtippBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set createUser
     *
     * @param \WebtippBundle\Entity\User $createUser
     *
     * @return Group
     */
    public function setCreateUser(\WebtippBundle\Entity\User $createUser = null)
    {
        $this->createUser = $createUser;

        return $this;
    }

    /**
     * Get createUser
     *
     * @return \WebtippBundle\Entity\User
     */
    public function getCreateUser()
    {
        return $this->createUser;
    }

    /**
     * Add bet
     *
     * @param \WebtippBundle\Entity\Bet $bet
     *
     * @return Group
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
     * Set type
     *
     * @param string $type
     *
     * @return Group
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
     * Add userGroupMapping
     *
     * @param \WebtippBundle\Entity\UserGroupMapping $userGroupMapping
     *
     * @return Group
     */
    public function addUserGroupMapping(\WebtippBundle\Entity\UserGroupMapping $userGroupMapping)
    {
        $this->userGroupMappings[] = $userGroupMapping;

        return $this;
    }

    /**
     * Remove userGroupMapping
     *
     * @param \WebtippBundle\Entity\UserGroupMapping $userGroupMapping
     */
    public function removeUserGroupMapping(\WebtippBundle\Entity\UserGroupMapping $userGroupMapping)
    {
        $this->userGroupMappings->removeElement($userGroupMapping);
    }

    /**
     * Get userGroupMappings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserGroupMappings()
    {
        return $this->userGroupMappings;
    }

    /**
     * Set dateUpdate
     *
     * @param integer $dateUpdate
     *
     * @return Group
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
