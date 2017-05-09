<?php
/**
 * Author: Daniel Richardt <d.richardt@dmpr-dev.de>
 * Date: 30.04.2017
 * Time: 00:06
 */

namespace WebtippBundle\Services\OpenLiga;

use Doctrine\ORM\EntityManager;
use Doctrine;
use Prophecy\Exception\Exception;
use Symfony\Bridge\Twig\Extension\RoutingExtension;
use WebtippBundle\Entity\Group;
use WebtippBundle\Entity\ResultType;
use WebtippBundle\Entity\Team;
use WebtippBundle\Entity\Match;
use WebtippBundle\Entity\Matchday;
use WebtippBundle\Entity\Result;
use WebtippBundle\Entity\League;
use WebtippBundle\Entity\Season;


use WebtippBundle\Services\ServiceAbstract;

/**
 * Class DatabridgeService
 * @package WebtippBundle\Services\OpenLiga
 */
class DatabridgeService extends ServiceAbstract
{
    /**
     *
     */
    const YEAR = 2016;

    /**
     *
     */
    const LEAGUES = [
        'bl1' => '1. Bundesliga',
        //'bl2' => '2. Bundesliga',
    ];

    /**
     *
     */
    const SEASONS = [
        //'2015',
        '2016',
    ];

    /**
     *
     */
    const RESULT_TYPES = [
        'half',
        'end',
    ];

    /**
     * @var $em EntityManager;
     */
    protected $em;

    /**
     * @var ApiService $api
     */
    protected $api;

    /**
     * @param EntityManager $em
     * @param ApiService $api
     */
    protected function init(EntityManager $em, ApiService $api)
    {
        $this->em = $em;
        $this->api = $api;
    }

    /**
     * @param Season $season
     * @param Matchday $matchday
     *
     * @return true|false
     */
    public function getLastChangeDate($matchday)
    {
        $season = $matchday->getSeason();

        return strtotime(
            $this->api->getLastChangeDateFromApi(
                $season->getLeague()->getIdApi(),
                $season->getYear(),
                $matchday->getOrder()
            )
        );
    }

    /**
     * @param Season $season
     * @param Matchday $matchday
     *
     * @return true|false
     */
    public function hasUpdates($matchday)
    {
        $lastChange = $this->getLastChangeDate($matchday);

        return ($lastChange > $matchday->getDateUpdate());
    }

    /**
     * @param Season $season
     * @param Matchday $matchday
     * @return array
     */
    public function syncMatchdayMatches(Season $season, Matchday $matchday)
    {
        $lastChange = strtotime(
            $this->api->getLastChangeDateFromApi(
                $season->getLeague()->getIdApi(),
                $season->getYear(),
                $matchday->getOrder()
            )
        );

        $matches = [];
        $updatedMatches = $this->generateMatchdayMatches($season, $matchday);

        foreach ($updatedMatches as $updatedMatch) {
            $match = $this->em
                ->getRepository('WebtippBundle:Match')
                ->findOneBy(['idApi' => $updatedMatch->getIdApi()]);

            if (!empty($match)) {
                $match->setIdApi($updatedMatch->getIdApi());
                $match->setState($updatedMatch->getState());

                $match->setTeamHome($updatedMatch->getTeamHome());
                $match->setTeamAway($updatedMatch->getTeamAway());
                $match->setOrder($updatedMatch->getOrder());
                $match->setDateStart($updatedMatch->getDateStart());
                $match->setDateEnd($updatedMatch->getDateEnd());
                $match->setDateUpdate($updatedMatch->getDateUpdate());

                foreach ($updatedMatch->getResults() as $updatedResult) {
                    $result = $this->em
                        ->getRepository('WebtippBundle:Result')
                        ->findOneBy(['idApi' => $updatedResult->getIdApi()]);

                    if (!empty($result)) {
                        $result->setMatch($match);
                    } else {
                        $result = $updatedResult;
                    }

                    $result->setMatch($match);
                    $this->em->persist($result);
                }

                $match->setMatchday($updatedMatch->getMatchday());
            } else {
                $match = $updatedMatch;

                foreach ($match->getResults() as $result) {
                    $result->setMatch($match);
                    $this->em->persist($result);
                }
            }

            $this->em->persist($match);

            $matches[] = $match;
        }

        $matchday->setDateUpdate($lastChange);
        $this->em->persist($matchday);
        $this->em->flush();

        return $matches;
    }

