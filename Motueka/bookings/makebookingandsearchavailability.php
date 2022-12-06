<?php
include "../re_used_file/header.php";
include "../re_used_file/check_session.php";
include "../re_used_file/menu.php";


?>

<script>
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
    $( function() {
        var st = document.getElementsByName('startdate');
        $( st ).datepicker({
            numberOfMonths: 2,
            showButtonPanel: true,
            dateFormat: 'yy-mm-dd',
            minDate: 'today',

        });
    } );

    $( function() {
        var en = document.getElementsByName('enddate');
        $( en).datepicker({
            numberOfMonths: 2,
            showButtonPanel: true,
            dateFormat: 'yy-mm-dd',
            minDate: 'startdate + 1',
        });
    } );


</script>

<body>
<div>
    <h2>Please complete the below to make a booking</h2>
    <h4><a href="http://localhost/Motueka/bookings/currentbookings.php">[Current Bookings]</a><a href="http://localhost/Motueka/index.php">[Return to main page]</a></h4>
    <br>
    <p>This booking is for user <?php echo $_SESSION['username']; ?></p>
    <section>
        <h4>Room selection</h4>
        <select name="RoomNameAvl" id="RoomName" title="RoomName">
        <option id="roomOption" disabled selected value> -- select a room -- </option>
        </select>
        <br>
        <label for="stdate">Checkin Date: </label><input type="text" id="stdate" >
        <label for="endate">Checkout Date: </label><input type="text" id="endate" ><br>
        <label for="mobile">Mobile number</label><input type="tel" id="mobile">
        <br>
        <label for="bookingsExtra">Booking extras :</label><br>
        <textarea id="bookingsExtra" placeholder="Please let us know if you require anything extra" rows="5" cols="60"></textarea>
        <br>
        <button name="Submit" type="button" id="Submit">Confirm booking</button>
        <button name="Cancel" type="button" value="Reload Page" onclick="window.location.reload();" id="Cancel">Clear booking info</button>
    </section>
</div>



<h2>Search for available rooms</h2>

<form>
    <label for="checkin">Checkin date: </label>

    <input class="startDate" title="checkin" name="startdate" id="sdate" placeholder="2000-10-20">
    <label for="checkout">Checkout date: </label>
    <input title="checkout" id="edate" name="enddate" placeholder="2000-10-20">

    <button type="button" name="BTN" onclick="searchResult(this.value)" >Fetch available rooms</button>

</form>
<table id="tblcustomers" border="1">
    <thead><tr><th>Room Name</th><th>Room type</th><th>Description</th></tr></thead>

</table>
</body>
</html>


<?php

include "../re_used_file/footer.php";
?>

