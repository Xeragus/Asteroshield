@extends('layouts.master')
@section('content')
<div class="app-wrapper">
    <div class="background-wrapper" id="bg_img">
        {{-- <img src="{{ $data['apod_bg_url'] }}" alt=""> --}}
    </div>
    {{-- <div class="content-wrapper p-5 text-white">
        <h4>Total number of near-Earth asteroids: {{ $data["neo_total_count"] }} </h4>
        <h4>Number of potentially hazardous asteroids: {{ $data["neo_hazardous_count"]  }} </h4>
    </div> --}}
    <div class="p-5">
        <p>Total number of near-Earth asteroids: {{ $data["neo_total_count"] }} </p>
        <p>Number of potentially hazardous asteroids: {{ $data["neo_hazardous_count"]  }} </p>
        <p>The asteroid that will hit us first: </p>
        <p>List of the 5 biggest asteroids: </p>
        <ul>
            <li>23dsd</li>
            <li>443dsd</li>
        </ul>
        <p>List of the 5 smallest asteroids: </p>
        <ul>
            <li>23dsd</li>
            <li>443dsd</li>
        </ul>
        <p>List of the 5 fastest asteroids: </p>
        <ul>
            <li>23dsd</li>
            <li>443dsd</li>
        </ul>
        <p>List of the 5 slowest asteroids: </p>
        <ul>
            <li>23dsd</li>
            <li>443dsd</li>
        </ul>
        <p>List of asteroids that have a diameter bigger or equal to 0.2 in kilometers.</p>
        <ul>
            <li>23dsd</li>
            <li>443dsd</li>
        </ul>
        <p>list of asteroids that have velocity of more than 19.48 kilometers per second</p>
        <ul>
            <li>23dsd</li>
            <li>443dsd</li>
        </ul>
    </div>

</div>
@endsection