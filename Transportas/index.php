<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: server/login.php");
  exit;
}
?>

<!DOCTYPE html>
<html dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Transporto valdymas</title>
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/main.css">
    </head>
    <body class="container">
        <div class="row ">
            <!-- hello ir logout -->
            <h3 class="col-4 mt-3">Sveiki, <?php echo $_SESSION['username']; ?> </h3>
            <a  href="server/logout.php" class="btn btn-dark col-2 offset-6 mt-3">Baigti darbą</a>
        </div>
        <?php require_once './server/sql_functions.php';

        $userType = getUserInfo($_SESSION['username']);

        if ($userType['userType'] == 'manager') {
         ?>
        <h4>Transporto priemonės registravimas</h4>
        <form class="" action="server/createVehicle.php" method="post">
        <div class="row">
            <div class="col-5">
                <div class="row">
                    <div class="col-7">
                        <label for="make">Transporto priemonės markė</label>
                        <label for="model">Transporto priemonės modelis</label>
                        <label for="plateNumber">Valstybinis numeris</label>
                        <label for="speedo">Spidometro rodmenys (km)</label>
                    </div>
                    <div class="col-5">
                        <input type="text" name="make" value="" placeholder="Ford" required>
                        <input type="text" name="model" value="" placeholder="Focus" required>
                        <input type="text" name="plateNumber" value="" placeholder="CCC222" required>
                        <input type="number" name="speedo" value="" placeholder="00000" required>
                    </div>
                </div>
            </div>

            <table class="col-5">
                <thead>
                    <th>Kuro normos</th>
                    <th>Kiekis (l/h)</th>
                </thead>
                <tr>
                    <td>Stovėjimas</td>
                    <td><input type="text" name="standingFuelCon" value="" placeholder="5" required></td>
                </tr>
                <tr>
                    <td>Važiavimas</td>
                    <td><input type="text" name="drivingFuelCon" value="" placeholder="32" required></td>
                </tr>
                <tr>
                    <td>Iškrovimas</td>
                    <td><input type="text" name="loadingFuelCon" value="" placeholder="20" required></td>
                </tr>
            </table>
        </div>
            <input type="submit" class="btn btn-primary" name="" value="Registruoti">
        </form>
        <?php

         ?>
         <h4>Registruotos transporto priemonės</h4>

         <div class="row">
             <div class="col-1 table">
                 <h6>Nr.</h6>
             </div>
             <div class="col-2 table">
                 <h6>Transporto priemonė</h6>
             </div>
             <div class="col-2 table">
                 <h6>Valstybinis numeris</h6>
             </div>
             <div class="col-2 table">
                 <h6>Spidometro rodmenys</h6>
             </div>
             <div class="col-2 table">
                 <h6>Paskutinis vairuotojas</h6>
             </div>
             <div class="col-3 table">
                 <h6>Paskutinė eksplotacijos data</h6>
             </div>
         </div>
         <?php for ($i=0, $j=1; $i < 50; $i++) {
             $registeredVehicles = getVehiclesInfo($i);
             if($registeredVehicles != NULL) {
          ?>
         <div class="row">
             <div class="col-1 table">
                 <p><?php echo $j; $j++?></p>
             </div>
             <div class="col-2 table">
                 <p><?php echo $registeredVehicles['make']; echo " "; echo $registeredVehicles['model']; ?></p>
             </div>
             <div class="col-2 table">
                 <p><?php echo $registeredVehicles['plateNumber']; ?></p>
             </div>
             <div class="col-2 table">
                 <p><?php echo $registeredVehicles['speedo']; ?></p>
             </div>
             <div class="col-2 table">
                 <p><?php echo $registeredVehicles['drivedBy']; ?></p>
             </div>
             <div class="col-3 table">
                 <p><?php echo $registeredVehicles['drivingDate']; ?></p>
             </div>
         </div>

        <?php
                    }
                }
            } elseif ($userType['userType'] == 'driver') {
        ?>
        <h4>Pildyti kelionės lapą</h4>
        <div class="row">
        <!-- keliones duomenu ivedimas -->

            <form class="" action="./server/dataEntry.php" method="post">
                <select class="" name="plateNumber">
                    <option >Pasirinkti</option>
                    <?php for ($i=0, $j=1; $i < 50; $i++) {
                        $registeredVehicles = getVehiclesInfo($i);
                            if($registeredVehicles != NULL) {
                     ?>
                    <option value="<?php echo $registeredVehicles['plateNumber']; ?>"><?php echo $registeredVehicles['make']; echo " "; echo $registeredVehicles['model']; ?></option>
                    <?php
                            }
                        }
                    ?>

                </select>
                <table>
                    <thead>
                        <th>Nr.</th>
                        <th>Data</th>
                        <th>Maršrutas</th>
                        <th>Išvyko iš terminalo</th>
                        <th>Spidometro parodymai</th>
                        <th>Atvyko pas klientą</th>
                        <th>Iškrovimas (min)</th>
                        <th>Išvyko iš kliento</th>
                        <th>Atvyko į terminalą</th>
                        <th>Spidometro parodymai</th>
                    </thead>
                    <tr>
                        <td>1</td>
                        <td> <input type="date" name="date_" value=""  required> </td>
                        <td> <textarea name="route" rows="2" cols="15" required></textarea> </td>
                        <td> <input type="time" name="departure" value="" required> </td>
                        <td> <input type="number" name="speedoTripStart" value="" required> </td> <!-- paimti is duomenu bazes paskutini skaiciu -->
                        <td> <input type="time" name="arrivalToClient" value="" required> </td>
                        <td> <input type="number" name="unloading" value="" required> </td>
                        <td> <input type="time" name="departureFromClient" value="" required> </td>
                        <td> <input type="time" name="arrival" value="" required> </td>
                        <td> <input type="number" name="speedoTripEnd" value="" required> </td>
                    </tr>
                </table>
                <button type="submit" name="button">Calculate</button>
            </form>
        </div>

        <h4>Kelionių žurnalas</h4>
        <div class="row">
            <div class="col-1 table">
                <h6>Nr.</h6>
            </div>
            <div class="col-2 table">
                <h6>Data</h6>
            </div>
            <div class="col-3 table">
                <h6>Maršrutas</h6>
            </div>
            <div class="col-3 table">
                <h6>Atstumas, km</h6>
            </div>
        </div>
        <?php for ($i=0, $j=1; $i < 15 ; $i++) {
                $driverData = getLatestData($i, $_SESSION['username']);
                if ($driverData != NULL) {
        ?>
        <div class="row">
            <div class="col-1 table">
                <p><?php echo $j; $j++ ?></p>
            </div>
            <div class="col-2 table">
                <p><?php echo $driverData['date_'] ?></p>
            </div>
            <div class="col-3 table">
                <p><?php echo $driverData['route'] ?></p>
            </div>
            <div class="col-3 table">
                <p><?php echo $driverData['distance'] ?></p>
            </div>
        </div>
        <?php
                }
            }
        } else {
        ?>
        <form class="form" action="return.php" method="post">
        <div class="row mt-5">
            <!-- administratoriaus darbas: matoma table -->
            <div class="col-3">
                <h6>Vairuotojas</h6>
            </div>
            <div class="col-3">
                <select class="" id="driver" name="driver">
                    <?php for ($i=0; $i < 50; $i++) {
                            $driver = getDrivers($i);
                                if ($driver != NULL) {

                     ?>
                        <option value="<?php echo $driver['username'] ?>"><?php echo $driver['username'] ?></option>

                    <?php
                                }
                            }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <h6>Data nuo</h6>
            </div>
            <div class="col-3">
                <input type="date" name="from" value="" required>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <h6>Data iki</h6>
            </div>
            <div class="col-3">
                <input type="date" name="to" value="" required>
            </div>
        </div>
        <div class="row">
        <button class="col-2 offset-3 btn btn-danger mt-3" id="filter" type="submit" name="button">Calculate</button>
        </div>
        </form>
        <div class="row results mt-4">

        </div>
        <?php
        }
        ?>








        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
        <script type="text/javascript" src="./js/main.js">

        </script>
    </body>
</html>
