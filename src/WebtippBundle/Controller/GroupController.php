<?php
/**
 * Author: Daniel Richardt <d.richardt@dmpr-dev.de>
 * Date: 29.04.2017
 * Time: 03:57
 */

namespace WebtippBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use WebtippBundle\Entity\Right;
use WebtippBundle\Entity\Group;
use WebtippBundle\Entity\Score;
use WebtippBundle\Entity\Matchday;
use WebtippBundle\Entity\Match;
use WebtippBundle\Entity\Result;
use WebtippBundle\Entity\Season;
use WebtippBundle\Entity\Team;
use WebtippBundle\Entity\UserGroupMapping;

class GroupController extends Controller
{
    public function indexAction(Request $request)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }


        $publicGroups = $this->getDoctrine()
            ->getRepository('WebtippBundle:Group')
            ->findBy([
                'type' => 'public'
            ]);

        $newGroups = [];
        foreach ($publicGroups as $group) {
            if (!$user->hasGroup($group)) {
                $newGroups[] = $group;
            }
        }

        return $this->render('group/index.html.php', [
            'publicGroups' => $newGroups,
            'groups' => $user->getGroups(),
        ]);
    }

    public function joinAction(Request $request, $slug = null)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        $group = $doctrine
            ->getRepository('WebtippBundle:Group')
            ->findOneBy([
                'id' => $slug,
                'type' => 'public'
            ]);

        if (empty($group)) {
            return $this->redirectToRoute('groups');
        }

        if ($user->hasGroup($group)) {
            return $this->redirectToRoute('group', ['slug' => $group->getId()]);
        }

        $db = $this->container->get('open-liga-databridge');

        $userGroupMapping = new UserGroupMapping();

        $userGroupMapping->setUser($user);
        $userGroupMapping->setGroup($group);

        $group->addUserGroupMapping($userGroupMapping);
        $user->addUserGroupMapping($userGroupMapping);

        $user->addRight($group->getRight());

        $em->persist($user);
        $em->persist($group);
        $em->persist($userGroupMapping);

        $em->flush();
        $db->syncBets($group);

        return $this->redirectToRoute('group', ['slug' => $group->getId()]);
    }

    public function detailAction(Request $request, $slug = null)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $doctrine = $this->getDoctrine();

        $group = $doctrine
            ->getRepository('WebtippBundle:Group')
            ->findOneBy(['id' => $slug]);

        if (empty($group)) {
            return $this->redirectToRoute('groups');
        }


        $repository = $this->getDoctrine()->getRepository('WebtippBundle:User');
        $query = $repository->createQueryBuilder('u')
            ->innerJoin('u.userGroupMappings', 'ug')
            ->where('ug.group = :group')
            ->setParameters([
                'group' => $group
            ])
            ->orderBy('ug.rank', 'ASC')
            ->getQuery();

        $users = $query->getResult();

        $stats = [];

        foreach ($group->getSeason()->getMatchdays() as $matchday) {
            $presets = [];

            $presets['results'] = '-:-';
            $presets['points'] = 0;

            foreach ($group->getUsers() as $user) {
                if (!isset($stats[$user->getId()])) {
                    $stats[$user->getId()] = [];
                    $stats[$user->getId()]['login'] = $user->getLogin();
                    $stats[$user->getId()]['total'] = 0;
                    $stats[$user->getId()]['results'] = [];
                }

                if (!isset($stats[$user->getId()]['results'][$matchday->getOrder()])) {
                    $stats[$user->getId()]['results'][$matchday->getOrder()] = [];
                }

                foreach ($matchday->getMatches() as $match) {
                    $stats[$user->getId()]['results'][$matchday->getOrder()][$match->getOrder()] = $presets['results'];
                    $stats[$user->getId()]['points'][$matchday->getOrder()][$match->getOrder()] = $presets['points'];
                }
            }
        }

        return $this->render('group/detail.html.php', [
            'matchday' => $matchday,
            'users' => $users,
            'group' => $group
        ]);
    }

    public function createAction(Request $request)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $db = $this->container->get('open-liga-databridge');


        $errors = [];
        $group = new Group();

        $leagueApiId = 'bl1';
        $seasonYear = $db::YEAR;

        if ($request->getMethod() === 'POST') {
            $leagueApiId = trim($request->request->get('league'));
            $seasonYear = (int)trim($request->request->get('season'));
            $group->setName(trim($request->request->get('name')));
            $group->setPointsFull((int)trim($request->request->get('points-full')));
            $group->setPointsPart((int)trim($request->request->get('points-part')));
            $group->setType(trim($request->request->get('type')));

            $em->persist($group);

            $existingGroup = $doctrine
                ->getRepository('WebtippBundle:Group')
                ->findOneBy(['name' => $group->getName()]);

            if (empty($group->getName())) {
                $errors['name'] = true;
            }
            if (!empty($existingGroup)) {
                $errors['duplicate-name'] = true;
            }

            if (empty($leagueApiId) || is_null($db::LEAGUES[$leagueApiId])) {
                $errors['league'] = true;
            }

            if (empty($seasonYear) || !in_array($seasonYear, $db::SEASONS)) {
                $errors['season'] = true;
            }

            if (empty($group->getPointsFull())) {
                $errors['points-full'] = true;
            }

            if (empty($group->getPointsPart())) {
                $errors['points-part'] = true;
            }

            if (empty($errors)) {
                $league = $doctrine
                    ->getRepository('WebtippBundle:League')
                    ->findOneBy(['idApi' => $leagueApiId]);

                $season = $doctrine
                    ->getRepository('WebtippBundle:Season')
                    ->findOneBy(['league' => $league, 'year' => $seasonYear]);

                if (!empty($season)) {
                    $group->setCreateUser($user);
                    $group->setDateCreate(time());

                    $group->setSeason($season);

                    $userGroupMapping = new UserGroupMapping();

                    $userGroupMapping->setUser($user);
                    $userGroupMapping->setGroup($group);


                    $rights = [
                        'normal' => new Right(),
                        'admin' => new Right(),
                    ];

                    foreach ($rights as $type => $right) {
                        $right->setType($type);
                        $right->setGroup($group);
                        $em->persist($right);


                        $user->addRight($right);
                        $right->addUser($user);

                        $em->persist($right);
                    }

                    $group->addUserGroupMapping($userGroupMapping);
                    $user->addUserGroupMapping($userGroupMapping);
                    $season->addGroup($group);

                    $em->persist($userGroupMapping);
                    $em->persist($group);
                    $em->persist($user);
                    $em->persist($season);

                    $em->flush();

                    return $this->redirectToRoute('group', ['slug' => $group->getId()]);
                }
            }
        }

        return $this->render('group/create.html.php', [
            'leagues' => $db::LEAGUES,
            'league' => $leagueApiId,
            'seasons' => $db::SEASONS,
            'types' => ['public' => 'Öffentlich', 'closed' => 'Geschlossen'],
            'season' => $seasonYear,
            'group' => $group,
            'errors' => $errors,
        ]);
    }
}
