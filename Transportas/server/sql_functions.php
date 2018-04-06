<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');



require_once 'config.php';


function getConnected() {
    global $link;

    if (!$link) {
        echo "ERROR: prisijungti prie " . DB_NAME . "duomenų bazės nepavyko. <br>";
        echo "ERROR: " . mysqli_connect_error() . "<br>";
    }
    return $link;
}




function getVehicleInfo($plateNumber) {
    $mySQL = "SELECT * FROM vehicles WHERE plateNumber='$plateNumber';";
    $result = mysqli_query(getConnected(), $mySQL);
    if (!$result) {
        echo "bad query for consumptions";
    } else {
        $results = mysqli_fetch_assoc($result);
        return $results;
    }
}
function getVehiclesInfo($id) {
    $mySQL = "SELECT * FROM vehicles WHERE id='$id';";
    $result = mysqli_query(getConnected(), $mySQL);
    if (!$result) {
        echo "bad query for consumptions";
    } else {
        $results = mysqli_fetch_assoc($result);
        return $results;
    }
}
function getUserInfo($username) {
    $mySQL = "SELECT userType FROM users WHERE username='$username';";
    $result = mysqli_query(getConnected(), $mySQL);
    if (!$result) {
        echo "bad query for user";
    } else {
        $results = mysqli_fetch_assoc($result);
        return $results;
    }
}
function getDrivers($id) {
    $mySQL = "SELECT username FROM users WHERE id='$id' AND userType='driver';";
    $result = mysqli_query(getConnected(), $mySQL);
    if (!$result) {
        echo "bad query for user";
    } else {
        $results = mysqli_fetch_assoc($result);
        return $results;
    }
}

function getData($driver, $from, $to) {
    $mySQL = "SELECT * FROM data_sheet WHERE driver='$driver' AND (date_ BETWEEN '$from' AND '$to');";
    $result = mysqli_query(getConnected(), $mySQL);
    if (!$result) {
        echo "bad query for data";
    } else {
        $results = mysqli_fetch_assoc($result);
        return $results;
    }
}
function getLatestData($id, $driver) {
    $mySQL = "SELECT * FROM data_sheet WHERE id='$id' AND driver='$driver';";
    $result = mysqli_query(getConnected(), $mySQL);
    if (!$result) {
        echo "bad query for data";
    } else {
        $results = mysqli_fetch_assoc($result);
        return $results;
    }
}


function createVehicle($make, $model, $plateNumber, $standingFuelCon,
                        $drivingFuelCon, $loadingFuelCon, $speedo) {
    $make = mysqli_real_escape_string(getConnected(), $make);
    $model = mysqli_real_escape_string(getConnected(), $model);
    $plateNumber = mysqli_real_escape_string(getConnected(), $plateNumber);
    $standingFuelCon = mysqli_real_escape_string(getConnected(), $standingFuelCon);
    $drivingFuelCon = mysqli_real_escape_string(getConnected(), $drivingFuelCon);
    $loadingFuelCon = mysqli_real_escape_string(getConnected(), $loadingFuelCon);
    $speedo = mysqli_real_escape_string(getConnected(), $speedo);




    $mySQL = "INSERT INTO vehicles VALUES ('', '$make', '$model', '$plateNumber', '$standingFuelCon',  '$drivingFuelCon', '$loadingFuelCon', '$speedo', '0000', 'New Car', CURRENT_TIMESTAMP);";
    $result = mysqli_query(getConnected(), $mySQL);
    if($result) {
        header("location: ../index.php");
    } else {
        echo "NO LUCK in ITEMS CREATION " . mysqli_error($link) . " <br>";
    }
}

function createDataEntry($date, $route, $departure, $speedoTripStart,
                        $arrivalToClient, $unloading, $departureFromClient,
                        $arrival, $speedoTripEnd, $distance, $consumptions, $driver) {
    $date = mysqli_real_escape_string(getConnected(), $date);
    $route = mysqli_real_escape_string(getConnected(), $route);
    $departure = mysqli_real_escape_string(getConnected(), $departure);
    $speedoTripStart = mysqli_real_escape_string(getConnected(), $speedoTripStart);
    $arrivalToClient = mysqli_real_escape_string(getConnected(), $arrivalToClient);
    $unloading = mysqli_real_escape_string(getConnected(), $unloading);
    $departureFromClient = mysqli_real_escape_string(getConnected(), $departureFromClient);
    $arrival = mysqli_real_escape_string(getConnected(), $arrival);
    $speedoTripEnd = mysqli_real_escape_string(getConnected(), $speedoTripEnd);
    $distance = mysqli_real_escape_string(getConnected(), $distance);
    $consumptions = mysqli_real_escape_string(getConnected(), $consumptions);
    $driver = mysqli_real_escape_string(getConnected(), $driver);




    $mySQL = "INSERT INTO data_sheet VALUES ('', '$date', '$route', '$departure', '$speedoTripStart',
          '$arrivalToClient', '$unloading', '$departureFromClient', '$arrival', '$speedoTripEnd',
           '$distance', '$consumptions', '$driver' );";
    $result = mysqli_query(getConnected(), $mySQL);
    if($result) {

        header("location: ../index.php");
    } else {
        echo "NO LUCK in ITEMS CREATION " . mysqli_error($link) . " <br>";
    }
}




function updateVehicle($plateNumber, $speedo, $drivedBy) {
    $speedo = mysqli_real_escape_string(getConnected(), $speedo);


    $mySQL = "UPDATE vehicles SET   speedo='$speedo', drivingDate=CURDATE(), drivedBy='$drivedBy'
                               WHERE plateNumber='$plateNumber'; ";
    mysqli_query( getConnected(),  $mySQL );
}
