<?php
/**
 * Author: Daniel Richardt <d.richardt@dmpr-dev.de>
 * Date: 26.04.2017
 * Time: 21:41
 */

namespace WebtippBundle\Services\OpenLiga;

use WebtippBundle\Services\ServiceAbstract;

/**
 * Class ApiService
 * @package WebtippBundle\Services\OpenLiga
 */
class ApiService extends ServiceAbstract
{
    /**
     * @param string $league
     * @param int|null $year
     * @param int|null $matchday
     *
     * @return false|int
     */
    public function getLastChangeDateFromApi($league, $year, $matchday)
    {
        $parameters = '';

        $parameters .= $league;

        if (isset($matchday)) {
            if (!isset($year)) {
                $year = 2016;
            }
            $parameters .= '/' . $year . '/' . $matchday;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.openligadb.de/api/getlastchangedate/' . $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['Message']) && $data['Message'] === 'An error has occurred.') {
            throw new \Exception("OpenLigaDB: An error has occurred.");
        }

        return $data;
    }

    /**
     * @param string $league
     * @param int|null $year
     *
     * @return array
     */
    public function getTeamsFromApi($league, $year = null)
    {
        $parameters = $league;

        if (!isset($year)) {
            $year = 2016;
        }
        $parameters .= '/' . $year;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.openligadb.de/api/getavailableteams/' . $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['Message']) && $data['Message'] === 'An error has occurred.') {
            throw new \Exception("OpenLigaDB: An error has occurred.");
        }

        return $data;
    }


    /**
     * @param string $league
     * @param int|null $year
     *
     * @return array
     */
    public function getMatchdaysFromApi($league, $year = null)
    {
        $parameters = $league;

        if (!isset($year)) {
            $year = 2016;
        }
        $parameters .= '/' . $year;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.openligadb.de/api/getavailablegroups/' . $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['Message']) && $data['Message'] === 'An error has occurred.') {
            throw new \Exception("OpenLigaDB: An error has occurred.");
        }

        return $data;
    }

    /**
     * @param string $league
     * @param int|null $year
     *
     * @return array
     */
    public function getAllMatchesFromApi($league, $year = null)
    {
        $parameters = $league;

        if (!isset($year)) {
            $year = 2016;
        }
        $parameters .= '/' . $year;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.openligadb.de/api/getmatchdata/' . $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['Message']) && $data['Message'] === 'An error has occurred.') {
            throw new \Exception("OpenLigaDB: An error has occurred.");
        }

        return $data;
    }


    /**
     * @param string $league
     *
     * @return array
     */
    public function getCurrentMatchdayMatchesFromApi($league)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.openligadb.de/api/getmatchdata/' . $league);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['Message']) && $data['Message'] === 'An error has occurred.') {
            throw new \Exception("OpenLigaDB: An error has occurred.");
        }

        return $data;
    }


    /**
     * @param string $league
     *
     * @return array
     */
    public function getCurrentMatchdayFromApi($league)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.openligadb.de/api/getcurrentgroup/' . $league);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['Message']) && $data['Message'] === 'An error has occurred.') {
            throw new \Exception("OpenLigaDB: An error has occurred.");
        }

        return $data;
    }

    /**
     * @param int $leagueId
     * @param int $teamId
     *
     * @return array
     */
    public function getNextTeamMatchFromApi($leagueId, $teamId)
    {
        $ch = curl_init();
        curl_setopt(
            $ch,
            CURLOPT_URL,
            'https://www.openligadb.de/api/getnextmatchbyleagueteam/' . $leagueId . '/' . $teamId
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['Message']) && $data['Message'] === 'An error has occurred.') {
            throw new \Exception("OpenLigaDB: An error has occurred.");
        }

        return $data;
    }

    /**
     * @param string $league
     * @param int|null $year
     * @param int|null $matchday
     *
     * @return array
     */
    public function getMatchdayMatchesFromApi($league, $matchday, $year = null)
    {
        $parameters = '';

        $parameters .= $league;

        if (isset($matchday)) {
            if (!isset($year)) {
                $year = 2016;
            }
            $parameters .= '/' . $year . '/' . $matchday;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.openligadb.de/api/getmatchdata/' . $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['Message']) && $data['Message'] === 'An error has occurred.') {
            throw new \Exception("OpenLigaDB: An error has occurred.");
        }

        return $data;
    }

    /**
     * @param int $matchId
     *
     * @return array
     */
    public function getOneMatchFromApi(int $matchId)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.openligadb.de/api/getmatchdata/' . (string)$matchId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['Message']) && $data['Message'] === 'An error has occurred.') {
            throw new \Exception("OpenLigaDB: An error has occurred.");
        }

        return $data;
    }
}
