<?php
/**
 * Author: Daniel Richardt <d.richardt@dmpr-dev.de>
 * Date: 29.04.2017
 * Time: 03:57
 */

namespace WebtippBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use WebtippBundle\Entity\Group;
use WebtippBundle\Entity\Matchday;
use WebtippBundle\Entity\Match;
use WebtippBundle\Entity\Bet;

/**
 * Class MatchdayController
 * @package WebtippBundle\Controller
 */
class MatchdayController extends Controller
{
    /**
     * @param Request $request
     * @param null $groupSlug
     * @param $matchdaySlug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function placeBetAction(Request $request, $groupSlug, $matchdaySlug)
    {
        $auth = $this->container->get('authentication');
        $user = $auth->getCurrentUser();

        $errors = [];
        $bets = [];

        if (!$user) {
            $errors['user'] = true;
        }

        if (empty($errors)) {
            $doctrine = $this->getDoctrine();
            $em = $doctrine->getManager();

            /**
             * @var Matchday $matchday
             */
            $matchday = $doctrine
                ->getRepository('WebtippBundle:Matchday')
                ->findOneBy(['id' => $matchdaySlug]);

            /**
             * @var Group $group
             */
            $group = $doctrine
                ->getRepository('WebtippBundle:Group')
                ->findOneBy(['id' => $groupSlug]);

            if (empty($matchday)) {
                $errors['matchday'] = true;
            }

            $betData = $request->get('bets');

            if (!is_array($betData)) {
                $errors['structure'] = true;
            } elseif (empty($errors)) {
                $matches = $doctrine
                    ->getRepository('WebtippBundle:Match')
                    ->findBy([
                        'matchday' => $matchday,
                    ]);
                if (count($matches) !== count($betData)) {
                    $errors['count'] = true;
                }
            }
        }

        if (empty($errors)) {
            foreach ($matches as $match) {
                if ($match->getState() !== "pending") {
                    $errors['bets'] = [];

                    $errors['bets'][$match->getOrder()]['state'] = true;

                    continue;
                }

                if (!empty($betData[$match->getOrder()])) {
                    $bet = $doctrine
                        ->getRepository('WebtippBundle:Bet')
                        ->findOneBy([
                            'user' => $user,
                            'match' => $match,
                            'group' => $group,
                        ]);

                    if (empty($bet)) {
                        $bet = new Bet();

                        $bet->setDateCreate(time());
                    }

                    foreach ($betData[$match->getOrder()] as $type => $matchBet) {
                        if ($betData[$match->getOrder()][$type] === '') {
                            $matchBet = null;

                            if (!isset($errors['bets'])) {
                                $errors['bets'] = [];
                            }

                            $errors['bets'][$match->getOrder()][$type] = true;
                        } else {
                            $matchBet = (int)$matchBet;
                        }

                        $betData[$match->getOrder()][$type] = $matchBet;
                    }

                    $bet->setGoalsTeamHome($betData[$match->getOrder()]['home']);
                    $bet->setGoalsTeamAway($betData[$match->getOrder()]['away']);


                    $bet->setUser($user);
                    $bet->setMatch($match);
                    $bet->setGroup($group);

                    $match->addBet($bet);
                    $group->addBet($bet);
                    $user->addBet($bet);


                    $bet->setState('pending');
                    $bet->setDateUpdate(time());

                    $em->persist($bet);


                    $bets[$match->getOrder()] = $bet;
                } else {
                    $errors['bets'][$match->getOrder()] = true;
                }
            }
        }

        if (empty($errors)) {
            $em->persist($match);
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('matchday', [
                'groupSlug' => $group->getId(),
                'matchdaySlug' => $matchday->getId(),
            ]);
        }

        return $this->render('matchday/detail.html.php', [
            'bets' => $bets,
            'group' => $group,
            'users' => $group->getUsers(),
            'matchday' => $matchday,
            'errors' => $errors,
            'submit' => true
        ]);
    }

    /**
     * @param Request $request
     * @param null $groupSlug
     * @param null $matchdaySlug
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function detailAction(Request $request, $groupSlug = null, $matchdaySlug = null)
    {
        $auth = $this->container->get('authentication');

        $user = $auth->getCurrentUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $errors = [];

        $doctrine = $this->getDoctrine();

        $group = $doctrine
            ->getRepository('WebtippBundle:Group')
            ->findOneBy(['id' => $groupSlug]);

        if (empty($group)) {
            return $this->redirectToRoute('dashboard');
        }

        $matchday = $doctrine
            ->getRepository('WebtippBundle:Matchday')
            ->findOneBy(['id' => $matchdaySlug]);

        if (empty($matchday)) {
            return $this->redirectToRoute('group', ['slug' => $groupSlug]);
        }

        $matches = $matchday->getMatches();

        $db = $this->container->get('open-liga-databridge');

        $lastChange = $db->getLastChangeDate($matchday);

        if ($lastChange > $matchday->getDateUpdate()) {
            $db->syncMatchdayMatches($group->getSeason(), $matchday);
            $db->syncBets($group);
        } elseif ($lastChange > $group->getDateUpdate()) {
            $db->syncBets($group);
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

        $repository = $this->getDoctrine()->getRepository('WebtippBundle:Bet');
        $query = $repository->createQueryBuilder('b')
            ->innerJoin('b.group', 'g')
            ->innerJoin('b.user', 'u')
            ->innerJoin('b.match', 'm')
            ->where('b.match IN (:matches)')
            ->andWhere('b.group = :group')
            ->andWhere('b.user = :user')
            ->setParameters([
                'user' => $user,
                'matches' => $matches,
                'group' => $group
            ])
            ->orderBy('m.order')
            ->getQuery();

        $results = $query->getResult();

        $bets = [];
        foreach ($results as $bet) {
            $bets[$bet->getMatch()->getOrder()] = $bet;
        }

        return $this->render('matchday/detail.html.php', [
            'user' => $user,
            'users' => $users,
            'bets' => $bets,
            'group' => $group,
            'matchday' => $matchday,
            'errors' => $errors,
            'submit' => false
        ]);
    }
}
