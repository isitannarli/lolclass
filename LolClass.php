<?php

/**
 * League of Legends Class
 *
 * @author: Ahmet Işıtan Narlı
 * @web: http://www.oyuncuagi.com
 * @mail: ahmetisitannarli@gmail.com
 * @git: https://github.com/isitannarli
 * @create: 01/05/2015 18:35
 */

class LolClass {

    private $summoner_stat_url = '/v1.4/summoner/';
    private $champion_info = '/v1.2/champion';
    private $game_url = '/v1.3/game/by-summoner/';
    private $stats_url = '/v1.3/stats/by-summoner/';
    private $match_history = '/v2.2/matchhistory/';
    private $match_url = '/v2.2/match/';
    private $league_url = '/v2.5/league/';
    private $current_game_url = '/observer-mode/rest/consumer/getSpectatorGameInfo/';
    private $featured_games_url = '/observer-mode/rest/featured';
    private $team_url = '/v2.4/team/';
    private $api_key = 'a2b9b428-5f81-4d24-aa69-2b3df1eb7bc4';

    /**
     * @param $url
     * @param bool $args
     * @return mixed|string
     */
    private function get_content($url, $args = false) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        if($args) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        }
        $content = curl_exec($ch);
        $response = curl_getinfo( $ch );
        curl_close ( $ch );

        if ($response['http_code'] == 301 || $response['http_code'] == 302 || $response['http_code'] == 404) {
            return '';
        } else {
            return $content;
        }

    }

    /**
     * @param $region
     * @return string
     */
    public function baseurl($region) {
        return 'https://' . $region . '.api.pvp.net/api/lol/'.$region;
    }

    /**
     * @param $region
     * @return string
     */
    public function static_url($region) {
        return 'https://' . $region . '.api.pvp.net';
    }

    /**
     * @param $region
     * @return string
     */
    public function global_url($region) {
        return 'https://global.api.pvp.net/api/lol/static-data/' . $region . '/v1.2/';
    }

    /**
     * @param $region
     * @param string $location
     * @return $this
     */
    public function region($region, $location = 'tr_TR') {
        $this->region = $region;

        if($location == !null)
            $this->location = $location;

        return $this;
    }

    /**
     * @param $summoner_id
     * @return $this
     */
    public function id($summoner_id) {
        $this->summoner_id = $summoner_id;
        return $this;
    }

    /**
     * @param $summoner_name
     * @return $this
     */
    public function name($summoner_name) {
        $this->summoner_name = $summoner_name;
        return $this;
    }

    /**
     * @return string
     */
    public function avatar() {
        return 'http://avatar.leagueoflegends.com/'.$this->region.'/'.$this->summoner_name.'.png';
    }

    /**
     * @return string
     */
    public function summoner_info() {
        if(isset($this->summoner_name)) {
            $api_url = $this->baseurl($this->region);
            return $this->get_content($api_url . $this->summoner_stat_url . 'by-name/' . $this->summoner_name . '?api_key=' . $this->api_key);
        } else {
            $api_url = $this->baseurl($this->region);
            return $this->get_content($api_url . $this->summoner_stat_url . $this->summoner_id . '?api_key=' . $this->api_key);
        }
    }

    /**
     * @return string
     */
    public function summoner_masteries() {
        $api_url = $this->baseurl($this->region);
        return $this->get_content($api_url . $this->summoner_stat_url . $this->summoner_id . '/masteries/' . '?api_key=' . $this->api_key);
    }

    /**
     * @param $summoner_id
     * @param $region
     * @return string
     */
    public function summoner_runes($summoner_id, $region) {
        $api_url = $this->baseurl($this->region);
        return $this->get_content($api_url . $this->summoner_stat_url . $this->summoner_id . '/runes/' . '?api_key=' . $this->api_key);
    }

    /**
     * @return string
     */
    public function team_info() {
        $api_url = $this->baseurl($this->region);
        return $this->get_content($api_url . $this->team_url . 'by-summoner/' . $this->summoner_id . '?api_key=' . $this->api_key);
    }

    /**
     * @param $team_id
     * @return string
     */
    public function team_member_info($team_id) {
        $api_url = $this->baseurl($this->region);
        return $this->get_content($api_url . $this->team_url . $team_id . '?api_key=' . $this->api_key);
    }

    /**
     * @param string $season
     * @return string
     */
    public function stats_ranked($season = '5') {
        if($season == '5') {
            $season = 'SEASON2015';
        } elseif($season == '4') {
            $season = 'SEASON2014';
        } elseif($season == '3') {
            $season = '3';
        }

        $api_url = $this->baseurl($this->region);
        return $this->get_content($api_url . $this->stats_url . $this->summoner_id . '/ranked?season=' . $season . '&api_key=' . $this->api_key);
    }

    /**
     * @param string $season
     * @return string
     */
    public function stats_summary($season = '5') {
        if($season == '5') {
            $season = 'SEASON2015';
        } elseif($season == '4') {
            $season = 'SEASON2014';
        } elseif($season == '3') {
            $season = '3';
        }

        $api_url = $this->baseurl($this->region);
        return $this->get_content($api_url . $this->stats_url . $this->summoner_id . '/summary?season=' . $season . '&api_key=' . $this->api_key);
    }

    /**
     * @param null $game_type
     * @return string
     */
    public function matchhistory($game_type = null) {
        $api_url = $this->baseurl($this->region);
        if($game_type == null) {
            return $this->get_content($api_url . $this->match_history . $this->summoner_id . '?api_key=' . $this->api_key);
        } else {

            if($game_type == 'solo5') {
                $game_type == 'RANKED_SOLO_5x5';
            } elseif($game_type == 'solo3') {
                $game_type == 'RANKED_SOLO_3x3';
            } elseif($game_type == 'team5') {
                $game_type == 'RANKED_TEAM_5x5';
            }

            return $this->get_content($api_url . $this->match_history . $this->summoner_id . '?rankedQueues=' . $game_type . '&api_key=' . $this->api_key);
        }
    }

    /**
     * @param $match_id
     * @return string
     */
    public function match_info($match_id) {
        $api_url = $this->baseurl($this->region);
        return $this->get_content($api_url . $this->match_url . $match_id . '?api_key=' . $this->api_key);
    }

    /**
     * @param string $platform
     * @return string
     */
    public function current_game($platform = 'TR1') {
        $api_url = $this->static_url($this->region);
        return $this->get_content($api_url . $this->current_game_url . $platform . '/' . $this->summoner_id . '?api_key=' . $this->api_key);
    }

    /**
     * @return string
     */
    public function featured_games() {
        $api_url = $this->static_url($this->region);
        return $this->get_content($api_url . $this->featured_games_url . '?api_key=' . $this->api_key);
    }

    /**
     * @return string
     */
    public function last_game() {
        $api_url = $this->baseurl($this->region);
        return $this->get_content($api_url . $this->game_url . $this->summoner_id . '/recent' . '?api_key=' . $this->api_key);
    }

    /**
     * @param bool $me
     * @return string
     */
    public function league_info($me = true) {
        $api_url = $this->baseurl($this->region);
        if($me == true)
            return $this->get_content($api_url . $this->league_url . 'by-summoner/' . $this->summoner_id . '/entry' . '?api_key=' . $this->api_key);
        else
            return $this->get_content($api_url . $this->league_url . 'by-summoner/' . $this->summoner_id . '?api_key=' . $this->api_key);

    }

    /**
     * @param bool $me
     * @return string
     */
    public function team_league($me = true) {
        $api_url = $this->baseurl($this->region);
        if($me == true)
            $json_url = file_get_contents($api_url . $this->league_url . 'by-team/' . $this->summoner_id . '/entry' . '?api_key=' . $this->api_key);
        else
            $json_url = file_get_contents($api_url . $this->league_url . 'by-team/' . $this->summoner_id . '?api_key=' . $this->api_key);

        return $json_url;
    }

    /**
     * @param $type
     * @return string
     */
    public function league_challenger($type) {

        if($type == 'solo5') {
            $type == 'RANKED_SOLO_5x5';
        } elseif($type == 'team3') {
            $type == 'RANKED_TEAM_3x3';
        } elseif($type == 'team5') {
            $type == 'RANKED_TEAM_5x5';
        }

        $api_url = $this->baseurl($this->region);
        $json_url = file_get_contents($api_url . $this->league_url . 'challenger/?type=' . $type . '&api_key=' . $this->api_key);
        return $json_url;
    }

    /**
     * @param $type
     * @return string
     */
    public function league_master($type) {

        if($type == 'solo5') {
            $type == 'RANKED_SOLO_5x5';
        } elseif($type == 'team3') {
            $type == 'RANKED_TEAM_3x3';
        } elseif($type == 'team5') {
            $type == 'RANKED_TEAM_5x5';
        }

        $api_url = $this->baseurl($this->region);
        $json_url = file_get_contents($api_url . $this->league_url . 'master/?type=' . $type . '&api_key=' . $this->api_key);
        return $json_url;
    }

    /**
     * @param null $id
     * @param null $data
     * @return string
     */
    public function champion_info($id = null, $data = null) {
        $api_url = $this->global_url($this->region);

        if($id == !null) {
            $json_url = file_get_contents($api_url . 'champion/' . $id . '?api_key=' . $this->api_key);
        } else {
            if($data == null)
                $json_url = file_get_contents($api_url . 'champion?api_key=' . $this->api_key);
            else
                $json_url = file_get_contents($api_url . 'champion?champData=' . $data . '&api_key=' . $this->api_key);
        }

        return $json_url;
    }

    /**
     * @param null $id
     * @param null $data
     * @return string
     */
    public function item_info($id = null, $data = null) {
        $api_url = $this->global_url($this->region);

        if($id == !null) {
            $json_url = file_get_contents($api_url . 'item/' . $id . '?api_key=' . $this->api_key);
        } else {
            if($data == null)
                $json_url = file_get_contents($api_url . 'item?api_key=' . $this->api_key);
            else
                $json_url = file_get_contents($api_url . 'item?itemListData=' . $data . '&api_key=' . $this->api_key);
        }

        return $json_url;
    }

    /**
     * @param null $id
     * @param null $data
     * @return string
     */
    public function mastery_info($id = null, $data = null) {
        $api_url = $this->global_url($this->region);

        if($id == !null) {
            $json_url = file_get_contents($api_url . 'mastery/' . $id . '?api_key=' . $this->api_key);
        } else {
            if($data == null)
                $json_url = file_get_contents($api_url . 'mastery?api_key=' . $this->api_key);
            else
                $json_url = file_get_contents($api_url . 'mastery?masteryListData=' . $data . '&api_key=' . $this->api_key);
        }

        return $json_url;
    }

    /**
     * @param null $id
     * @param null $data
     * @return string
     */
    public function rune_info($id = null, $data = null) {
        $api_url = $this->global_url($this->region);

        if($id == !null) {
            $json_url = file_get_contents($api_url . 'rune/' . $id . '?api_key=' . $this->api_key);
        } else {
            if($data == null)
                $json_url = file_get_contents($api_url . 'rune?api_key=' . $this->api_key);
            else
                $json_url = file_get_contents($api_url . 'rune?runeListData=' . $data . '&api_key=' . $this->api_key);
        }

        return $json_url;
    }

    /**
     * @param null $id
     * @param null $data
     * @return string
     */
    public function spell_info($id = null, $data = null) {
        $api_url = $this->global_url($this->region);

        if($id == !null) {
            $json_url = file_get_contents($api_url . 'summoner-spell/' . $id . '?api_key=' . $this->api_key);
        } else {
            if($data == null)
                $json_url = file_get_contents($api_url . 'summoner-spell?api_key=' . $this->api_key);
            else
                $json_url = file_get_contents($api_url . 'summoner-spell?runeListData=' . $data . '&api_key=' . $this->api_key);
        }

        return $json_url;
    }

    /**
     * @param null $all
     * @return string
     */
    public function language_info($all = null) {
        $api_url = $this->global_url($this->region);

        if($all == !null)
            $json_url = file_get_contents($api_url . 'languages' . '?api_key=' . $this->api_key);
        else
            $json_url = file_get_contents($api_url . 'language-strings' . '?api_key=' . $this->api_key);

        return $json_url;
    }

    /**
     * @param null $status
     * @return string
     */
    public function server_info($status = null) {
        if(isset($this->region)) {
            $api_url = $this->global_url($this->region);

            if($status == null)
                $json_url = file_get_contents('http://status.leagueoflegends.com/shards/' . $this->region);
            else
                $json_url = file_get_contents($api_url . 'realm/' . '?api_key=' . $this->api_key);

        } else {
            $json_url = file_get_contents('http://status.leagueoflegends.com/shards');
        }

        return $json_url;
    }

    /**
     * @return string
     */
    public function versions() {
        $api_url = $this->global_url($this->region);
        $json_url = file_get_contents($api_url . 'versions' . '?api_key=' . $this->api_key);
        return $json_url;
    }

    /**
     * @return string
     */
    public function freetoplay() {
        $api_url = $this->baseurl($this->region);
        $json_url = file_get_contents($api_url . $this->champion_info . '?freeToPlay=true' . '&api_key=' . $this->api_key);
        return $json_url;
    }
}