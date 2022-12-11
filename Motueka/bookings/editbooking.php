<?php

if (!isset($_GET['id'])){
    header('Location: http://localhost/Motueka/bookings/currentbookings.php');
}else{
    $id = $_GET['id'];
}

include "../re_used_file/header.php";
include "../re_used_file/check_session.php";
include "../re_used_file/menu.php";

include "../re_used_file/config.php"; //load in any variables

$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

//insert DB code from here onwards
//check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
}
?>
<h3>Edit booking</h3>
<h4><a href='currentbookings.php'>[Return to current bookings]</a><a href='http://localhost/Motueka/index.php'>[Return to the main page]</a></h4>
<form class="w3-container" action="editbooking.php" name="Edit_booking_form" method="post">
<?php
$query = 'SELECT * FROM bookings WHERE bookingID ='.$id;
$result = mysqli_query($db_connection,$query);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
$row = mysqli_fetch_assoc($result);


?>
    <div class="row">
        <div class="mb-3 mt-3">
            <p>
                <label class="form-label" for="RoomId">Room number: </label>
                <input style="margin-left: 3%;" class="form-control-sm" type="text" id="RoomId" name="RoomId" value="<?php echo $row['roomID']; ?>" >
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>
                <label class="form-label" for="Checkindate">Check in date: </label>
                <input style="margin-left: 11%;" class="form-control-sm" type="text" id="Checkindate" name="Checkindate" value="<?php echo $row['checkIn']; ?>"  >
            </p>
        </div>
        <div class="col">
            <p>
                <label class="form-label" for="Checkoutdate">Check out date: </label>
                <input class="form-control-sm" type="text" id="Checkoutdate" name="Checkoutdate" value="<?php echo $row['checkout']; ?>"  >
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
                <textarea  class="form-control-lg" rows="5" type="text" id="extras" name="extras" placeholder="<?php echo $row['extras']; ?>"></textarea>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 mt-3">
            <p>
                <label class="form-label" for="roomReview">Room review: </label><br>
                <textarea  class="form-control-lg" rows="5" type="text" id="roomReview" name="roomReview" placeholder="<?php echo $row['roomReview']; ?>"></textarea>
            </p>
        </div>
    </div>
    <input type="hidden" name="id" value="<?php echo $id;?>">




        <p>

        </p>
    <?php

    ?>


</form>
<?php

}

include "../re_used_file/footer.php";
?>
