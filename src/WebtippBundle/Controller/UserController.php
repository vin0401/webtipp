<?php
/**
 * Author: Daniel Richardt <d.richardt@dmpr-dev.de>
 * Date: 29.04.2017
 * Time: 03:43
 */

namespace WebtippBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use WebtippBundle\Entity\User;

/**
 * Class UserController
 * @package WebtippBundle\Controller
 */
class UserController extends AbstractController
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if ($user) {
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

        return $this->render('user/login.html.php', [
            'errors' => $errors,
            'data' => $data
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if ($user) {
            return $this->redirectToRoute('dashboard');
        }

        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('login', TextType::class, ['required' => true])
            ->add('image', FileType::class, ['label' => 'Profilbild', 'required' => true])
            ->add('mail', EmailType::class, ['required' => true])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Password', 'required' => true),
                'second_options' => array('label' => 'Repeat Password', 'required' => true),
                'required' => true
            ])
            ->add('nameFirst', TextType::class, ['required' => true])
            ->add('nameLast', TextType::class, ['required' => true])
            ->add('birthday', DateType::class, ['required' => true])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'male' => 'Male',
                    'female' => 'Female'
                ],
                'required' => true
            ])
            ->add('save', SubmitType::class, ['label' => 'Registrieren'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $user = $form->getData();

                $user->setPassword($auth->hashPassword($user->getPassword()));

                $file = $user->getImage();

                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                $file->move(
                    $this->getParameter('profile_image_path'),
                    $fileName
                );

                $user->setImage($fileName);
                $user->setBirthday($user->getBirthday()->getTimestamp());
                $user->setDateCreate(time());
                $user->setDateUpdate(time());
                $em->persist($user);

                $em->flush();

                $auth->login($user->getLogin(), $user->getId());

                return $this->redirectToRoute('dashboard');
            }
        }

        return $this->render('user/register.html.php', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function changeProfileAction(Request $request)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $date = new \DateTime();
        $date->setTimestamp($user->getBirthday());

        $user->setBirthday($date);

        $form = $this->createFormBuilder($user)
            ->add('login', TextType::class, ['required' => true])
            ->add('image', FileType::class, array('label' => 'Profilbild', 'data_class' => null))
            ->add('mail', EmailType::class, ['required' => true])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Password', 'required' => true),
                'second_options' => array('label' => 'Repeat Password', 'required' => true),
                'required' => true
            ])
            ->add('nameFirst', TextType::class, ['required' => true])
            ->add('nameLast', TextType::class, ['required' => true])
            ->add('birthday', DateType::class, ['required' => true])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'male' => 'Male',
                    'female' => 'Female'
                ],
                'required' => true
            ])
            ->add('save', SubmitType::class, ['label' => 'Speichern'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $user = $form->getData();

                $user->setPassword($auth->hashPassword($user->getPassword()));

                $file = $user->getImage();

                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                $file->move(
                    $this->getParameter('profile_image_path'),
                    $fileName
                );

                $user->setImage($fileName);


                $user->setBirthday($user->getBirthday()->getTimestamp());
                $user->setDateCreate(time());
                $user->setDateUpdate(time());
                $em->persist($user);

                $em->flush();

                $auth->login($user->getLogin(), $user->getId());

                return $this->redirectToRoute('dashboard');
            }
        }

        return $this->render('user/change-profile.html.php', [
            'imagePath' => $this->getParameter('profile_image_web_path'),
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function profileAction(Request $request, $userSlug = null)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $user = $this->container->get('doctrine')
            ->getRepository('WebtippBundle:User')
            ->findOneBy(['id' => $userSlug]);

        if (empty($user)) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('user/profile.html.php', [
            'imagePath' => $this->getParameter('profile_image_web_path'),
            'user' => $user,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function logoutAction(Request $request)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if ($user) {
            $auth->logout();
        }

        return $this->redirectToRoute('login');
    }
}
