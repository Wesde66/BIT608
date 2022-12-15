<?php


include "../re_used_file/config.php"; //load in any variables
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE) or die();


$fromDate = $_GET["checkInDate"];
$endDate = $_GET["checkOutDate"];
$searchresult = '';
if (isset($fromDate) and !empty($fromDate)) {
    if (isset($endDate) and !empty($endDate)) {
        $query = "SELECT * FROM room WHERE roomID NOT IN (SELECT roomID FROM bookings WHERE checkIn >= '$fromDate' AND checkout <= '$endDate')";
        $result = mysqli_query($db_connection, $query);
        $rowcount = mysqli_num_rows($result);

        if ($rowcount > 0) {
            $rows = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;

                $searchresult = json_encode($rows);

                //header('Content-Type: text/json; charset=utf-8');
            }
        } else echo "<tr><td colspan=3><h2>No Customers found!</h2></td></tr>";
    } else echo "<tr><td colspan=3> <h2>Invalid search query</h2>";
} else echo "<tr><td colspan=3> <h2>Invalid search query</h2>";

mysqli_free_result($result); //free any memory used by the query
mysqli_close($db_connection); //close the connection once done

echo $searchresult;
