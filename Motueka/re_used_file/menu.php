
    <div id="header" class="w3-bar w3-light-grey">
      <div id="logo">
        <div id="logo_text">

            <a href="http://localhost/index.php"><span class="w3-bar-item w3-button">Ongaonga Bed & Breakfast</span></a>
            <a href="http://localhost/Motueka/login.php" class="w3-bar-item w3-button">Login</a>

            <!--This is the dropdown for Bookings section-->
            <div class="w3-dropdown-hover">
                <button class="w3-button">Bookings</button>
                <div class="w3-dropdown-content w3-bar-block w3-card-4">
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/bookings/bookingdetailsview.php">View booking details</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/bookings/makebookingandsearchavailability.php">Make booking</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/bookings/makebookingandsearchavailability.php">Search for availability</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/bookings/currentbookings.php">Current bookings</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/bookings/currentbookings.php">Edit bookings</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/bookings/currentbookings.php">Delete a booking</a>
                </div>
            </div>
            <!--This is the dropdown for Rooms section-->
            <div class="w3-dropdown-hover">
                <button class="w3-button">Rooms</button>
                <div class="w3-dropdown-content w3-bar-block w3-card-4">
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/rooms/addroom.php">Add rooms</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/rooms/deleteroom.php">Delete a room</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/rooms/editoraddroomreview.php">Add or edit a room review</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/rooms/editroom.php">Edit room details</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/rooms/listrooms.php">List all rooms</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/rooms/viewroom.php">View room details</a>
                </div>
            </div>
            <!--This is the dropdown for Customers section-->
            <div class="w3-dropdown-hover">
                <button class="w3-button">Customers</button>
                <div class="w3-dropdown-content w3-bar-block w3-card-4">
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/customers/customersearch.php">Search for customer</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/customers/deletecustomer.php">Delete customer</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/customers/editcustomer.php">Edit a customer</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/customers/listcustomers.php">List customers</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/customers/registercustomer.php">Register a customer</a>
                    <a class="w3-bar-item w3-button" href="http://localhost/Motueka/customers/viewcustomer.php">View customer details</a>
                </div>
            </div>

                <?php loginStatus(); ?>
                <a href="http://localhost/Motueka/login.php" class="w3-bar-item w3-button w3-right ">Logout</a>
        </div>
      </div>
    </div>

