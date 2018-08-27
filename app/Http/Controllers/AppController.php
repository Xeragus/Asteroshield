<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Client;
use DateTime;
use DateInterval;

global $neos;
define("api_key", "1XMXCWStyLOtOWaGPIYs4zlzSvl8QE4pmfA9p7W9");
global $data;
$data = array();

class AppController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDashboard(Request $request)
    {   
        $this->getNEOdata();
        global $data;
        return view('welcome', ['data' => $data]);
    }

    /**
     * Returns an array of near-Earth objects
     */
    public function callAPI() {
        $client = new Client();
        $start_date = date("Y-m-d");
        $end_date = $this->calculateEndDate($start_date);
        $api_endpoint = 'https://api.nasa.gov/neo/rest/v1/feed?start_date=' . $start_date . '&end_date=' . $end_date . '&api_key=' . api_key;
        $response = $client->request('GET', $api_endpoint);
        return json_decode($response->getBody(), true);
    }

    /**
     * Uses the NASA NEO feed which works with maximum of 7 days intervals
     */
    public function getNEOdata() {
        global $neos;
        global $data;
        $neos_array = $this->callAPI();
        $neos = $neos_array['near_earth_objects'];
        $data['neo_total_count'] = $neos_array['element_count'];
        $data['neo_hazardous_count'] = $this->getHazardous($neos);
        $data['neo_biggest_asteroids'] = array_slice($this->sortBySize(1), 0, 5, true);
        $data['neo_smallest_asteroids'] = array_slice($this->sortBySize(0), 0, 5, true);
        $data['neo_fastest_asteroids'] = array_slice($this->sortByVelocity(1), 0, 5, true);
        $data['neo_slowest_asteroids'] = array_slice($this->sortByVelocity(0), 0, 5, true);
        $data['neo_asteroids_by_diameter'] = $this->getAsteroidsByDiameter(0.2);
        $data['neo_asteroids_by_velocity'] = $this->getAsteroidsByVelocity(19.48);
    }

    /**
     * Accepts the dynamicaly calculated start date
     * Returns the date after 7 days from the start date
     */
    public function calculateEndDate($start_date) {
        $end_date = new DateTime($start_date);
        $end_date->add(new DateInterval('P7D'));
        return $end_date->format("Y-m-d");
    }

    /**
     * Accepts array of Near-Earth Objects as parameter
     * Returns the number of hazardous asteroids from the accepted parameter array
     */
    public function getHazardous() {
        global $neos;
        $count = 0;
        foreach($neos as $neo_group) {
            foreach($neo_group as $key => $neo) {
                if ($neo['is_potentially_hazardous_asteroid']) {
                    $count++;
                } 
            }
        }
        return $count;
    }

     /**
     * Returns sorted array of asteroids by size - in descending order (if $desc is set)
     * The size of the asteroid depends on its absolute magnitude
     */
    public function sortBySize($desc) {
        global $neos;
        $sortedBySize = $this->getAsteroids($neos);
        uasort($sortedBySize, function($a, $b) use($desc) {
            if ($a['absolute_magnitude_h'] == $b['absolute_magnitude_h']) 
                return 0;
            if($desc)
                return ($a['absolute_magnitude_h'] > $b['absolute_magnitude_h']) ? -1 : 1;        
            return ($a['absolute_magnitude_h'] > $b['absolute_magnitude_h']) ? 1 : -1;    
        });
        return $sortedBySize;
    }

    /**
     * Returns sorted array of asteroids by velocity - in descending order (if $desc is set)
     */
    public function sortByVelocity($desc) {
        global $neos;
        $sortedByVelocity = $this->getAsteroids($neos);
        uasort($sortedByVelocity, function($a, $b) use($desc) {
            $a_velocity = $a['close_approach_data'][0]['relative_velocity']['kilometers_per_second'];
            $b_velocity = $b['close_approach_data'][0]['relative_velocity']['kilometers_per_second'];
            if ($a_velocity == $b_velocity) 
                return 0;
            if($desc)
                return ($a_velocity > $b_velocity) ? -1 : 1;        
            return ($a_velocity > $b_velocity) ? 1 : -1;    
        });
        return $sortedByVelocity;
    }

    /**
     * Returns a list of asteroids that have a diameter bigger or equal to $diameter km
     */
    public function getAsteroidsByDiameter($diameter) {
        global $neos;
        $filtered_asteroids = array_filter($this->getAsteroids($neos), function($value) use ($diameter) {
            $average_diameter = ($value['estimated_diameter']['kilometers']['estimated_diameter_min'] + $value['estimated_diameter']['kilometers']['estimated_diameter_max']) / 2;
            return $average_diameter > $diameter;
        });        
        return $filtered_asteroids;
    }

    /**
     * Returns a list of asteorids that have a velocity of more than $velocity km/s
     */
    public function getAsteroidsByVelocity($velocity) {
        global $neos;
        $filtered_asteroids = array_filter($this->getAsteroids($neos), function($value) use ($velocity) {
            return $value['close_approach_data'][0]['relative_velocity']['kilometers_per_second'] > $velocity;
        });
        return $filtered_asteroids;
    }

    /**
     * Handles the AJAX call for refreshing the list of X biggest asteroids
     */
    public function postGetXBiggest(Request $request) {
        global $data;
        $this->getNEOdata();
        $temp_array = array_slice($this->sortBySize(1), 0, $request['x'], true);
        if(count($temp_array) >= $request['x'])
            $data['neo_biggest_asteroids'] = $temp_array;
        return view('welcome', ['data' => $data]);
    }

    /**
     * Handles the AJAX call for refreshing the list of X smallest asteroids
     */
    public function postGetXSmallest(Request $request) {
        global $data;
        $this->getNEOdata();
        $temp_array = array_slice($this->sortBySize(0), 0, $request['x'], true);
        if(count($temp_array) >= $request['x']) 
            $data['neo_smallest_asteroids'] = $temp_array;
        return view('welcome', ['data' => $data]);
    }

    /**
     * Handles the AJAX call for refreshing the list of X fastest asteroids
     */
    public function postGetXFastest(Request $request) {
        global $data;
        $this->getNEOdata();
        $temp_array = array_slice($this->sortByVelocity(1), 0, $request['x'], true);
        if(count($temp_array) >= $request['x']) 
            $data['neo_fastest_asteroids'] = $temp_array;
        return view('welcome', ['data' => $data]);
    }

    /**
     * Handles the AJAX call for refreshing the list of X slowest asteroids
     */
    public function postGetXSlowest(Request $request) {
        global $data;
        $this->getNEOdata();
        $temp_array = array_slice($this->sortByVelocity(0), 0, $request['x'], true);
        if(count($temp_array) >= $request['x']) 
            $data['neo_slowest_asteroids'] = $temp_array;
        return view('welcome', ['data' => $data]);
    }

    /**
     * Accepts the NEOs data
     * Returns an array with key: reference_id, value: neo_object_array
     */
    public function getAsteroids() {
        global $neos;
        $asteroids = array();
        foreach($neos as $neo_group) {
            foreach($neo_group as $key => $neo) {
                $asteroids[$neo['neo_reference_id']] = $neo;
            }
        }
        return $asteroids;
    }
}
