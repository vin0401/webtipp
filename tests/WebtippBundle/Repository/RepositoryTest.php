<?php
/**
 * Author: Daniel Richardt <d.richardt@dmpr-dev.de>
 * Date: 27.04.2017
 * Time: 19:45
 */

namespace Tests\WebtippBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use WebtippBundle\Entity\Group;
use WebtippBundle\Entity\User;
use WebtippBundle\Entity\Right;
use WebtippBundle\Entity\Matchday;
use WebtippBundle\Entity\Match;
use WebtippBundle\Entity\Bet;

class RepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     *
     */
    public function testCreateTestUser()
    {
        $user = new User();
        $user->setLogin('test');
        $user->setMail('test@test.test');
        $user->setPassword('test');
        $user->setNameFirst('test');
        $user->setNameLast('test');
        $user->setGender('male');

        $this->em->persist($user);
        $this->em->flush();

        $user = $this->em
            ->getRepository('WebtippBundle:User')
            ->findBy(['login' => 'test']);

        $this->assertEquals(1, count($user));
    }

    /**
     *
     */
    public function testCreateTestGroup()
    {
        $user = $this->em
            ->getRepository('WebtippBundle:User')
            ->findOneBy(['login' => 'test']);

        $group = new Group();
        $group->setCreateUser($user);
        $group->setName('Test Group');
        $group->setSeason('bl1');
        $group->setPointsFull(4);
        $group->setPointsPart(2);
        $group->setCreateDate(time());

        $this->em->persist($group);
        $this->em->flush();

        $group = $this->em
            ->getRepository('WebtippBundle:Group')
            ->findBy(['name' => 'Test Group']);

        $this->assertEquals(1, count($group));
    }

    /**
     *
     */
    public function testAddUserToGroup()
    {
        $user = $this->em
            ->getRepository('WebtippBundle:User')
            ->findOneBy(['login' => 'test']);

        $group = $this->em
            ->getRepository('WebtippBundle:Group')
            ->findOneBy(['name' => 'Test Group']);

        $user->addGroup($group);

        $this->em->persist($user);
        $this->em->flush();

        $group = $this->em
            ->getRepository('WebtippBundle:Group')
            ->findOneBy(['name' => 'Test Group']);

        $groupUsers = $group->getUsers();

        $this->assertEquals(1, count($groupUsers));
    }

    /**
     *
     */
    public function testCreateRightsAndAddThemToGroup()
    {
        $group = $this->em
            ->getRepository('WebtippBundle:Group')
            ->findOneBy(['name' => 'Test Group']);

        $rights = [
            'normal' => new Right(),
            'admin' => new Right(),
        ];

        foreach ($rights as $type => $right) {
            $right->setType($type);
            $right->setGroup($group);
            $this->em->persist($right);
        }

        $this->em->flush();

        $group = $this->em
            ->getRepository('WebtippBundle:Group')
            ->findOneBy(['name' => 'Test Group']);

        $rights = $group->getRights();

        $this->assertEquals(2, count($rights));
    }

    /**
     *
     */
    public function testAddRightToTestUsers()
    {
        $user = $this->em
            ->getRepository('WebtippBundle:User')
            ->findOneBy(['login' => 'test']);

        $group = $this->em
            ->getRepository('WebtippBundle:Group')
            ->findOneBy(['name' => 'Test Group']);

        $rights = $this->em
            ->getRepository('WebtippBundle:Right')
            ->findBy([
                'group' => $group,
                'type' => 'normal'
            ]);

        $this->assertEquals(1, count($rights));

        $right = $rights[0];

        $user->addRight($right);
        $this->em->persist($user);
        $this->em->flush();

        $user = null;

        $user = $this->em
            ->getRepository('WebtippBundle:User')
            ->findOneBy(['login' => 'test']);

        $this->assertEquals(1, count($user->getRights()));
    }

    /**
     *
     */
    public function testAddAdminRightToTestUser()
    {
        $user = $this->em
            ->getRepository('WebtippBundle:User')
            ->findOneBy(['login' => 'test']);

        $this->assertEquals(1, count($user->getRights()));


        foreach ($user->getGroups() as $group) {
            foreach ($group->getRights() as $right) {
                if ($right->getType() === 'admin') {
                    $user->addRight($right);
                }
            }
        }

        $this->em->persist($user);
        $this->em->flush();

        $user = $this->em
            ->getRepository('WebtippBundle:User')
            ->findOneBy(['login' => 'test']);

        $rights = $user->getRights();

        $this->assertEquals(2, count($rights));
    }

    /**
     *
     */
    public function testAddMatchdaysToGroup()
    {
        $group = $this->em
            ->getRepository('WebtippBundle:Group')
            ->findOneBy(['name' => 'Test Group']);

        for ($i = 1; $i <= 34; $i++) {
            $matchday = new Matchday();

            $matchday->setGroup($group);
            $matchday->setDateStart(time() + 8640000 + 604800 * $i);
            $matchday->setDateEnd(time() + 8640000 + 604800 * $i + 259200);

            $this->em->persist($matchday);
        }

        $this->em->flush();

        $matchdays = $this->em
            ->getRepository('WebtippBundle:Matchday')
            ->findBy(['group' => $group]);

        $this->assertEquals(34, count($matchdays));
    }

    /**
     *
     */
    public function testAddMatchesToMatchdays()
    {
        $group = $this->em
            ->getRepository('WebtippBundle:Group')
            ->findOneBy(['name' => 'Test Group']);

        foreach ($group->getMatchdays() as $matchday) {
            for ($i = 1; $i <= 9; $i++) {
                $match = new Match();

                $match->setMatchday($matchday);
                $match->setTeamHome('FC Schalke 04');
                $match->setTeamAway('FC Bayern München');
                $match->setState('pending');
                $match->setDateStart($matchday->getDateStart());
                $match->setDateEnd($matchday->getDateEnd());

                $this->em->persist($match);
            }
        }

        $this->em->flush();

        $matchdays = $this->em
            ->getRepository('WebtippBundle:Matchday')
            ->findBy(['group' => $group]);

        foreach ($matchdays as $matchday) {
            $this->assertEquals(9, count($matchday->getMatches()));
        }
    }

    /**
     *
     */
    public function testPlaceBets()
    {
        $user = $this->em
            ->getRepository('WebtippBundle:User')
            ->findOneBy(['login' => 'test']);


        foreach ($user->getGroups() as $group) {
            foreach ($group->getMatchdays() as $matchday) {
                foreach ($matchday->getMatches() as $match) {
                    $bet = new Bet();

                    $bet->setUser($user);
                    $bet->setMatch($match);
                    $bet->setGoalsTeamAway(0);
                    $bet->setGoalsTeamHome(2);

                    $bet->setDateCreate(time());
                    $bet->setDateUpdate(time());
                    $bet->setState('pending');

                    $this->em->persist($bet);
                }
            }
        }

        $this->em->flush();

        $group = $this->em
            ->getRepository('WebtippBundle:Group')
            ->findOneBy(['name' => 'Test Group']);


        $bets = $this->em
            ->getRepository('WebtippBundle:Bet')
            ->findBy([
                'user' => $user
            ]);

        $this->assertEquals(306, count($bets));
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}