    /**
     *
     */
    public function syncAll()
    {
        set_time_limit(0);
        ignore_user_abort(false);

        $leagues = $this->syncLeagues();

        foreach ($leagues as $league) {
            $seasons = $this->syncSeasons($league);

            foreach ($seasons as $season) {
                $teams = $this->syncTeams($season);

                $matchdays = $this->syncMatchdays($season);

                $matches = $this->syncMatches($season);

                $this->syncMatchdayDates($season);
            }
        }

        $groups = $this->em
            ->getRepository('WebtippBundle:Group')
            ->findAll();

        foreach ($groups as $group) {
            $this->syncBets($group);
        }
    }

    /**
     * @param Group $group
     */
    public function syncBets(Group $group)
    {
        $bets = $this->em
            ->getRepository('WebtippBundle:Bet')
            ->findBy(['group' => $group]);

        $pointsFull = $group->getPointsFull();
        $pointsPart = $group->getPointsPart();

        $scores = [];
        foreach ($bets as $bet) {
            $user = $bet->getUser();
            $userId = $user->getId();

            if (!isset($scores[$userId])) {
                $scores[$userId] = [
                    'user' => $user,
                    'score' => 0
                ];
            }

            $result = null;
            $results = $bet->getMatch()->getResults();

            foreach ($results as $tmp) {
                if ($tmp->getType()->getId() === 'end') {
                    $result = $tmp;
                }
            }

            $bet->setState('pending');

            if (!empty($result)) {
                $bet->setScore(0);
                $bet->setState('lost');

                $betGoalsTeamHome = $bet->getGoalsTeamHome();
                $betGoalsTeamAway = $bet->getGoalsTeamAway();
                $resultGoalsTeamHome = $result->getGoalsTeamHome();
                $resultGoalsTeamAway = $result->getGoalsTeamAway();

                if (($betGoalsTeamHome === $betGoalsTeamAway && $resultGoalsTeamHome === $resultGoalsTeamAway)
                    ||
                    ($betGoalsTeamHome > $betGoalsTeamAway && $resultGoalsTeamHome > $resultGoalsTeamAway)
                    ||
                    ($betGoalsTeamHome < $betGoalsTeamAway && $resultGoalsTeamHome < $resultGoalsTeamAway)
                ) {
                    $bet->setState('part');
                    $bet->setScore($pointsPart);
                }

                if ($betGoalsTeamHome === $betGoalsTeamAway && $resultGoalsTeamHome === $resultGoalsTeamAway) {
                    $bet->setState('won');
                    $bet->setScore($pointsFull);
                }

                $this->em->persist($bet);
            }
            $scores[$bet->getUser()->getId()]['score'] += $bet->getScore();
        }

        $this->em->flush();

        foreach ($scores as $score) {
            $userGroup = $this->em
                ->getRepository('WebtippBundle:UserGroupMapping')
                ->findOneBy([
                    'user' => $score['user'],
                    'group' => $group,
                ]);

            $userGroup->setScore($score['score']);
            $this->em->persist($userGroup);
        }

        $this->em->flush();

        $query = $this->em
            ->getRepository('WebtippBundle:UserGroupMapping')
            ->createQueryBuilder('ug')
            ->where('ug.group = :group')
            ->setParameters([
                'group' => $group
            ])
            ->orderBy('ug.score', 'DESC')
            ->getQuery();

        $userGroups = $query->getResult();

        $rank = 1;
        foreach ($userGroups as $userGroup) {
            $userGroup->setRank($rank);
            $rank++;

            $this->em->persist($userGroup);
        }

        $this->em->flush();
    }

    /**
     * @return array
     */
    public function syncLeagues()
    {
        $leagues = [];

        foreach ($this::LEAGUES as $leagueKey => $name) {
            $league = $this->em
                ->getRepository('WebtippBundle:League')
                ->findOneBy(['idApi' => $leagueKey]);

            if (empty($league)) {
                $league = new League();
            }

            $league->setIdApi($leagueKey);
            $league->setName($name);

            $this->em->persist($league);
            $this->em->flush();

            $leagues[] = $league;
        }


        return $leagues;
    }

