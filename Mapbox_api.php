<?php

class Mapbox_api {

    private $api_key = 'pk.eyJ1IjoibWNpbmZhcyIsImEiOiJja2d0NDRxYncwaHdmMnpwOWs1b3I0anFwIn0.8ITBjp0GgegCmxDHDDuzkg';
    private $forward_geocoding_url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/@@SEARCH@@.json?limit=5&access_token=@@API_KEY@@';
    private $retrieve_direction_url = 'https://api.mapbox.com/directions-matrix/v1/mapbox/driving/@@START_POINT;@@END_POINT@@?sources=1&annotations=distance,duration&access_token=@@API_KEY@@';
    private $retrieve_direction_walking_url = 'https://api.mapbox.com/directions-matrix/v1/mapbox/walking/@@START_POINT;@@END_POINT@@?sources=1&annotations=distance,duration&access_token=@@API_KEY@@';
    private $start_point = '25.197335,55.274346';

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

    public function retrieve_directions($gps_cordinates, $current_gps_cordinates, $end_point_name) {
        $url = $this->retrieve_direction_url;
        $url = str_replace('@@API_KEY@@', $this->api_key, $url);
        $url = str_replace('@@END_POINT@@', $gps_cordinates, $url);
        $url = str_replace('@@START_POINT', $current_gps_cordinates, $url);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $output[] = json_decode(curl_exec($ch), true);
        $output[] = $this->retrieve_direction_walking($gps_cordinates, $current_gps_cordinates);
        $output[] = $end_point_name;
        return json_encode($output);
    }

    public function retrieve_direction_walking($gps_cordinates, $current_gps_cordinates) {
        $url = $this->retrieve_direction_walking_url;
        $url = str_replace('@@API_KEY@@', $this->api_key, $url);
        $url = str_replace('@@END_POINT@@', $gps_cordinates, $url);
        $url = str_replace('@@START_POINT', $current_gps_cordinates, $url);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $output = json_decode(curl_exec($ch), true);
        return $output;
    }

}
