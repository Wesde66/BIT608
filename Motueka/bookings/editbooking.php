<!DOCTYPE HTML>
<html><head><title>Edit a room</title> </head>
<body>


<?php
//Load in all pages that are needed.
include "../re_used_file/check_session.php";
//We need to check to see if user is allowed in.
checkUser();
include "../re_used_file/header.php";
include "../re_used_file/menu.php";
include "../re_used_file/config.php"; //load in any variables
include "../re_used_file/clean_input.php";

//Open server connection
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
$error=0;
$msg = "";
//Check connection
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
};

//retrieve the bookingid from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid booking ID</h2>"; //simple error feedback
        exit;
    }
}
//the data was sent using a form therefore we use the $_POST instead of $_GET
//check if we are saving data first by checking if the submit button exists in the array
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {
//validate incoming data - only the first field is done for you in this example - rest is up to you do

//BookingID (sent via a form ti is a string not a number, so we try a type conversion!)
    if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
        $id = cleanInput($_POST['id']);
    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid booking ID '; //append error message
       $id = 0;
    }
    //Check date and format
    if (isset($_POST['Checkindate']) and !empty($_POST['Checkindate'])) {
        $Checkindate = date('Y-m-d', strtotime($_POST['Checkindate']));
        $Checkindate = cleanInput($Checkindate);

    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid check in date '; //append error message
        $id = 0;
    }
    if (isset($_POST['Checkoutdate']) and !empty($_POST['Checkoutdate'])) {
        $Checkoutdate = date('Y-m-d', strtotime($_POST['Checkoutdate']));
        $Checkoutdate = cleanInput($Checkoutdate);
    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid check out date '; //append error message
        $id = 0;
    }
    //Check mobile number
    if (isset($_POST['MobileNumber']) and !empty($_POST['MobileNumber']) and is_integer(intval($_POST['MobileNumber']))) {
        $Mobile = cleanInput($_POST['MobileNumber']);
        $MobileNumber1 = (strlen($Mobile) > 50) ? substr($Mobile, 1, 10) : $Mobile; //check length and clip if too big
        if (preg_match('/^[0-9]*$/',$MobileNumber1 )) {
            $MobileNumber = $MobileNumber1;
        }
    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid contact number '; //append error message
        $id = 0;
    }
    // RoomID check
    if (isset($_POST['RoomId']) and !empty($_POST['RoomId']) and is_integer(intval($_POST['RoomId']))) {
        //Clean ID
        $roomIdC = cleanInput($_POST['RoomId']);
            //simple query to check see if the room exist
            $roomQuery = "SELECT roomID FROM room WHERE roomID = '$roomIdC'";
            $result = $db_connection->query($roomQuery);
            $row = mysqli_fetch_assoc($result);

            if (isset($row['roomID'])){
                if ($row['roomID'] == $roomIdC){
                    $RoomId = $roomIdC;
                }

            }else{
                $error++;
                $msg = "Room does not exist";
            }

    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid room ID '; //append error message
        $id = 0;
    }
    if (isset($_POST['extras'])){
        if (!empty($_POST['extras'])) {
            $Extras = cleanInput($_POST['extras']);
            $extras = (strlen($Extras) > 50) ? substr($Extras, 0, 255) : $Extras; //check length and clip if too big
        }
    }
    if (isset($_POST['roomReview'])){
        if (!empty($_POST['roomReview'])) {
            $RoomReview = cleanInput($_POST['roomReview']);
            $roomReview = (strlen($RoomReview) > 50) ? substr($RoomReview, 0, 255) : $RoomReview; //check length and clip if too big
        }
    }





//save the booking data if the error flag is still clear and room id is > 0
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
<script>
    //date picker code
    $( function() {
        var st = document.getElementById('Checkindate');
        $( st ).datepicker({
            numberOfMonths: 2,
            showButtonPanel: true,
            dateFormat: 'yy-mm-dd',
            minDate: 'today',

        });
    } );

    $( function() {
        var en = document.getElementById('Checkoutdate');
        $( en).datepicker({
            numberOfMonths: 2,
            showButtonPanel: true,
            dateFormat: 'yy-mm-dd',
            minDate: 'startdate + 1',
        });
    } );

</script>
<h3>Edit booking</h3>
<h4><a href='currentbookings.php'>[Return to current bookings]</a><a href='http://localhost/Motueka/index.php'>[Return to the main page]</a></h4>
<form class="w3-container" action="editbooking.php" name="Edit_booking_form" method="post">
    <input type="hidden" name="id" value="<?php echo $id;?>">

    <div class="row">
        <div class="mb-3 mt-3">
            <p>
                <label class="form-label" for="RoomId">Room number: </label>
                <input style="margin-left: 3%;" class="form-control-sm" type="text" id="RoomId" name="RoomId" value="<?php echo $row['roomID'];?> " required >
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>
                <label class="form-label" for="Checkindate">Check in date: </label>
                <input style="margin-left: 10%;" class="form-control-sm" type="text" id="Checkindate" name="Checkindate" value="<?php echo $row['checkIn'];?>" required >
            </p>
        </div>
        <div class="col">
            <p>

                <label class="form-label" for="Checkoutdate">Check out date: </label>
                <input class="form-control-sm" type="text" id="Checkoutdate" name="Checkoutdate" value="<?php echo $row['checkout'];?>" required>
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
                <input style="margin-left: 2%;" class="form-control-sm" type="tel" id="MobileNumber" name="MobileNumber" value="<?php echo $row['contactNum']; ?>" required>
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