    /**
     * @param $league
     * @return array
     */
    public function syncSeasons($league)
    {
        $seasons = [];

        foreach ($this::SEASONS as $year) {
            $season = $this->em
                ->getRepository('WebtippBundle:Season')
                ->findOneBy(['league' => $league, 'year' => $year]);

            if (empty($season)) {
                $season = new Season();
            }

            $season->setYear($year);
            $season->setLeague($league);

            $this->em->persist($season);
            $this->em->flush();

            $seasons[] = $season;
        }

        return $seasons;
    }

    /**
     * @param Season $season
     * @return array
     */
    public function syncTeams(Season $season)
    {
        $teams = [];

        $oldTeamIds = [];
        foreach ($season->getTeams() as $oldTeam) {
            $oldTeamIds[$oldTeam->getId()] = true;
        }

        $updatedTeams = $this->generateTeams($season);

        foreach ($updatedTeams as $updatedTeam) {
            $team = $this->em
                ->getRepository('WebtippBundle:Team')
                ->findOneBy(['idApi' => $updatedTeam->getIdApi()]);

            if (!empty($team)) {
                $team->setName($updatedTeam->getName());
                $team->setShortName($updatedTeam->getShortName());
                $team->setTeamIconUrl($updatedTeam->getTeamIconUrl());
            } else {
                $team = $updatedTeam;
            }

            if (!isset($oldTeamIds[$team->getId()])) {
                $season->addTeam($team);
            }

            $this->em->persist($team);
            $this->em->persist($season);

            $teams[] = $team;
        }

        $this->em->flush();

        return $teams;
    }

    /**
     * @param Season $season
     * @return array
     */
    public function syncMatchdays(Season $season)
    {
        $matchdays = [];

        $updatedMatchdays = $this->generateMatchdays($season);
        foreach ($updatedMatchdays as $updatedMatchday) {
            $matchday = $this->em
                ->getRepository('WebtippBundle:Matchday')
                ->findOneBy(['idApi' => $updatedMatchday->getIdApi(), 'season' => $season]);

            if (!empty($matchday)) {
                $matchday->setName($updatedMatchday->getName());
                $matchday->setOrder($updatedMatchday->getOrder());
                $matchday->setIdApi($updatedMatchday->getIdApi());

                $matchday->setDateStart($updatedMatchday->getDateStart());
                $matchday->setDateEnd($updatedMatchday->getDateEnd());

                $matchday->setDateUpdate($updatedMatchday->getDateUpdate());
            } else {
                $matchday = $updatedMatchday;
            }

            $this->em->persist($matchday);

            $matchdays[] = $matchday;
        }

        $this->em->flush();

        return $matchdays;
    }

    /**
     * @param Season $season
     */
    public function syncMatchdayDates(Season $season)
    {
        $matchdays = [];

        foreach ($season->getMatchdays() as $matchday) {
            $dateStart = null;
            $dateEnd = 0;
            foreach ($matchday->getMatches() as $match) {
                if ($dateStart === null || $dateStart > $match->getDateStart()) {
                    $dateStart = $match->getDateStart();
                }

                if ($dateEnd < $match->getDateEnd()) {
                    $dateEnd = $match->getDateEnd();
                }
            }

            $matchday->setDateStart($dateStart);
            $matchday->setDateEnd($dateEnd);

            $this->em->persist($matchday);
        }

        $this->em->flush();
    }

    /**
     * @param Season $season
     * @return array
     */
    public function syncMatches(Season $season)
    {
        $matches = [];

        $updatedMatches = $this->generateAllMatches($season);

        /**
         * @todo
         */
        foreach ($updatedMatches as $updatedMatch) {
            $match = $this->em
                ->getRepository('WebtippBundle:Match')
                ->findOneBy(['idApi' => $updatedMatch->getIdApi()]);

            if (!empty($match)) {
                $match->setIdApi($updatedMatch->getIdApi());
                $match->setState($updatedMatch->getState());

                $match->setTeamHome($updatedMatch->getTeamHome());
                $match->setTeamAway($updatedMatch->getTeamAway());
                $match->setOrder($updatedMatch->getOrder());
                $match->setDateStart($updatedMatch->getDateStart());
                $match->setDateEnd($updatedMatch->getDateEnd());
                $match->setDateUpdate($updatedMatch->getDateUpdate());

                foreach ($updatedMatch->getResults() as $updatedResult) {
                    $result = $this->em
                        ->getRepository('WebtippBundle:Result')
                        ->findOneBy(['idApi' => $updatedResult->getIdApi()]);

                    if (!empty($result)) {
                        $result->setMatch($match);
                    } else {
                        $result = $updatedResult;
                    }

                    $result->setMatch($match);
                    $this->em->persist($result);
                }

                $match->setMatchday($updatedMatch->getMatchday());
            } else {
                $match = $updatedMatch;

                foreach ($match->getResults() as $result) {
                    $result->setMatch($match);
                    $this->em->persist($result);
                }
            }

            $this->em->persist($match);

            $matches[] = $match;
        }

        $this->em->flush();

        return $matches;
    }

