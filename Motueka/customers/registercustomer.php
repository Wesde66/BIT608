<?php

include "../re_used_file/check_session.php";

include "../re_used_file/config.php";
include "../re_used_file/clean_input.php";
include "../re_used_file/validations.php";
//Make sure fields are entered before submit and that they are correct
$error = 0; //clear our error flag
$msg = '';
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Register')) {


    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit; //stop processing the page further
    }

    //Checking data exists and is not invalid characters
    if (empty($_POST['firstname'])) {
        $firstnameErr = 'Please complete correctly';
    } else {
        $firstname = $_POST['firstname'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $firstname)) {
            $firstnameErr = 'Incorrect characters used';
        }
    }
    if (empty($_POST['lastname'])) {
        $lastnameErr = 'Please complete correctly';
    } else {
        $lastname = $_POST['lastname'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $lastname)) {
            $lastnameErr = 'Incorrect characters used';
        }
    }
    if (empty($_POST['email'])) {
        $emailErr = 'Please complete';
    } else {
        $email = $_POST['email'];
    }
    if (empty($_POST['mobile'])) {
        $mobileErr = 'Please complete';
    } else {
        $mobile = $_POST['mobile'];
    }
    // This is the end of the data check section
    if (isset($_POST['firstname']) and !empty($_POST['firstname']) and is_string($_POST['firstname'])) {
        $fn = cleanInput($_POST['firstname']);
        $firstname = (strlen($fn) > 50) ? substr($fn, 1, 50) : $fn; //check length and clip if too big

    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid firstname '; //append error message
        $firstname = '';
    }
    if (isset($_POST['lastname']) and !empty($_POST['lastname']) and is_string($_POST['lastname'])) {
        $ln = cleanInput($_POST['lastname']);
        $lastname = (strlen($ln) > 50) ? substr($ln, 1, 50) : $ln; //check length and clip if too big
    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid lastname '; //append error message
        $lastname = '';
    }

    if (isset($_POST['email']) and !empty($_POST['email']) and is_string($_POST['email'])) {
        $en = cleanInput($_POST['email']);
        $email = (strlen($en) > 50) ? substr($en, 1, 50) : $en; //check length and clip if too big
    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid email '; //append error message
        $email = '';
    }
    if (isset($_POST['mobile']) and !empty($_POST['mobile']) and is_string($_POST['mobile'])) {
        $mn = cleanInput($_POST['mobile']);
        $mobile = (strlen($mn) > 50) ? substr($mn, 1, 11) : $mn; //check length and clip if too big
    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid mobile '; //append error message
        $mobile = '';
    }

    if (isset($_POST['password']) and !empty($_POST['password']) and is_string($_POST['password'])) {
        $pw = password_validation($_POST['password']);
        if ($pw !== ""){
            $pw = cleanInput($pw);
            $password = (strlen($pw) > 255) ? substr($pw, 1, 255) : $pw; //check length and clip if too big
            $password = password_hash($password, PASSWORD_DEFAULT);
        }else{
            $error++; //bump the error flag
            $msg .= 'Invalid password '; //append error message
            $password = '';
        }

    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid password '; //append error message
        $password = '';
    }
    // End of data clean up

    if ($error == 0) {
        //Check if email is already in system
        $queryEmail = "SELECT email FROM customer WHERE email ='$email'";
        $resultEmail = mysqli_query($db_connection, $queryEmail); //prepare the query
        $rowcountEmail = mysqli_num_rows($resultEmail);

        if ($rowcountEmail <= 0) {
            $query = "INSERT INTO customer(firstname, lastname,email,mobile, password) 
                                VALUES (?,?,?,?,?)";
            $stmt = mysqli_prepare($db_connection, $query); //prepare the query
            mysqli_stmt_bind_param($stmt, 'sssis', $firstname, $lastname, $email, $mobile, $password);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header('Location: http://localhost/Motueka/login.php');
        } else {
?>
            <script>
                window.alert('Email address already exists')
            </script>
<?php
        }
    } else {
        //error messaged displayed in HTML
    }
    mysqli_close($db_connection); //close the connection once done
}

include "../re_used_file/header.php";
include "../re_used_file/menu.php";
?>


<!--Bootstrap new client register form-->
    <section class="vh-100 bg-image"
             style="background-image: url('http://localhost/Motueka/style/images/livingarea3.jpg');">

        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Create an account</h2>
                                <h6 id="errormessage" style="color: red"><?php echo $msg. PHP_EOL; ?></h6>

                                <form action="registercustomer.php" name="Registration_form" method="POST" class="has-validation">

                                    <div class="form-outline mb-4">
                                        <input type="text" id="firstname"  placeholder="First name" name="firstname" class="form-control form-control-lg" required />
                                        <label class="form-label" for="firstname">Your first name</label>
                                        <input type="text" id="lastname" placeholder="Last name" name="lastname" class="form-control form-control-lg" required/>
                                        <label class="form-label" for="lastname">Your last name</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="email" id="email" placeholder="Enter email" name="email" class="form-control form-control-lg" required />
                                        <label class="form-label" for="email">Your Email</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="tel" id="mobile" placeholder="Mobile number" name="mobile" pattern="([0-9]{3}[0-9]{3}[0-9]{4}|[0-9]{3}[0-9]{4}[0-9]{4})"
                                               class="form-control form-control-lg" required/>
                                        <label class="form-label" for="mobile">Your mobile</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <div id = "errors"></div>
                                        <input type="password" id="password" placeholder="Enter password" name="password" class="form-control form-control-lg" required/>
                                        <label class="form-label" for="password">Password</label>
                                        <!--JQuery visual for client-->
                                        <script>$("#password").passwordValidation({"confirmField": "#myConfirmPassword"}, function(element, valid, match, failedCases) {
                                                $("#errors").html("<pre>" + failedCases.join("\n") + "</pre>");
                                                if(valid) $(element).css("border","2px solid green");
                                                if(!valid) $(element).css("border","2px solid red");
                                                if(valid && match) $("#myConfirmPassword").css("border","2px solid green");
                                                if(!valid || !match) $("#myConfirmPassword").css("border","2px solid red");
                                            });</script>
                                    </div>
                                    <!--Need to create the logic to check passwords are the same-->
                                    <div class="form-outline mb-4">
                                        <input type="password" id="myConfirmPassword" class="form-control form-control-lg" />
                                        <label class="form-label" for="myConfirmPassword">Repeat your password</label>
                                    </div>

                                    <div class="form-check d-flex justify-content-center mb-5">
                                        <input class="form-check-input me-2" type="checkbox"  name="remember" value="" id="remember" required/>
                                        <label class="form-check-label" for="remember">
                                            I agree all statements in <a href="http://localhost/Motueka/privacy.php" class="text-body"><u>Terms of service</u></a>
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button type="submit" name="submit"  value="Register"
                                                class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                                    </div>

                                    <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="http://localhost/Motueka/login.php"
                                                                                                            class="fw-bold text-body"><u>Login here</u></a></p>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
include "../re_used_file/footer.php";
