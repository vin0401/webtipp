<?php

namespace WebtippBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use WebtippBundle\Entity\User;
use WebtippBundle\Entity\Groups;

class DefaultController extends Controller
{

    public function dashboardAction(Request $request)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $imagePath = $this->getParameter('profile_image_web_path');

        return $this->render('default/dashboard.html.php', [
            'user' => $user,
            'imagePath' => $imagePath,
            'groups' => $user->getGroups(),
        ]);
    }

    public function syncAllAction(Request $request)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $db = $this->container->get('open-liga-databridge');
        $db->syncAll();

        return $this->render('default/index.html.php', [
        ]);
    }

    public function syncBetsAction(Request $request)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $db = $this->container->get('open-liga-databridge');

        $groups =$this->getDoctrine()->getManager()
            ->getRepository('WebtippBundle:Group')
            ->findAll();

        foreach ($groups as $group) {
            $db->syncBets($group);
        }

        return $this->render('default/index.html.php', [
        ]);
    }

    public function syncScoresAction(Request $request)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $db = $this->container->get('open-liga-databridge');

        $groups =$this->getDoctrine()->getManager()
            ->getRepository('WebtippBundle:Group')
            ->findAll();

        foreach ($groups as $group) {
            $db->syncScores($group);
        }

        return $this->render('default/index.html.php', [
        ]);
    }
}
