<?php
include "../re_used_file/header.php";
include "../re_used_file/check_session.php";
include "../re_used_file/menu.php";


?>
<head>
<script>
    function searchResult() {
       var st = document.getElementById('sdate').value;
        var ed = document.getElementById('edate').value;
        var string = '?checkInDate='+ st+"&checkOutDate="+ed;

        xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
//take JSON text from the server and convert it to JavaScript objects
//mbrs will become a two-dimensional array of our customers much like
//a PHP associative array
                var mbrs = JSON.parse(this.responseText);
                var tbl = document.getElementById("tblcustomers"); //find the table in the HTML

//populate the table
//mbrs.length is the size of our array
                for (var i = 0; i < mbrs.length; i++) {
                    var mbrid = mbrs[i]['roomID'];
                    var fn    = mbrs[i]['roomname'];
                    var ln    = mbrs[i]['roomtype'];
                    var des    = mbrs[i]['description'];

//concatenate our actions urls into a single string
                    var urls  = '<a href='+mbrid+'"viewcustomer.php?id=">[view]</a>';
                    urls += '<a href='+mbrid+'"editcustomer.php?id=">[edit]</a>';
                    urls += '<a href='+mbrid+'"deletecustomer.php?id=">[delete]</a>';

//create a table row with three cells
                    tr = tbl.insertRow(-1);
                    var tabCell = tr.insertCell(-1);
                    tabCell.innerHTML = ln; //lastname
                    var tabCell = tr.insertCell(-1);
                    tabCell.innerHTML = fn; //firstname
                    var tabCell = tr.insertCell(-1);
                    tabCell.innerHTML = des; //firstname
                    //var tabCell = tr.insertCell(-1);
                    //tabCell.innerHTML = urls; //action URLS
                }
            }
        }
//call our php file that will look for a customer or customers matching the search string
        xmlhttp.open("GET","getavailability.php"+string,true);
        xmlhttp.send();
    }
</script>
</head>
<body>

<h1>Customer List Search by Lastname</h1>
<h2><a href='makebookingandsearchavailability.php'>[Create new Customer]</a><a href="../index.php">[Return to main page]</a>
</h2>
<form>
    <label for="lastname">Lastname: </label>
    <label for="sdate"></label>
    <input title="E" id="sdate" placeholder="2000-10-20">
    <label for="edate"></label>
    <input title="E" id="edate" placeholder="2000-10-20">

    <button type="button" name="BTN" onclick="searchResult(this.value)">Fetch available rooms</button>





</form>
<table id="tblcustomers" border="1">
    <thead><tr><th>Last name</th><th>First name</th><th>Description</th></tr></thead>

</table>
</body>
</html>


<?php

include "../re_used_file/footer.php";
?>

