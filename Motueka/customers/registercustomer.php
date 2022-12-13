<?php

include "../re_used_file/check_session.php";

include "../re_used_file/config.php";
include "../re_used_file/clean_input.php";
//Make sure fields are entered before submit and that they are correct
$error = 0; //clear our error flag
$msg = '';
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Register')) {


    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
        exit; //stop processing the page further
    }

    //Checking data exists and is not invalid characters
    if(empty($_POST['firstname'])){
        $firstnameErr = 'Please complete correctly';
    }else{
        $firstname = $_POST['firstname'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $firstname )){
            $firstnameErr = 'Incorrect characters used';

        }
    }
    if(empty($_POST['lastname'])){
        $lastnameErr = 'Please complete correctly';
    }else{
        $lastname = $_POST['lastname'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $lastname )){
            $lastnameErr = 'Incorrect characters used';

        }
    }
    if(empty($_POST['email'])){
        $emailErr = 'Please complete';
    }else{
        $email = $_POST['email'];

    }
    if(empty($_POST['mobile'])){
        $mobileErr = 'Please complete';
    }else{
        $mobile = $_POST['mobile'];

    }
// This is the end of the data check section
    if (isset($_POST['firstname']) and !empty($_POST['firstname']) and is_string($_POST['firstname'])) {
        $fn = cleanInput($_POST['firstname']);
        $firstname = (strlen($fn)>50)?substr($fn,1,50):$fn; //check length and clip if too big

    }else {
        $error++; //bump the error flag
        $msg .= 'Invalid firstname '; //append error message
        $firstname = '';
    }
    if (isset($_POST['lastname']) and !empty($_POST['lastname']) and is_string($_POST['lastname'])) {
        $ln = cleanInput($_POST['lastname']);
        $lastname = (strlen($ln)>50)?substr($ln,1,50):$ln; //check length and clip if too big
    }else {
        $error++; //bump the error flag
        $msg .= 'Invalid lastname '; //append error message
        $lastname = '';
    }

    if (isset($_POST['email']) and !empty($_POST['email']) and is_string($_POST['email'])) {
        $en = cleanInput($_POST['email']);
        $email = (strlen($en) > 50) ? substr($en, 1, 50) : $en; //check length and clip if too big
    }else {
        $error++; //bump the error flag
        $msg .= 'Invalid email '; //append error message
        $email = '';
    }
    if (isset($_POST['mobile']) and !empty($_POST['mobile']) and is_string($_POST['mobile'])) {
        $mn = cleanInput($_POST['mobile']);
        $mobile = (strlen($mn) > 50) ? substr($mn, 1, 10) : $mn; //check length and clip if too big
    }else {
        $error++; //bump the error flag
        $msg .= 'Invalid mobile '; //append error message
        $mobile = '';
    }
    if (isset($_POST['password']) and !empty($_POST['password']) and is_string($_POST['password'])) {
        $pw = cleanInput($_POST['password']);
        $password = (strlen($pw) > 255) ? substr($pw, 1, 255) : $pw; //check length and clip if too big
        $password = password_hash($password, PASSWORD_DEFAULT);
    }else {
        $error++; //bump the error flag
        $msg .= 'Invalid password '; //append error message
        $password = '';
    }
    // End of data clean up

    if ($error == 0){
        //Check if email is already in system
        $queryEmail = "SELECT email FROM customer WHERE email ='$email'";
        $resultEmail = mysqli_query($db_connection,$queryEmail); //prepare the query
        $rowcountEmail = mysqli_num_rows($resultEmail);

        if ($rowcountEmail <= 0){
            $query = "INSERT INTO customer(firstname, lastname,email,mobile, password) 
                                VALUES (?,?,?,?,?)";
            $stmt = mysqli_prepare($db_connection,$query); //prepare the query
            mysqli_stmt_bind_param($stmt,'sssis', $firstname, $lastname, $email,$mobile, $password);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header('Location: http://localhost/Motueka/login.php');
        }else{
            ?>
            <script>window.alert('Email address already exists')</script>
            <?php
        }

    }else {
        echo "<h2>$msg</h2>".PHP_EOL;
    }
    mysqli_close($db_connection); //close the connection once done
}

include "../re_used_file/header.php";
include "../re_used_file/menu.php";
?>

    <section id="new_customer_reg">
        <form action="registercustomer.php" name="Registration_form" method="POST" class="was-validated">
            <div class="row">
                <div class="col">
                    <div class="mb-3 mt-3">
                        <label for="firstname" class="form-label">First name:</label>
                        <input type="text" class="form-control" id="firstname" placeholder="First Name" name="firstname" required>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3 mt-3">
                        <label for="lastname" class="form-label">Last name:</label>
                        <input type="text" class="form-control" id="lastname" placeholder="Last name" name="lastname" required>
                    </div>
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="mobile" class="form-label">Mobile:</label>
                <input type="tel" class="form-control" id="mobile" placeholder="Mobile number" name="mobile" required>
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
            <button type="submit" name="submit" class="btn btn-secondary" value="Register">Submit</button>
        </form>
        <div id="redirect_registration">
            <h6>Please click here if you do not have an account</h6>
            <br>
            <button type="submit" name="submit" class="btn btn-secondary" onclick="document.location.href='../login.php'">Existing customer login</button>
        </div>
    </section>

<?php
include "../re_used_file/footer.php";