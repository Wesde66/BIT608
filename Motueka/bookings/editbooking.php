<!DOCTYPE HTML>
<html><head><title>Edit a room</title> </head>
<body>


<?php
include "../re_used_file/check_session.php";
checkUser();
include "../re_used_file/header.php";
include "../re_used_file/menu.php";
include "../re_used_file/config.php"; //load in any variables
include "../re_used_file/clean_input.php";


$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
$error=0;
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
};

//retrieve the roomid from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid room ID</h2>"; //simple error feedback
        exit;
    }
}
//the data was sent using a form therefore we use the $_POST instead of $_GET
//check if we are saving data first by checking if the submit button exists in the array
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {
//validate incoming data - only the first field is done for you in this example - rest is up to you do

//roomID (sent via a form ti is a string not a number so we try a type conversion!)
    if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
        $id = cleanInput($_POST['id']);
    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid room ID '; //append error message
        $id = 0;
    }
    if (isset($_POST['Checkindate']) and !empty($_POST['Checkindate'])) {
        $Checkindate = date('Y-m-d', strtotime($_POST['Checkindate']));

    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid check in date '; //append error message
        $id = 0;
    }
    if (isset($_POST['Checkoutdate']) and !empty($_POST['Checkoutdate'])) {
        $Checkoutdate = date('Y-m-d', strtotime($_POST['Checkoutdate']));

    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid check out date '; //append error message
        $id = 0;
    }
    if (isset($_POST['MobileNumber']) and !empty($_POST['MobileNumber']) and is_integer(intval($_POST['MobileNumber']))) {
        $MobileNumber = cleanInput($_POST['MobileNumber']);
    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid contact number '; //append error message
        $id = 0;
    }
    if (isset($_POST['RoomId']) and !empty($_POST['RoomId']) and is_integer(intval($_POST['RoomId']))) {
        $RoomId = cleanInput($_POST['RoomId']);
    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid room ID '; //append error message
        $id = 0;
    }
    if (isset($_POST['extras']) and !empty($_POST['extras'])) {
        $extras = cleanInput($_POST['extras']);
    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid extras '; //append error message
        $id = 0;
    }
    if (isset($_POST['roomReview']) and !empty($_POST['roomReview'])) {
        $roomReview = cleanInput($_POST['roomReview']);
    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid room review '; //append error message
        $id = 0;
    }




//save the room data if the error flag is still clear and room id is > 0
    if ($error == 0 and $id > 0)
    {
        $query = "UPDATE bookings SET checkIn=?,checkout=?,contactNum=?,extras=?, roomReview=?, roomID=? WHERE bookingID=?";
        $stmt = mysqli_prepare($db_connection, $query); //prepare the query
        mysqli_stmt_bind_param($stmt,'sssssss' ,  $Checkindate, $Checkoutdate, $MobileNumber,$extras,$roomReview,$RoomId, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<h2>Room details updated.</h2>";
    }
    else
    {
        echo "<h2>$msg</h2>";
    }
}
?>

<?php


$query = 'SELECT * FROM bookings WHERE bookingID ='.$id;
$result = mysqli_query($db_connection,$query);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
    $row = mysqli_fetch_assoc($result);

    ?>
<h3>Edit booking</h3>
<h4><a href='currentbookings.php'>[Return to current bookings]</a><a href='http://localhost/Motueka/index.php'>[Return to the main page]</a></h4>
<form class="w3-container" action="editbooking.php" name="Edit_booking_form" method="post">
    <input type="hidden" name="id" value="<?php echo $id;?>">

    <div class="row">
        <div class="mb-3 mt-3">
            <p>
                <label class="form-label" for="RoomId">Room number: </label>
                <input style="margin-left: 3%;" class="form-control-sm" type="text" id="RoomId" name="RoomId" value="<?php echo $row['roomID'];?> "  >
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>
                <label class="form-label" for="Checkindate">Check in date: </label>
                <input style="margin-left: 10%;" class="form-control-sm" type="text" id="Checkindate" name="Checkindate" value="<?php echo $row['checkIn'];?>"  >
            </p>
        </div>
        <div class="col">
            <p>

                <label class="form-label" for="Checkoutdate">Check out date: </label>
                <input class="form-control-sm" type="text" id="Checkoutdate" name="Checkoutdate" value="<?php echo $row['checkout'];?>">
            </p>
        </div>
        <div class="col">
            <p>

            </p>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 mt-3">
            <p>
                <label class="form-label" for="MobileNumber">Contact Number: </label>
                <input style="margin-left: 2%;" class="form-control-sm" type="tel" id="MobileNumber" name="MobileNumber" value="<?php echo $row['contactNum']; ?>">
            </p>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 mt-3">
            <p>
                <label class="form-label" for="extras">Extras for the booking: </label><br>
                <input class="form-control-lg" rows="5" type="text" id="extras" name="extras" value="<?php echo $row['extras']; ?>">
            </p>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 mt-3">
            <p>
                <label class="form-label" for="roomReview">Room review: </label><br>
                <input class="form-control-lg" rows="5" type="text" id="roomReview" name="roomReview" value="<?php echo $row['roomReview']; ?>">
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input type="submit" name="submit" value="Update">
        </div>
        <div class="col"><br>
            <a href='http://localhost/Motueka/bookings/currentbookings.php'>[Cancel]</a>
        </div>
    </div>
    <?php
}
else
{
    echo "<h2>room not found with that ID</h2>"; //simple error feedback
}
mysqli_close($db_connection); //close the connection once done
    include "../re_used_file/footer.php";
?>

</body>
</html>
