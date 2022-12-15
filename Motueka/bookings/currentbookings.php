<?php

include "../re_used_file/check_session.php";
checkUser();
include "../re_used_file/header.php";
include "../re_used_file/menu.php";
?>
    <div class="w3-container w3-border-bottom">
        <h3>List of all bookings</h3>
    </div>
<?php


include "../re_used_file/config.php"; //load in any variables
$DBC = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

//insert DB code from here onwards
//check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
}
//We check to see if admin is logged in. We then display all bookings
if ($_SESSION['userid'] == 1){
    //Create admin list of bookings
    $query = "SELECT bookingID,checkIn, checkout, contactNum, extras, roomReview, roomID, customerID FROM bookings ORDER BY checkIn";
    $result = mysqli_query($DBC,$query);
    $rowcount = mysqli_num_rows($result);
?>
    <div id="body_list_all_bookings_body" class="w3-container">
            <table id="list_bookings_table" class="w3-table-all" style="margin-top: 1%">
                <tr>
                    <th>Customer ID</th>
                    <th>Room ID</th>
                    <th>Check in date</th>
                    <th>Check out date</th>
                    <th>Contact number</th>
                    <th>Extras required</th>
                    <th>Room review</th>
                    <th>Action</th>
                </tr>
<?php
    //makes sure we have rooms
    if ($rowcount > 0){
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['bookingID'];
            echo '<tr><td>'.$row['customerID'].'</td><td>'.$row['roomID'].'</td><td>'.$row['checkIn'].'</td><td>'.$row['checkout'].'</td><td>'.'0'.$row['contactNum'].'</td><td>'.$row['extras'].'</td><td>'.$row['roomReview'].'</td>';
            echo     '<td><a href="bookingdetailsview.php?id='.$id.'">[view]</a>';
            echo         '<a href="editbooking.php?id='.$id.'">[edit]</a>';
            echo         '<a href="delete_bookings.php?id='.$id.'">[delete]</a></td>';
            }
            echo '</tr>'.PHP_EOL;

    } else echo "<h2>No bookings found!</h2>";
}else{
    //If admin is not logged in we get the customers ID, and we list bookings on for that ID
    $customerID = $_SESSION['customerID'];
    //create customers list of bookings
    $query = "SELECT bookingID,checkIn, checkout, contactNum, extras, roomReview, roomID,customerID FROM bookings WHERE customerID = '$customerID'";
    $result = mysqli_query($DBC,$query);
    $rowcounts = mysqli_num_rows($result);
?></table>
            <div id="body_list_all_bookings_body" class="w3-container">
            <table id="list_bookings_table" class="w3-table-all" style="margin-top: 1%">
                <tr>
                    <th>Customer ID</th>
                    <th>Room ID</th>
                    <th>Check in date</th>
                    <th>Check out date</th>
                    <th>Contact number</th>
                    <th>Extras required</th>
                    <th>Room review</th>
                    <th>Action</th>
                </tr>
<?php
        if ($rowcounts > 0){
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['bookingID'];
            echo '<tr><td>'.$row['customerID'].'</td><td>'.$row['roomID'].'</td><td>'.$row['checkIn'].'</td><td>'.$row['checkout'].'</td><td>'.$row['contactNum'].'</td><td>'.$row['extras'].'</td><td>'.$row['roomReview'].'</td>';
            echo     '<td><a href="bookingdetailsview.php?id='.$id.'">[view]</a>';
            echo       '</td>';
        }
        echo '</tr>'.PHP_EOL;

    } else echo "<h2>No bookings found!</h2>";
}

?></table>



<?php
include "../re_used_file/footer.php";
