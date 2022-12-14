<?php
include "../re_used_file/check_session.php";
checkUser();

?>

<script>
    //Search for available rooms code.
    function searchResult() {
        //Get the date to be sent from the input fields
       var st = document.getElementById('sdate').value;
        var ed = document.getElementById('edate').value;
        //Copy those dates to the input fields on the make a booking side
        document.getElementById('stdate').value = st;
        document.getElementById('endate').value = ed;
        //Create the string to use with the XMLHTTPrequest
        var string = '?checkInDate='+ st+"&checkOutDate="+ed;

        xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
                //take JSON text from the server and convert it to JavaScript objects
                //mbrs will become a two-dimensional array of our rooms much like
                //a PHP associative array
                var mbrs = JSON.parse(this.responseText);
                var tbl = document.getElementById("tblcustomers"); //find the table in the HTML

                    //populate the table
                    //mbrs.length is the size of our array
                for (var i = 0; i < mbrs.length; i++) {
                    var mbrid = mbrs[i]['roomID'];
                    var roomname    = mbrs[i]['roomname'];
                    var roomtype    = mbrs[i]['roomtype'];
                    var des    = mbrs[i]['description'];

                    //concatenate our actions urls into a single string
                    var urls  = '<a href='+mbrid+'"viewcustomer.php?id=">[view]</a>';
                    urls += '<a href='+mbrid+'"editcustomer.php?id=">[edit]</a>';
                    urls += '<a href='+mbrid+'"deletecustomer.php?id=">[delete]</a>';

                    //create a table row with three cells
                    tr = tbl.insertRow(-1);
                    var tabCell = tr.insertCell(-1);
                    tabCell.innerHTML = roomname; //lastname
                    var tabCell = tr.insertCell(-1);
                    tabCell.innerHTML = roomtype; //firstname
                    var tabCell = tr.insertCell(-1);
                    tabCell.innerHTML = des; //firstname
                    //var tabCell = tr.insertCell(-1);
                    //tabCell.innerHTML = urls; //action URLS
                    var x = document.getElementById("RoomName");
                    var option = document.createElement("option");
                    option.value = roomname;
                    option.text = roomname;
                    x.add(option);

                }
            }
        }
        //The call request to the PHP file for the rooms
        xmlhttp.open("GET","getavailability.php"+string,true);
        xmlhttp.send();

    }
</script>
<?php
include '../re_used_file/clean_input.php';
include '../re_used_file/config.php';
//This code is used to store the booking in the database
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Make_Booking')){

    $DBC = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
        exit; //stop processing the page further
    }
    //Variables for the database
    $customerID = $_SESSION['customerID'];
    $roomID = " ";
    $extras = " ";
    $contactNum = " ";
    $checkout = " ";
    $checkin = " ";
    $error = 0;

    //Get room ID of selected room.
    if(isset($_POST['RoomNameAvl']) and !empty($_POST['RoomNameAvl'])){
        $selectedRoom = $_POST['RoomNameAvl'];
        $selectedRoom = cleanInput($selectedRoom);
        $roomQuery = "SELECT roomID FROM room WHERE roomname = '$selectedRoom'";
        $result = $DBC->query($roomQuery);
        $row = mysqli_fetch_assoc($result);
        $roomID = $row['roomID'];
    }else{
        $roomID = " ";
        $error++;
    }
    //Get extras details
    if (isset($_POST['bookingsExtra'])){
        $extras = $_POST['bookingsExtra'];
        $extras = cleanInput($extras);
    }else{
        $extras = " ";

    }
    //Get contact number
    if(isset($_POST['mobile']) and !empty($_POST['mobile'])){
        $contact =cleanInput($_POST['mobile']) ;
        if (preg_match('/^[0-9]*$/',$contact )){
            $contact = cleanInput($contact);
            $contactNum = $contact;
        }else{
            $contactNum = " ";
            $error++;
        }
    }
    if(isset($_POST['stdate']) and !empty($_POST['stdate'])){
        $checkin =cleanInput($_POST['stdate']);
        //Make sure those dates are in the correct format
        $checkin = date('Y-m-d', strtotime(($checkin)));
    }else{
        $checkin = " ";
        $error++;
    }
    if(isset($_POST['endate']) and !empty($_POST['endate'])){
        $checkout =cleanInput($_POST['endate']);
        //Make sure those dates are in the correct format
        $checkout = date('Y-m-d', strtotime(($checkout)));
    }else{
        $checkout = " ";
        $error++;
    }
    if ($error === 0){
        $sql ="INSERT INTO bookings( checkIn, checkout, contactNum, extras, roomID, customerID)
                VALUES ('$checkin','$checkout','$contactNum','$extras','$roomID','$customerID')";
        if ($DBC->query($sql)=== TRUE){
            header('Location: http://localhost/Motueka/bookings/currentbookings.php');
        }else{
            echo "Error: ".$sql."<br>".$DBC->error;
        }
        $DBC->close();
    }

}
include "../re_used_file/header.php";
include "../re_used_file/menu.php";

