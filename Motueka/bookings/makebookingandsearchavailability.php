<?php
include "../re_used_file/header.php";
include "../re_used_file/check_session.php";
include "../re_used_file/menu.php";


?>
                <section id="Make_and_search_booking">
                    <h3>Make a booking</h3>
                    <h4>
                        <a href="currentbookings.php">[Return to bookings view]</a>
                        <a href="../index.php">[Return to main page]</a>
                    </h4>
                    <div class="booking_display_info">
                        <h4>Booking for test</h4> <br>
                        <form action="makebookingandsearchavailability.php" method="POST">
                            <label for="room">Room selected</label>
                            <select id="room" name="room">
                                <option value="Kellie">Kellie</option>
                                <option value="Herman">Herman</option>
                                <option value="Scarlett">Scarlett</option>
                                <option value="Jelani">Jelani</option>
                                <option value="Sonya">Sonya</option>
                                <option value="Miranda">Miranda</option>
                                <option value="Helen">Helen</option>
                                <option value="Octavia">Octavia</option>
                                <option value="Gretchen">Gretchen</option>
                                <option value="Bernard">Bernard</option>
                                <option value="Dacey">Dacey</option>
                                <option value="Preston">Preston</option>
                                <option value="Dane">Dane</option>
                                <option value="Cole">Cole</option>
                            </select><br><br>
                            <label for="Checkindate">Checkin date :</label>
                            <input type="text" id="Checkindate" name="Checkindate" required><br><br>
                            <label for="Checkoutdate">Checkout date:</label>
                            <input type="text" id="Checkoutdate" name="Checkoutdate" required><br><br>
                            <label for="contactNo">Contact number:</label>
                            <input type="tel" name="contactNo" id="contactNo" pattern="([0-9]{3}[0-9]{3}[0-9]{4}|[0-9]{3}[0-9]{4}[0-9]{4})"
                                placeholder="123-1234-1234" required><br><br>
                            <label for="bookingExtra">Bookings extra:</label>
                            <textarea name="bookingExtra" id="bookingExtra" cols="30" rows="10"></textarea><br><br>
                            <button name="Add_booking"><strong>Add Booking</strong></button>
                            <a href="currentbookings.php" style="-webkit-text-fill-color: crimson">[Cancel]</a>

                        </form>
                    </div>

                        <h3>Search for room availability</h3><br>
                        <form action="makebookingandsearchavailability.php">
                            <label for="Start_date">Start date:</label>
                            <input type="text" id="Start_date" name="Checkindate" required>
                            <label for="End_date">End date:</label>
                            <input type="text" id="End_date" name="Checkoutdate" required>
                            <button name="Search_Available"><strong>Search availability</strong></button>
                        </form>
                        <br>
                        <div>
                            <table id="Search_aval">

                            </table>
                        </div>

                </section>
<script>

</script>
<?php

include "../re_used_file/footer.php";
?>

