<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 'on');


require_once ('sql_functions.php');


$driver = $_POST['driver'];
$from = $_POST['from'];

$to = $_POST['to'];
$mySQL = "SELECT * FROM data_sheet WHERE driver='$driver' AND (date_ BETWEEN '$from' AND '$to') ORDER BY date_ ASC;";
// $mySQL = "SELECT * FROM data_sheet WHERE driver='$driver';";
$result = mysqli_query(getConnected(), $mySQL);
if (!$result) {
    echo "bad query for data";
} else {
    echo '<table>
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
            <th>Atstumas</th>
            <th>Kuras</th>

        </thead>';

    for ($i=0, $j=1; $i < 50 ; $i++) {
         $row=mysqli_fetch_assoc($result);
        if($row != NULL) {
            echo "<tr>
            <td>" .$j. "</td>
            <td>" .$row['date_']. "</td>
            <td>" .$row['route']. "</td>
            <td>" .$row['departure']. "</td>
            <td>" .$row['speedoTripStart']. "</td>
            <td>" .$row['arrivalToClient']. "</td>
            <td>" .$row['unloading']. "</td>
            <td>" .$row['departureFromClient']. "</td>
            <td>" .$row['arrival']. "</td>
            <td>" .$row['speedoTripEnd']. "</td>
            <td>" .$row['distance']. "</td>
            <td>" .$row['consumptions']. "</td>
            </tr>";
            $j++;
        }
    }
    echo "</table>";
}