?>
<script>
//date picker code
$( function() {
    var st = document.getElementById('sdate');
    $( st ).datepicker({
        numberOfMonths: 2,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',
        minDate: 'today',

    });
} );

$( function() {
    var en = document.getElementById('edate');
    $( en).datepicker({
        numberOfMonths: 2,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',
        minDate: 'startdate + 1',
    });
} );

</script>
<body>
<div id="make_a_booking" class="w3-container">
    <h2>Please complete the below to make a booking</h2>
    <h4><a href="http://localhost/Motueka/bookings/currentbookings.php">[Current Bookings]</a><a href="http://localhost/Motueka/index.php">[Return to main page]</a></h4>
    <br>
    <p>Please search for available rooms before making a booking</p>

    <p>This booking is for user <?php echo $_SESSION['username']; ?></p>
    <section>
        <form action="makebookingandsearchavailability.php" id="Make_a_booking_form" method="post">
            <h4>Room selection</h4>
            <select name="RoomNameAvl" id="RoomName" title="RoomName" style="margin-bottom: 1%" required>
                <option id="roomOption" disabled selected value> -- select a room -- </option>
            </select>
            <br>
            <label for="stdate">Checkin Date: </label><input type="text" id="stdate" name="stdate" style="margin-left: 1%;" required readonly>
            <script>    </script>
            <label for="endate">Checkout Date: </label><input type="text" id="endate" name="endate" required readonly><br>
            <label for="mobile">Mobile number: </label><input type="tel" id="mobile" name="mobile" style="margin-top: 1%" required >
            <br>
            <label for="bookingsExtra" >Booking extras :</label><br>
            <textarea id="bookingsExtra" name="bookingsExtra" style="margin-bottom: 1%" placeholder="Please let us know if you require anything extra" rows="5" cols="60"></textarea>
            <br>
            <button name="submit" type="submit" id="submit" value="Make_Booking" style="margin-right: 3%">Confirm booking</button>
            <button name="Cancel" type="button" value="Reload Page" onclick="window.location.reload();" id="Cancel">Clear booking info</button>
        </form>
    </section>
</div>

    <!--This section will search for available rooms between dates selected. It will then populate the above
        text boxes with the dates searched and also populate the drop-down for the available rooms.-->
<div id="search_for_rooms" class="w3-container">
    <h2>Search for available rooms</h2>

    <form>
        <label for="checkin">Checkin date: </label>

        <input type="text" class="startDate" title="checkin" name="startdate" id="sdate" placeholder="2000-10-20" required>
        <label for="checkout">Checkout date: </label>
        <input type="text" title="checkout" id="edate" name="enddate" placeholder="2000-10-20" required>

        <button type="button" name="BTN" onclick="searchResult(this.value)" >Fetch available rooms</button>

    </form>
    <table id="tblcustomers" class="w3-table-all" style="margin-bottom: 3%; margin-top: 1%;">
        <thead><tr><th>Room Name</th><th>Room type</th><th>Description</th></tr></thead>

    </table>
</div>
</body>
</html>


<?php

include "../re_used_file/footer.php";
?>

