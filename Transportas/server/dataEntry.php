<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');

session_start();

require_once 'sql_functions.php';


$date = $_POST['date_'];
$route = $_POST['route'];
$departure = $_POST['departure'];
$speedoTripStart = $_POST['speedoTripStart'];
$arrivalToClient = $_POST['arrivalToClient'];
$unloading = $_POST['unloading'];
$departureFromClient = $_POST['departureFromClient'];
$arrival = $_POST['arrival'];
$speedoTripEnd = $_POST['speedoTripEnd'];
$driver = $_SESSION['username'];
$vehicle = getVehicleInfo($_POST['plateNumber']);

// consumptions and distance needs to be calculated
$distance = distance($speedoTripStart, $speedoTripEnd);
$consumptions = consumptions($departure, $arrivalToClient, $unloading, $departureFromClient, $arrival,
                            $vehicle['drivingFuelCon'], $vehicle['loadingFuelCon'], $vehicle['standingFuelCon']);


updateVehicle($_POST['plateNumber'], $speedoTripEnd, $driver);

createDataEntry($date, $route, $departure, $speedoTripStart,
                        $arrivalToClient, $unloading, $departureFromClient,
                        $arrival, $speedoTripEnd, $distance, $consumptions, $driver);




function consumptions($departure, $arrivalToClient, $unloading, $departureFromClient, $arrival, $vehCon1, $vehCon2, $vehCon3) {
    $time1 = (int)convertTime($departure);
    $time2 = (int)convertTime($arrivalToClient);
    $time3 = (int)$unloading;
    $time4 = (int)convertTime($departureFromClient);
    $time5 = (int)convertTime($arrival);

    return (int)((($time2 - $time1)*$vehCon1 + $time3*$vehCon2
                    + ($time4 - $time3 - $time2)*$vehCon3
                    + ($time5 - $time4)*$vehCon1)/60);

}

function convertTime($time) {
    $hours = substr($time, 0, 2);
    $minutes = substr($time, 3, 2);
    return $hours*60 + $minutes;
}

function distance($start, $end) {
    return (int)$end - (int)$start;
}
