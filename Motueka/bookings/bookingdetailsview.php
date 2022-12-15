<?php
include "../re_used_file/check_session.php";
include "../re_used_file/header.php";
include "../re_used_file/menu.php";

include "../re_used_file/config.php"; //load in any variables


$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

//insert DB code from here onwards
//check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit; //stop processing the page further
}

//do some simple validation to check if id exists
$id = $_GET['id'];
if (empty($id) or !is_numeric($id)) {
    echo "<h2>Invalid Booking ID</h2>"; //simple error feedback
    exit;
}

//prepare a query and send it to the server
//NOTE for simplicity purposes ONLY we are not using prepared queries
//make sure you ALWAYS use prepared queries when creating custom SQL like below
$query = 'SELECT * FROM bookings WHERE bookingID =' . $id;
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result);
?>
<h3>Booking Details View</h3>
<h4><a href='currentbookings.php'>[Return to current bookings]</a><a href='http://localhost/Motueka/index.php'>[Return to the main page]</a></h4>
<div class="w3-container">
    <?php
    //makes sure we have the bookings
    if ($rowcount > 0) {
        echo "<fieldset><legend>Booking details #$id</legend><dl>";
        $row = mysqli_fetch_assoc($result);
        echo "<dt>Check in date: </dt><dd>" . $row['checkIn'] . "</dd>" . PHP_EOL;
        echo "<dt>Check out date: </dt><dd>" . $row['checkout'] . "</dd>" . PHP_EOL;
        echo "<dt>Contact number:</dt><dd>" . $row['contactNum'] . "</dd>" . PHP_EOL;
        echo "<dt>Room booked: </dt><dd>" . $row['roomID'] . "</dd>" . PHP_EOL;
        echo "<dt>Extras required: </dt><dd>" . $row['extras'] . "</dd>" . PHP_EOL;
        echo "<dt>Room review: </dt><dd>" . $row['roomReview'] . "</dd>" . PHP_EOL;
        echo '</dl></fieldset>' . PHP_EOL;
        echo '</div>';
    } else {
        echo "<h2>No booking found!</h2>"; //suitable feedback
    }
    mysqli_free_result($result); //free any memory used by the query
    mysqli_close($db_connection); //close the connection once done


    include "../re_used_file/footer.php";
    ?>