    /**
     * @param Season $season
     *
     * @return array
     */
    public function generateMatchdays(Season $season)
    {
        $data = $this->api->getMatchdaysFromApi($season->getLeague()->getIdApi(), $season->getYear());

        $matchdays = [];
        foreach ($data as $entry) {
            $matchday = new Matchday;

            $matchday->setIdApi($entry['GroupID']);
            $matchday->setName($entry['GroupName']);
            $matchday->setOrder($entry['GroupOrderID']);

            $matchday->setDateStart(0);
            $matchday->setDateEnd(0);
            $matchday->setDateUpdate(
                strtotime(
                    $this->api->getLastChangeDateFromApi(
                        $season->getLeague()->getIdApi(),
                        $season->getYear(),
                        $entry['GroupOrderID']
                    )
                )
            );

            $matchday->setSeason($season);

            $matchdays[] = $matchday;
        }

        return $matchdays;
    }

    /**
     * @param Season $season
     * @param Matchday $matchday
     *
     * @return array
     */
    public function generateMatchdayMatches(Season $season, Matchday $matchday)
    {
        $data = $this->api->getMatchdayMatchesFromApi(
            $season->getLeague()->getIdApi(),
            $matchday->getOrder(),
            $season->getYear()
        );

        $typeIds = $this::RESULT_TYPES;
        $query = $this->em
            ->getRepository('WebtippBundle:ResultType')
            ->createQueryBuilder('rt')
            ->where('rt.id IN (:typeIds)')
            ->setParameters([
                'typeIds' => $typeIds
            ])
            ->getQuery();

        $resultTypes = $query->getResult();

        $types = [];
        foreach ($typeIds as $key => $typeId) {
            foreach ($resultTypes as $resultType) {
                if ($resultType->getId() === $typeId) {
                    $types[$typeId] = $resultType;
                }
            }
        }

        $matches = [];

        foreach ($data as $key => $entry) {
            $matchday = $this->em
                ->getRepository('WebtippBundle:Matchday')
                ->findOneBy(['idApi' => $entry['Group']['GroupID']]);

            /**  @todo */
            $order = ($key % 9) + 1;
            $match = new Match();

            $match->setIdApi($entry['MatchID']);
            $match->setState('pending');


            $teamHome = $this->em
                ->getRepository('WebtippBundle:Team')
                ->findOneBy(['idApi' => $entry['Team1']['TeamId']]);

            $match->setTeamHome($teamHome);

            $teamAway = $this->em
                ->getRepository('WebtippBundle:Team')
                ->findOneBy(['idApi' => $entry['Team2']['TeamId']]);

            $match->setTeamAway($teamAway);
            $match->setOrder($order);
            $match->setDateStart(strtotime($entry['MatchDateTime']));
            $match->setDateEnd(strtotime($entry['MatchDateTime']) + 6600);
            $match->setDateUpdate(strtotime($entry['LastUpdateDateTime']));
            $match->setMatchday($matchday);

            foreach ($entry['MatchResults'] as $matchResult) {
                $result = new Result();

                switch ($matchResult['ResultTypeID']) {
                    case 1:
                        if (!isset($types['half'])) {
                            $type = new ResultType();


                            $type->setId('half');
                            $type->setName($matchResult['ResultName']);
                            $type->setDescription($matchResult['ResultDescription']);

                            $this->em->persist($type);
                            $this->em->flush();

                            $types['half'] = $type;
                        }

                        if ($match->getState() !== 'finished') {
                            $match->setState('active');
                        }

                        $result->setType($types['half']);

                        break;
                    case 2:
                        $match->setState('finished');

                        if (!isset($types['end'])) {
                            $type = new ResultType();

                            $type->setId('end');
                            $type->setName($matchResult['ResultName']);
                            $type->setDescription($matchResult['ResultDescription']);

                            $this->em->persist($type);
                            $this->em->flush();

                            $types['end'] = $type;
                        }

                        $result->setType($types['end']);

                        $match->setState('finished');

                        break;
                }


                $result->setIdApi($matchResult['ResultID']);
                $result->setOrder($matchResult['ResultOrderID']);
                $result->setGoalsTeamHome($matchResult['PointsTeam1']);
                $result->setGoalsTeamAway($matchResult['PointsTeam2']);

                $match->addResult($result);
            }


            $matches[] = $match;
        }

        return $matches;
    }

