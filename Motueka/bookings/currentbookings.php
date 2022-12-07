<?php
include "../re_used_file/header.php";
include "../re_used_file/check_session.php";
include "../re_used_file/menu.php";

if ($_SESSION['userid'] === 1){
    //Create admin list of bookings
}else{
    //create customers list of bookings
}

?>

    <section id="body_list_all_bookings">
        <div class="w3-container w3-border-bottom" style="margin-top: 2%" id="body_list_all_bookings_heading">
            <h3>List of all bookings</h3>
        </div>
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
                </tr>
            </table>
        </div>
    </section>


<?php
include "../re_used_file/footer.php";
