<?php
/**
 * Author: Daniel Richardt <d.richardt@dpmr-dev.de>
 * Date: 26.04.2017
 * Time: 19:49
 */

namespace WebtippBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @UniqueEntity("mail")
 * @UniqueEntity("login")
 */
class User
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
     * @var \WebtippBundle\Entity\UserGroupMapping
     *
     * @ORM\OneToMany(targetEntity="UserGroupMapping", mappedBy="user")
     */
    private $userGroupMappings;

    /**
     * @var string
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", unique=true, length=100)
     */
    private $login;

    /**
     * @var string
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @var string
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=100)
     */
    private $nameFirst;

    /**
     * @var string
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=100)
     */
    private $nameLast;

    /**
     * @var string
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", columnDefinition="ENUM('male', 'female')")
     */
    private $gender;

    /**
     * @var integer
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="integer")
     */
    private $birthday;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Image(
     *     allowLandscape = false,
     *     allowPortrait = false
     * )
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png" })
     */
    private $image;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
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
     * @param Group $group
     * @param Match $match
     *
     * @return integer
     */
    public function getMatchScore(Group $group, Match $match)
    {
        $score = 0;

        $pointsFull = $group->getPointsFull();
        $pointsPart = $group->getPointsPart();

        foreach ($this->getBets() as $bet) {
            if ($bet->getGroup() === $group && $match === $bet->getMatch()) {
                $state = $bet->getState();

                if ($state === 'won') {
                    $score += $pointsFull;
                }

                if ($state === 'part') {
                    $score += $pointsPart;
                }
            }
        }

        return $score;
    }

    /**
     * @param Group $group
     * @param Matchday $matchday
     *
     * @return integer
     */
    public function getMatchdayScore(Group $group, Matchday $matchday)
    {
        $score = 0;

        $pointsFull = $group->getPointsFull();
        $pointsPart = $group->getPointsPart();

        foreach ($this->getBets() as $bet) {
            if ($bet->getGroup() === $group && $matchday === $bet->getMatchday()) {
                $state = $bet->getState();

                if ($state === 'won') {
                    $score += $pointsFull;
                }

                if ($state === 'part') {
                    $score += $pointsPart;
                }
            }
        }

        return $score;
    }

    /**
     * @param Group $group
     *
     * @return integer
     */
    public function getTotalScore(Group $group)
    {
        $score = 0;

        $pointsFull = $group->getPointsFull();
        $pointsPart = $group->getPointsPart();

        foreach ($this->getBets() as $bet) {
            if ($bet->getGroup() === $group) {
                $state = $bet->getState();

                if ($state === 'won') {
                    $score += $pointsFull;
                }

                if ($state === 'part') {
                    $score += $pointsPart;
                }
            }
        }

        return $score;
    }

    /**
     * @param Group $group
     *
     * @return true|false
     */
    public function hasGroup(Group $group)
    {
        foreach ($this->getGroups() as $existingGroup) {
            if ($group === $existingGroup) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBets()
    {
        return $this->bets;
    }

    /**
     * @param Group $group
     * @param Matchday $matchday
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatchdayBets(Group $group, Matchday $matchday)
    {
        $bets = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($this->getBets() as $bet) {
            if ($bet->getGroup() === $group && (is_null($matchday) || $matchday === $bet->getMatchday())) {
                $bets[] = $bet;
            }
        }

        return $bets;
    }

    /**
     * @param Group $group
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupBets(Group $group)
    {
        $bets = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($this->getBets() as $bet) {
            if ($bet->getGroup() === $group) {
                $bets[] = $bet;
            }
        }

        return $bets;
    }

    /**
     * @param Group $group
     * @param Match $match
     *
     * @return Bet|false
     */
    public function getMatchBet(Group $group, Match $match)
    {
        foreach ($this->getBets() as $bet) {
            if ($bet->getGroup() === $group && $bet->getMatch() === $match) {
                return $bet;
            }
        }

        return false;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroups()
    {
        $groups = new \Doctrine\Common\Collections\ArrayCollection();

        foreach ($this->getUserGroupMappings() as $userGroupMapping) {
            $groups[] = $userGroupMapping->getGroup();
        }

        return $groups;
    }

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
     * Set imagePath
     *
     * @param string $imagePath
     *
     * @return User
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return User
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Add userGroupMapping
     *
     * @param \WebtippBundle\Entity\UserGroupMapping $userGroupMapping
     *
     * @return User
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
     * Set image
     *
     * @param string $image
     *
     * @return User
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set birthday
     *
     * @param integer $birthday
     *
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return integer
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set dateCreate
     *
     * @param integer $dateCreate
     *
     * @return User
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
     * @return User
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
