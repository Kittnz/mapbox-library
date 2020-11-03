<?php

class Mapbox_api {

    private $api_key = 'YOUR_API_KEY';
    private $forward_geocoding_url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/@@SEARCH@@.json?limit=5&access_token=@@API_KEY@@';
    private $retrieve_direction_url = 'https://api.mapbox.com/directions-matrix/v1/mapbox/driving/@@START_POINT;@@END_POINT@@?sources=1&annotations=distance,duration&access_token=@@API_KEY@@';
    private $retrieve_direction_walking_url = 'https://api.mapbox.com/directions-matrix/v1/mapbox/walking/@@START_POINT;@@END_POINT@@?sources=1&annotations=distance,duration&access_token=@@API_KEY@@';
    private $start_point = '25.197335,55.274346';

    //This function return search place lat,long & etc..
    //For an example if you search 'New York' it's return Similar New York results. You just need to pass seach value.
    public function forward_geocoding($search) {
        $search = str_replace(' ', '%20', $search);
        $url = $this->forward_geocoding_url;
        $url = str_replace('@@API_KEY@@', $this->api_key, $url);
        $url = str_replace('@@SEARCH@@', $search, $url);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $output = curl_exec($ch);
        return $output;
    }

    //This function return walking distance , walking duration , driving disatnce , driving durations & etc..
    //You need to pass starting point lat&long /  ending point lat&long. the corinates should be '25.197335,55.274346' like this format..
    public function retrieve_directions($start_gps_cordinates, $end_gps_cordinates) {
        $url = $this->retrieve_direction_url;
        $url = str_replace('@@API_KEY@@', $this->api_key, $url);
        $url = str_replace('@@END_POINT@@', $start_gps_cordinates, $url);
        $url = str_replace('@@START_POINT', $end_gps_cordinates, $url);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $output[] = json_decode(curl_exec($ch), true);
        $output[] = $this->retrieve_direction_walking($start_gps_cordinates, $end_gps_cordinates);
        return json_encode($output);
    }

    //This function return only walking distance , walking duration & etc..
    //You need to pass starting point lat&long /  ending point lat&long. the corinates should be '25.197335,55.274346' like this format..
    public function retrieve_direction_walking($start_gps_cordinates, $end_gps_cordinates) {
        $url = $this->retrieve_direction_walking_url;
        $url = str_replace('@@API_KEY@@', $this->api_key, $url);
        $url = str_replace('@@END_POINT@@', $start_gps_cordinates, $url);
        $url = str_replace('@@START_POINT', $end_gps_cordinates, $url);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $output = json_decode(curl_exec($ch), true);
        return $output;
    }

}
