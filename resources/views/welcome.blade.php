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
        <div class="my-5">
            <h3>List of the 5 biggest asteroids: </h3>
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">Reference ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Absolute Magnitude</th>
                    <th scope="col">Minimum Diameter Estimation (km)</th>
                    <th scope="col">Maximum Diameter Estimation (km)</th>
                    <th scope="col">Hazardous?</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['neo_biggest_asteroids'] as $asteroid)
                    <tr>
                        <th scope="row">
                            <a href="{{ $asteroid['nasa_jpl_url'] }}">{{ $asteroid['neo_reference_id'] }}</a>
                        </th>
                        <td>
                            <a href="{{ $asteroid['nasa_jpl_url'] }}">{{ $asteroid['name'] }}</a>
                        </td>
                        <td>{{ $asteroid['absolute_magnitude_h'] }}</td>
                        <td>{{ $asteroid['estimated_diameter']['kilometers']['estimated_diameter_min'] }}</td>
                        <td>{{ $asteroid['estimated_diameter']['kilometers']['estimated_diameter_max'] }}</td>
                        @if ($asteroid['is_potentially_hazardous_asteroid'])
                            <td>Yes</td>
                        @else
                            <td>No</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
       <div class="my-5">
            <h3>List of the 5 smallest asteroids: </h3>
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">Reference ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Absolute Magnitude</th>
                    <th scope="col">Minimum Diameter Estimation (km)</th>
                    <th scope="col">Maximum Diameter Estimation (km)</th>
                    <th scope="col">Hazardous?</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['neo_smallest_asteroids'] as $asteroid)
                    <tr>
                        <th scope="row">
                            <a href="{{ $asteroid['nasa_jpl_url'] }}">{{ $asteroid['neo_reference_id'] }}</a>
                        </th>
                        <td>
                            <a href="{{ $asteroid['nasa_jpl_url'] }}">{{ $asteroid['name'] }}</a>
                        </td>
                        <td>{{ $asteroid['absolute_magnitude_h'] }}</td>
                        <td>{{ $asteroid['estimated_diameter']['kilometers']['estimated_diameter_min'] }}</td>
                        <td>{{ $asteroid['estimated_diameter']['kilometers']['estimated_diameter_max'] }}</td>
                        @if ($asteroid['is_potentially_hazardous_asteroid'])
                            <td>Yes</td>
                        @else
                            <td>No</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
       </div>
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