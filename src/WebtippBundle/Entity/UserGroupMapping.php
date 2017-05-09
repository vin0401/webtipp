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
 * @ORM\Table(name="user_groups")
 */
class UserGroupMapping
{
    /**
     * @var \WebtippBundle\Entity\User
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userGroupMappings")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \WebtippBundle\Entity\Group
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="userGroupMappings")
     * @ORM\JoinColumn(name="id_group", referencedColumnName="id")
     */
    private $group;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true, options={"unsigned"=true})
     */
    private $score;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true, options={"unsigned"=true})
     */
    private $rank;

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
     * Set score
     *
     * @param integer $score
     *
     * @return UserGroup
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     *
     * @return UserGroup
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set user
     *
     * @param \WebtippBundle\Entity\User $user
     *
     * @return UserGroup
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
     * Set group
     *
     * @param \WebtippBundle\Entity\Group $group
     *
     * @return UserGroup
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
}
