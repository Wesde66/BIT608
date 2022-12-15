<!DOCTYPE HTML>
<html>

<head>
    <title>Delete Room</title>
</head>

<body>

    <?php
    include "../re_used_file/check_session.php";
    checkUser();
    include "../re_used_file/config.php"; //load in any variables
    include "../re_used_file/header.php";
    include "../re_used_file/menu.php";
    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    //insert DB code from here onwards
    //check if the connection was good
    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit; //stop processing the page further
    }

    //function to clean input but not validate type and content
    function cleanInput($data)
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    //retrieve the Roomid from the URL
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET['id'];
        if (empty($id) or !is_numeric($id)) {
            echo "<h2>Invalid booking ID</h2>"; //simple error feedback
            exit;
        }
    }

    //the data was sent using a form therefore we use the $_POST instead of $_GET
    //check if we are saving data first by checking if the submit button exists in the array
    if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Delete')) {
        $error = 0; //clear our error flag
        $msg = 'Error: ';
        //RoomID (sent via a form it is a string not a number so we try a type conversion!)
        if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
            $id = cleanInput($_POST['id']);
        } else {
            $error++; //bump the error flag
            $msg .= 'Invalid booking ID '; //append error message
            $id = 0;
        }

        //save the Room data if the error flag is still clear and Room id is > 0
        if ($error == 0 and $id > 0) {
            $query = "DELETE FROM bookings WHERE bookingID=?";
            $stmt = mysqli_prepare($db_connection, $query); //prepare the query
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "<h2>Room details deleted.</h2>";
        } else {
            echo "<h2>$msg</h2>" . PHP_EOL;
        }
    }

    //prepare a query and send it to the server
    //NOTE for simplicity purposes ONLY we are not using prepared queries
    //make sure you ALWAYS use prepared queries when creating custom SQL like below
    $query = 'SELECT * FROM bookings WHERE bookingID=' . $id;
    $result = mysqli_query($db_connection, $query);
    $rowcount = mysqli_num_rows($result);
    ?>
    <h3><a href='currentbookings.php'>[Return to the booking listing]</a><a href='http://localhost/Motueka/index.php''>[Return to the main page]</a></h3>
<div class="w3-container">
<?php

//makes sure we have the Room
if ($rowcount > 0) {
    echo "<fieldset><legend>Booking details #$id</legend><dl>";
    $row = mysqli_fetch_assoc($result);
    echo "<dt>Booking ID:</dt><dd>" . $row['roomID'] . "</dd>" . PHP_EOL;
    echo "<dt>Check in:</dt><dd>" . $row['checkIn'] . "</dd>" . PHP_EOL;
    echo "<dt>Check out:</dt><dd>" . $row['checkout'] . "</dd>" . PHP_EOL;
    echo "<dt>Contact number:</dt><dd>" . $row['contactNum'] . "</dd>" . PHP_EOL;
    echo "<dt>Extras:</dt><dd>" . $row['extras'] . "</dd>" . PHP_EOL;
    echo "<dt>Room review:</dt><dd>" . $row['roomReview'] . "</dd>" . PHP_EOL;
    echo "</dl></fieldset>" . PHP_EOL;
?><form method="POST" action="delete_bookings.php">
    <h2>Are you sure you want to delete this booking?</h2>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="submit" name="submit" value="Delete">
    <a href="currentbookings.php">[Cancel]</a>
    </form>
    <?php
} else {
    echo "<h2>No Booking found, possibly deleted!</h2>"; //suitable feedback
}
mysqli_free_result($result); //free any memory used by the query
mysqli_close($db_connection); //close the connection once done
include "../re_used_file/footer.php";
    ?>
</table>
</div>
</body>
</html>