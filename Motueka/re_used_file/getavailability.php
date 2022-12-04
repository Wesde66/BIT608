
<?php
include "config.php";
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
//get the variables from the make a booking page
$fromDate = $_REQUEST['startDate'];
$endDate = $_REQUEST['endDate'];

//Check to make sure we have data
if($fromDate == "" or $endDate == ""){
    die("Invalid entry");
}else {
    //Make sure those dates are in the correct format
    $fromDate = date('y-m-d', strtotime(($fromDate)));
    $endDate = date('y-m-d', strtotime(($endDate)));
    //if we have data run the query
    $query = "SELECT * FROM room WHERE roomID NOT IN (SELECT roomID FROM bookings WHERE checkin >= '$fromDate' AND checkout <= '$endDate')";
    $que = mysqli_query($db_connection, $query);


    $result = $que->fetch_all(PDO::FETCH_ASSOC);
}
?>

    <!--Styles for the table being displayed-->
    <style>
        #Room_search_table {
            width: 100%
            border-collapse: collapse;
            align-content: center;
        }
        #Room_search_table, td, th {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

    </style>


<!--the heading for the table being displayed-->
<table id="Room_search_table">
    <thead><tr><th>Room Name</th><th>Type</th><th>Action</th><th>Type room</th><th>Beds</th></tr></thead>
    <!--run through the loop and display the results-->
    <?php
    foreach ($result as $room) :
        ?>
        <tr>
            <td><?php echo $room[0];?></td>
            <td><?php echo $room[1];?></td>
            <td><?php echo $room[2];?></td>
            <td><?php echo $room[3];?></td>
            <td><?php echo $room[4];?></td>

        </tr>
    <?php endforeach;?>

</table>