    /**
     * @param Season $season
     *
     * @return array
     */
    public function generateAllMatches(Season $season)
    {
        $data = $this->api->getAllMatchesFromApi($season->getLeague()->getIdApi(), $season->getYear());

        $typeIds = $this::RESULT_TYPES;
        $query = $this->em
            ->getRepository('WebtippBundle:ResultType')
            ->createQueryBuilder('rt')
            ->where('rt.id IN (:typeIds)')
            ->setParameters([
                'typeIds' => $typeIds
            ])
            ->getQuery();

        $resultTypes = $query->getResult();

        $types = [];
        foreach ($typeIds as $key => $typeId) {
            foreach ($resultTypes as $resultType) {
                if ($resultType->getId() === $typeId) {
                    $types[$typeId] = $resultType;
                }
            }
        }

        foreach ($data as $key => $entry) {
            $matchday = $this->em
                ->getRepository('WebtippBundle:Matchday')
                ->findOneBy(['idApi' => $entry['Group']['GroupID']]);

            /**  @todo */
            $order = ($key % 9) + 1;
            $match = new Match();

            $match->setIdApi($entry['MatchID']);
            $match->setState('pending');


            $teamHome = $this->em
                ->getRepository('WebtippBundle:Team')
                ->findOneBy(['idApi' => $entry['Team1']['TeamId']]);

            $match->setTeamHome($teamHome);

            $teamAway = $this->em
                ->getRepository('WebtippBundle:Team')
                ->findOneBy(['idApi' => $entry['Team2']['TeamId']]);

            $match->setTeamAway($teamAway);
            $match->setOrder($order);
            $match->setDateStart(strtotime($entry['MatchDateTime']));
            $match->setDateEnd(strtotime($entry['MatchDateTime']) + 6600);
            $match->setDateUpdate(strtotime($entry['LastUpdateDateTime']));
            $match->setMatchday($matchday);

            foreach ($entry['MatchResults'] as $matchResult) {
                $result = new Result();

                switch ($matchResult['ResultTypeID']) {
                    case 1:
                        if (!isset($types['half'])) {
                            $type = new ResultType();


                            $type->setId('half');
                            $type->setName($matchResult['ResultName']);
                            $type->setDescription($matchResult['ResultDescription']);

                            $this->em->persist($type);
                            $this->em->flush();

                            $types['half'] = $type;
                        }

                        if ($match->getState() !== 'finished') {
                            $match->setState('active');
                        }

                        $result->setType($types['half']);

                        break;
                    case 2:
                        $match->setState('finished');

                        if (!isset($types['end'])) {
                            $type = new ResultType();

                            $type->setId('end');
                            $type->setName($matchResult['ResultName']);
                            $type->setDescription($matchResult['ResultDescription']);

                            $this->em->persist($type);
                            $this->em->flush();

                            $types['end'] = $type;
                        }

                        $result->setType($types['end']);

                        $match->setState('finished');

                        break;
                }


                $result->setIdApi($matchResult['ResultID']);
                $result->setOrder($matchResult['ResultOrderID']);
                $result->setGoalsTeamHome($matchResult['PointsTeam1']);
                $result->setGoalsTeamAway($matchResult['PointsTeam2']);

                $match->addResult($result);
            }


            $matches[] = $match;
        }

        return $matches;
    }

    /**
     * @param Season $season
     *
     * @return array
     */
    public function generateTeams(Season $season)
    {
        $data = $this->api->getTeamsFromApi($season->getLeague()->getIdApi(), $season->getYear());

        $teams = [];
        foreach ($data as $entry) {
            $team = new Team;

            $team->setIdApi($entry['TeamId']);
            $team->setName($entry['TeamName']);

            if (!empty($entry['ShortName'])) {
                $team->setShortName($entry['ShortName']);
            }
            if (!empty($entry['TeamIconUrl'])) {
                $team->setTeamIconUrl($entry['TeamIconUrl']);
            }

            $team->addSeason($season);

            $teams[] = $team;
        }

        return $teams;
    }
}
