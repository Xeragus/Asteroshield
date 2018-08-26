<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DateTime;
use DateInterval;

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
        $api_key = "1XMXCWStyLOtOWaGPIYs4zlzSvl8QE4pmfA9p7W9";
        $client = new Client();
        $data = array();
        $this->getAPODdata($api_key, $client, $data);
        $this->getNEOdata($api_key, $client, $data);
        return view('welcome', ['data' => $data]);
    }

    /**
     * Accepts the api_key, the Guzzle HTTP client and the data array
     * Uses the NASA APOD API to get the Astronomy Picture of the Day
     */
    public function getAPODdata($api_key, $client, &$data) {
        $response = $client->request('GET', 'https://api.nasa.gov/planetary/apod?api_key=' . $api_key);
        $apod_body_array = json_decode($response->getBody(), true);
        $data['apod_bg_url'] = $apod_body_array['hdurl'];
    }

    /**
     * Uses the NASA NEO feed which works with maximum of 7 days intervals
     */
    public function getNEOdata($api_key, $client, &$data) {
        $start_date = date("Y-m-d");
        $end_date = $this->calculateEndDate($start_date);
        $api_endpoint = 'https://api.nasa.gov/neo/rest/v1/feed?start_date=' . $start_date . '&end_date=' . $end_date . '&api_key=' . $api_key;
        $response = $client->request('GET', $api_endpoint);
        $neos_array = json_decode($response->getBody(), true);
        $neos = $neos_array['near_earth_objects'];
        $data['neo_total_count'] = $neos_array['element_count'];
        $data['neo_hazardous_count'] = $this->getHazardous($neos);
        $data['neo_biggest_asteroids'] = array_slice($this->sortBySize($neos, 1), 0, 5, true);
        $data['neo_smallest_asteroids'] = array_slice($this->sortBySize($neos, 0), 0, 5, true);
        // $data['neo_fastest_asteroids'] = array_slice($this->sortByVelocity($neos, 1), 0, 5, true);
        // $data['neo_fastest_asteroids'] = array_slice($this->sortByVelocity($neos, 0), -5, 5, true);
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
    public function getHazardous($neos) {
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
     * The average of the min and max diameter determines the size of an asteroid
     */
    public function sortBySize($neos, $desc) {
        $biggestX_obj = $this->getAsteroids($neos);
        uasort($biggestX_obj, function($a, $b) use($desc) {
            $a_diameter_average = ($a['estimated_diameter']['kilometers']['estimated_diameter_min'] + $a['estimated_diameter']['kilometers']['estimated_diameter_max']) / 2;
            $b_diameter_average = ($b['estimated_diameter']['kilometers']['estimated_diameter_min'] + $b['estimated_diameter']['kilometers']['estimated_diameter_max']) / 2;
            if ($a_diameter_average == $b_diameter_average) 
                return 0;
            if($desc)
                return ($a_diameter_average > $b_diameter_average) ? -1 : 1;        
            return ($a_diameter_average > $b_diameter_average) ? 1 : -1;    
        });
        return $biggestX_obj;
    }
    
    /**
     * Accepts the NEOs data
     * Returns an array with key: reference_id, value: neo_object_array
     */
    public function getAsteroids($neos) {
        $asteroids = array();
        foreach($neos as $neo_group) {
            foreach($neo_group as $key => $neo) {
                $asteroids[$neo['neo_reference_id']] = $neo;
            }
        }
        return $asteroids;
    }
}
