@extends('layouts.master')
@section('content')
<div class="app-wrapper">
    <div class="background-wrapper" id="bg_img">
        {{-- <img src="{{ $data['apod_bg_url'] }}" alt=""> --}}
    </div>
    {{-- <div class="content-wrapper p-5 text-white">
        <p>Total number of near-Earth asteroids: {{ $data["neo_total_count"] }} </p>
        <p>Number of potentially hazardous asteroids: {{ $data["neo_hazardous_count"]  }} </p>
    </div> --}}
    <div class="p-5">
        <div class="my-3 border border-light header-wrapper">
            <div class="content-header-wrapper text-white text-center">
                @if ($data['neo_hazardous_count'])
                <div class="danger-wrapper bg-danger py-5">
                    {{-- () --}}
                    <h1>We are in danger!</h1>
                    <p class="mb-0">Number of potentially hazardous asteroids: {{ $data["neo_hazardous_count"]  }} </p>
                    <p class="mb-0">Total number of near-Earth asteroids: {{ $data["neo_total_count"] }} </p>
                </div>
                @else
                <div class="safe-wrapper bg-success py-5">
                    <h1>We are safe!</h1>
                    <p class="mb-0">There are no hazardous asteroids.</p>
                    <p class="mb-0">Total number of near-Earth asteroids: {{ $data["neo_total_count"] }} </p>
                </div>
                @endif
            </div>
        </div>
        
        <div class="my-5 border border-light p-4 data-wrapper">
            <form action="" method="post" class="py-3 d-flex align-items-center justify-content-between" id="changeXBiggest">
                @csrf
                <p class="d-inline-block mb-0">List the biggest
                <input type="text" style="width: 50px;" class="text-center" id="xbiggest" name="xbiggest" value="5">
                asteroids:
                </p>  
                <a href="#" class="btn btn-primary" id="xbiggestbtn"><i class="fas fa-sync-alt"></i></a>
                {{-- <button class="btn btn-primary" id="xbiggestbtn"><i class="fas fa-sync-alt"></i></button>           --}}
            </form>
            <table class="table table-striped table-sm" id="biggest-x-table">
                <thead>
                <tr>
                    <th scope="col">Reference ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Absolute Magnitude</th>
                    <th scope="col">Minimum / Maximum Diameter Estimation (km)</th>
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
                        <td>
                            {{ $asteroid['estimated_diameter']['kilometers']['estimated_diameter_min'] }}
                            /
                            {{ $asteroid['estimated_diameter']['kilometers']['estimated_diameter_max'] }}
                        </td>
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
       <div class="my-5 border border-light p-4 data-wrapper">
            <form action="" method="post" class="py-3 d-flex align-items-center justify-content-between" id="changeXSmallest">
                @csrf
                <p class="d-inline-block mb-0">List the smallest
                <input type="text" style="width: 50px;" class="text-center" id="xsmallest" name="xsmallest" value="5">
                asteroids:
                </p>  
                <a href="#" class="btn btn-primary" id="xsmallestbtn"><i class="fas fa-sync-alt"></i></a>
            </form>
            <table class="table table-striped table-sm" id="smallest-x-table">
                <thead>
                <tr>
                    <th scope="col">Reference ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Absolute Magnitude</th>
                    <th scope="col">Minimum / Maximum Diameter Estimation (km)</th>
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
                        <td>
                            {{ $asteroid['estimated_diameter']['kilometers']['estimated_diameter_min'] }}
                             / 
                            {{ $asteroid['estimated_diameter']['kilometers']['estimated_diameter_max'] }}
                        </td>
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
        <div class="my-5 border border-light p-4 data-wrapper">
            <form action="" method="post" class="py-3 d-flex align-items-center justify-content-between" id="changeXFastest">
                @csrf
                <p class="d-inline-block mb-0">List the fastest
                <input type="text" style="width: 50px;" class="text-center" id="xfastest" name="xfastest" value="5">
                asteroids:
                </p>  
                <a href="#" class="btn btn-primary" id="xfastestbtn"><i class="fas fa-sync-alt"></i></a>
            </form>
            <table class="table table-striped table-sm" id="fastest-x-table">
                <thead>
                <tr>
                    <th scope="col">Reference ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Close Approach Date</th>
                    <th scope="col">Relative Velocity (km/s)</th>
                    <th scope="col">Miss Distance (km)</th>
                    <th scope="col">Hazardous?</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['neo_fastest_asteroids'] as $asteroid)
                    <tr>
                        <th scope="row">
                            <a href="{{ $asteroid['nasa_jpl_url'] }}">{{ $asteroid['neo_reference_id'] }}</a>
                        </th>
                        <td>
                            <a href="{{ $asteroid['nasa_jpl_url'] }}">{{ $asteroid['name'] }}</a>
                        </td>
                        <td>{{ $asteroid['close_approach_data'][0]['close_approach_date'] }}</td>
                        <td>{{ $asteroid['close_approach_data'][0]['relative_velocity']['kilometers_per_second'] }}</td>
                        <td>{{ $asteroid['close_approach_data'][0]['miss_distance']['kilometers'] }}</td>
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
        <div class="my-5 border border-light p-4 data-wrapper">
            <form action="" method="post" class="py-3 d-flex align-items-center justify-content-between" id="changeXSlowest">
                @csrf
                <p class="d-inline-block mb-0">List the slowest
                <input type="text" style="width: 50px;" class="text-center" id="xslowest" name="xslowest" value="5">
                asteroids:
                </p>  
                <a href="#" class="btn btn-primary" id="xslowestbtn"><i class="fas fa-sync-alt"></i></a>
            </form>
            <table class="table table-striped table-sm" id="slowest-x-table">
                <thead>
                <tr>
                    <th scope="col">Reference ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Close Approach Date</th>
                    <th scope="col">Relative Velocity (km/s)</th>
                    <th scope="col">Miss Distance</th>
                    <th scope="col">Hazardous?</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['neo_slowest_asteroids'] as $asteroid)
                    <tr>
                        <th scope="row">
                            <a href="{{ $asteroid['nasa_jpl_url'] }}">{{ $asteroid['neo_reference_id'] }}</a>
                        </th>
                        <td>
                            <a href="{{ $asteroid['nasa_jpl_url'] }}">{{ $asteroid['name'] }}</a>
                        </td>
                        <td>{{ $asteroid['close_approach_data'][0]['close_approach_date'] }}</td>
                        <td>{{ $asteroid['close_approach_data'][0]['relative_velocity']['kilometers_per_second'] }}</td>
                        <td>{{ $asteroid['close_approach_data'][0]['miss_distance']['kilometers'] }}</td>
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
        <div class="my-5 border border-light p-4 data-wrapper">
            <p class="d-inline-block">List all asteroids with a diameter bigger or equal to 0.2 kilometers:</p>  
            @if ($data['neo_asteroids_by_diameter'])
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">Reference ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Average Diameter Estimation (km)</th>
                    <th scope="col">Minimum Diameter Estimation (km)</th>
                    <th scope="col">Maximum Diameter Estimation (km)</th>
                    <th scope="col">Hazardous?</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['neo_asteroids_by_diameter'] as $asteroid)
                    <tr>
                        <th scope="row">
                            <a href="{{ $asteroid['nasa_jpl_url'] }}">{{ $asteroid['neo_reference_id'] }}</a>
                        </th>
                        <td>
                            <a href="{{ $asteroid['nasa_jpl_url'] }}">{{ $asteroid['name'] }}</a>
                        </td>
                        <td>
                            {{ ($asteroid['estimated_diameter']['kilometers']['estimated_diameter_min'] + $asteroid['estimated_diameter']['kilometers']['estimated_diameter_max']) / 2 }}
                        </td>
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
            @else
            <div class="alert alert-danger" role="alert">
                <p class="mb-0">There are no asteroids with a diameter bigger or equal to {{ $data['diameter'] }} km.</p>
            </div>
            @endif
       </div>
       <div class="my-5 border border-light p-4 data-wrapper">
            <p class="d-inline-block">List all asteroids with velocity of more than 19.48 kilometers per second:</p>  
            @if ($data['neo_asteroids_by_velocity'])
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">Reference ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Relative Velocity (km/s)</th>
                    <th scope="col">Close Approach Date</th>
                    <th scope="col">Miss Distance</th>
                    <th scope="col">Hazardous?</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['neo_asteroids_by_velocity'] as $asteroid)
                    <tr>
                        <th scope="row">
                            <a href="{{ $asteroid['nasa_jpl_url'] }}">{{ $asteroid['neo_reference_id'] }}</a>
                        </th>
                        <td>
                            <a href="{{ $asteroid['nasa_jpl_url'] }}">{{ $asteroid['name'] }}</a>
                        </td>
                        <td>{{ $asteroid['close_approach_data'][0]['relative_velocity']['kilometers_per_second'] }}</td>
                        <td>{{ $asteroid['close_approach_data'][0]['close_approach_date'] }}</td>
                        <td>{{ $asteroid['close_approach_data'][0]['miss_distance']['kilometers'] }}</td>
                        @if ($asteroid['is_potentially_hazardous_asteroid'])
                            <td>Yes</td>
                        @else
                            <td>No</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            @else
            <div class="alert alert-danger" role="alert">
                <p class="mb-0">There are no asteroids with velocity of more than {{ Cookie::get('velocity') }} km/s.</p>
            </div>
            @endif
       </div>
    </div>

</div>
@endsection