<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');


require_once 'sql_functions.php';


$make = $_POST['make'];
$model = $_POST['model'];
$plateNumber = $_POST['plateNumber'];
$standingFuelCon = $_POST['standingFuelCon'];
$drivingFuelCon = $_POST['drivingFuelCon'];
$loadingFuelCon = $_POST['loadingFuelCon'];
$speedo = $_POST['speedo'];



createVehicle($make, $model, $plateNumber, $standingFuelCon,
                        $drivingFuelCon, $loadingFuelCon, $speedo);
