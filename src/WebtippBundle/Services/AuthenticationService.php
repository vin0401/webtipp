<?php
/**
 * Author: Daniel Richardt <d.richardt@dmpr-dev.de>
 * Date: 26.04.2017
 * Time: 21:41
 */

namespace WebtippBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use WebtippBundle\Entity\User;

class AuthenticationService extends ServiceAbstract
{
    /**
     * @var $session Request;
     */
    protected $request;

    /**
     * @var $session EntityManager;
     */
    protected $em;

    /**
     * @param RequestStack $requestStack
     * @param EntityManager $em
     */
    protected function init(RequestStack $requestStack, EntityManager $em)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->em = $em;
    }

    /**
     * @param string $password
     * @return string
     */
    public function hashPassword($password)
    {
        if (!is_string($password)) {
            throw new \InvalidArgumentException('Argument must be a string, ' . gettype($password) . ' given');
        }

        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * @param string $password
     * @param string $hash
     * @return boolean
     */
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     */
    public function login($username, $id)
    {
        $session = $this->request->getSession();

        $session->set('user', $username);
        $session->set('token', md5($id));
    }

    /**
     */
    public function logout()
    {
        $this->request->getSession()->invalidate();
    }

    /**
     * @return boolean
     */
    public function isLoggedIn()
    {
        $session = $this->request->getSession();
        $repository = $this->em->getRepository('WebtippBundle:User');
        $user = $repository->findOneBy(["login" => $session->get('user')]);

        return (!empty($user) && md5($user->getId()) === $session->get('token'));
    }

    /**
     * @return boolean
     */
    public function getCurrentUser()
    {
        $session = $this->request->getSession();
        $repository = $this->em->getRepository('WebtippBundle:User');
        $user = $repository->findOneBy(["login" => $session->get('user')]);

        if (!empty($user) && md5($user->getId()) === $session->get('token')) {
            return $user;
        }

        return false;
    }
}
