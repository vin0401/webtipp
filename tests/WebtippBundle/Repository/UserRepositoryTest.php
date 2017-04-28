<?php
/**
 * Author: Daniel Richardt <d.richardt@dmpr-dev.de>
 * Date: 27.04.2017
 * Time: 19:45
 */

namespace Tests\WebtippBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use WebtippBundle\Entity\User;

class UserRepositoryTest extends KernelTestCase
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
    public function testCreateUser()
    {
        $user = new User();
        $user->setLogin('test');
        $user->setMail('test@test.test');
        $user->setPassword('test');
        $user->setNameFirst('test');
        $user->setNameLast('test');
        $user->setGender('male');
        $user->setType('normal');

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     *
     */
    public function testFindUserByLogin()
    {
        $user = $this->em
            ->getRepository('WebtippBundle:User')
            ->findBy(['login' => 'test']);

        $this->assertCount(1, $user);
    }

    /**
     *
     */
    public function testRemoveUser()
    {
        $users = $this->em
            ->getRepository('WebtippBundle:User')
            ->findBy(['login' => 'test']);
        $this->assertCount(1, $users);

        $user = $users[0];

        $this->em->remove($user);
        $this->em->flush();


        $users = $this->em
            ->getRepository('WebtippBundle:User')
            ->findBy(['login' => 'test']);

        $this->assertCount(0, $users);
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
