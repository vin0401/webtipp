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
 * @ORM\Table(name="rights")
 */
class Right
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
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="rights")
     * @ORM\JoinColumn(name="id_group", referencedColumnName="id")
     */
    private $group;

    /**
     * @var \WebtippBundle\Entity\User
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="rights")
     */
    private $users;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type="string", nullable=false, columnDefinition="ENUM('admin', 'normal')", options={"default":"normal"}
     *     )
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
     * Set type
     *
     * @param string $type
     *
     * @return Right
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
     * Set group
     *
     * @param \WebtippBundle\Entity\Group $group
     *
     * @return Right
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
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \WebtippBundle\Entity\User $user
     *
     * @return Right
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
}
