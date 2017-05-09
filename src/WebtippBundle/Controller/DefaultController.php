<?php

namespace WebtippBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use WebtippBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->loginAction($request);
    }

    public function loginAction(Request $request)
    {
        $auth = $this->container->get('authentication');
        if ($auth->isLoggedIn()) {
            return $this->redirectToRoute('dashboard');
        }

        $data = [
            'login' => $request->request->get('user'),
            'password' => $request->request->get('password'),
        ];

        $errors = [];

        if ($request->getMethod() === 'POST') {
            if (empty($data['login'])) {
                $errors['login'] = true;
            }

            if (empty($data['password'])) {
                $errors['password'] = true;
            }

            if (empty($errors)) {
                $repository = $this->getDoctrine()->getRepository('WebtippBundle:User');
                $user = $repository->findOneBy(["login" => $data['login']]);

                if (empty($user)) {
                    $errors['user'] = true;
                } else {
                    $auth = $this->container->get('authentication');
                    if ($auth->verifyPassword($data['password'], $user->getPassword())) {
                        $auth->login($user->getLogin(), $user->getId());

                        return $this->redirectToRoute('dashboard');
                    } else {
                        $errors['wrong-password'] = true;
                    }
                }
            }
        }


        return $this->render('default/login.html.php', [
            'errors' => $errors,
            'data' => $data
        ]);
    }

    public function registerAction(Request $request)
    {
        $auth = $this->container->get('authentication');

        if ($auth->isLoggedIn()) {
            return $this->redirectToRoute('dashboard');
        }

        $data = [
            'login' => trim($request->request->get('user')),
            'name-first' => trim($request->request->get('name-first')),
            'name-last' => trim($request->request->get('name-last')),
            'gender' => trim($request->request->get('gender')),
            'mail' => trim($request->request->get('mail')),
            'password1' => trim($request->request->get('password1')),
            'password2' => trim($request->request->get('password2')),
        ];

        $errors = [];

        if ($request->getMethod() === 'POST') {
            if (empty($data['login'])) {
                $errors['login'] = true;
            }

            if (empty($data['name-first'])) {
                $errors['name-first'] = true;
            }

            if (empty($data['name-last'])) {
                $errors['name-last'] = true;
            }

            if (empty($data['gender']) || !in_array($data['gender'], ['male', 'female'])) {
                $errors['gender'] = true;
            }

            if (empty($data['mail']) || !filter_var($data['mail'], FILTER_VALIDATE_EMAIL)) {
                $errors['mail'] = true;
            }

            if (empty($data['password1']) || empty($data['password2']) || ($data['password1'] !== $data['password2'])) {
                $errors['password'] = true;
            } else {
                $password = $data['password1'];
            }

            if (empty($errors)) {
                $repository = $this->getDoctrine()->getRepository('WebtippBundle:User');
                $user = $repository->findBy(["mail" => $data['mail']]);

                if (!empty($user)) {
                    $errors['user'] = true;
                } else {
                    $user = $repository->findBy(["login" => $data['login']]);

                    if (!empty($user)) {
                        $errors['user'] = true;
                    }
                }
            }

            if (empty($errors)) {
                $hash = $auth->hashPassword($password);

                $user = new User();
                $user->setLogin($data['login']);
                $user->setMail($data['mail']);
                $user->setPassword($hash);
                $user->setNameFirst($data['name-first']);
                $user->setNameLast($data['name-last']);
                $user->setGender($data['gender']);
                $user->setType('normal');

                $em = $this->getDoctrine()->getManager();

                $em->persist($user);

                $em->flush();

                $auth->login($user->getLogin(), $user->getId());

                return $this->redirectToRoute('dashboard');
            }
        }

        return $this->render('default/register.html.php', [
            'errors' => $errors,
            'data' => $data,
        ]);
    }

    public function dashboardAction(Request $request)
    {
        $auth = $this->container->get('authentication');

        if (!$auth->isLoggedIn()) {
            return $this->redirectToRoute('login');
        }

        return $this->render('default/dashboard.html.php', [
        ]);
    }

    /**
     * @todo:
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function profileAction(Request $request)
    {
        $auth = $this->container->get('authentication');
        $user = $auth->getCurrentUser();

        if (empty($user)) {
            return $this->redirectToRoute('login');
        }

        $presets = [
            'login' => $user->getLogin(),
            'name-first' => $user->getNameFirst(),
            'name-last' => $user->getNameLast(),
            'mail' => $user->getMail(),
            'gender' => $user->getGender(),
            'password1' => '*******',
            'password2' => '*******',
        ];

        $errors = [];

        if ($request->getMethod() === 'POST') {
            $data = [
                'login' => trim($request->request->get('user')),
                'name-first' => trim($request->request->get('name-first')),
                'name-last' => trim($request->request->get('name-last')),
                'gender' => trim($request->request->get('gender')),
                'mail' => trim($request->request->get('mail')),
                'password1' => trim($request->request->get('password1')),
                'password2' => trim($request->request->get('password2')),
            ];
        } else {
            $data = $presets;
        }

        return $this->render('default/profile.html.php', [
            'data' => $data,
        ]);
    }

    public function logoutAction(Request $request)
    {
        $auth = $this->container->get('authentication');

        if ($auth->isLoggedIn()) {
            $auth->logout();
        }

        return $this->redirectToRoute('login');
    }
}
