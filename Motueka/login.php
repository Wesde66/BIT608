<?php

include "re_used_file/check_session.php";
include "re_used_file/config.php";
include "re_used_file/clean_input.php";




//Get the data and check it before we match it in the database.
$error = 0; //clear our error flag
$msg = '';
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Login')) {

    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit; //stop processing the page further
    }

    if (empty($_POST['username'])){
        $usernameErr = 'Please enter your user name';
    }else{
        $username = $_POST['username'];
    }
    if (empty($_POST['password'])){
        $passwordErr = 'Please enter your password';
    }else{
        $password = $_POST['password'];

    }

    //Double check data snip if we have to and clean the input
    if (isset($_POST['username']) and !empty($_POST['username']) and is_string($_POST['username'])) {
        $un = cleanInput($_POST['username']);
        $username = (strlen($un) > 50) ? substr($un, 1, 50) : $un; //check length and clip if too big
    }else {
        $error++; //bump the error flag
        $msg .= 'Invalid username '; //append error message
        $username = '';
    }
    if (isset($_POST['password']) and !empty($_POST['password']) and is_string($_POST['password'])) {
        $pw = cleanInput($_POST['password']);
        $password = (strlen($pw) > 255) ? substr($pw, 1, 255) : $pw; //check length and clip if too big

    }else {
        $error++; //bump the error flag
        $msg .= 'Invalid password '; //append error message
        $password = '';
    }
    //data check complete

    if ($error == 0){
        $query = "SELECT customerID, firstname, lastname,email,mobile, password, admin FROM customer WHERE email ='$username'";
        $result = mysqli_query($db_connection,$query); //prepare the query
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])){

                login($row['admin'],$row['firstname']." ".$row['lastname'] , $row['customerID']);
                echo '<p>Your are logged in </p>';

            }else{
                ?>
                <script>
                    window.alert("Your password is incorrect ")
                </script> <?php

            }

        }else{
            ?>
            <script>
                window.alert("User name does not exist")
            </script> <?php
        }

    }else {
        echo "<h2>$msg</h2>".PHP_EOL;
    }
    mysqli_close($db_connection); //close the connection once done

}
include "re_used_file/header.php";
include "re_used_file/menu.php";
loginStatus();
?>

    <section id="customer_login">
        <form action="login.php" class="was-validated"  name="login_profile" method="POST">
            <div class="mb-3 mt-3">
                <label for="email" class="form-label">Username:</label>
                <input type="email" class="form-control" id="username" placeholder="Enter email" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
            </div>
            <div class="form-check mb-3">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember" required> Please confirm terms and conditions
                </label>
            </div>
            <button type="submit" name="submit" value="Login" class="btn btn-secondary">Submit</button>
        </form>
        <div id="redirect_registration">
            <h6>Please click here if you do not have an account</h6>
            <br>
            <button type="button" class="btn btn-secondary" onclick="document.location.href='new_customer_registration.php'">Register</button>
        </div>
    </section>








<?php
include "re_used_file/footer.php";