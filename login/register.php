<?php

//sectret key 6LcKROAZAAAAAHQUbfrRXUZq7oBNuHvgX4FXApvi

session_start();

if ( (isset($_SESSION['loggedin'])) && ($_SESSION['loggedin'] == true) ) {
    header('Location: game.php');
    exit;
};

//we are doing script on this site so we have to check if form was submitted
if(isset($_POST['email'])) { //isset returns true even if field is empty so after submit button is pressed
//validation checks 
//set the flag that has value true, then if it fails any tests it will be false
    $all_ok = true;

    //TEST TO BE PASSED
//1. check if login name is correct 
    $nick = $_POST['nick'];
    //check nicks length 
    if ( (strlen($nick)<3) || (strlen($nick)>20) ) {
        $all_ok = false;
        //create variable in session to display error to the user
        $_SESSION['err_nick'] = 'Nickname has to be between 3 and 20 letters';
    };

//2. check if values are alphanumeric with function ctype_alnum() -returns boolean lub preg_match(), which checks regex
    if ( ctype_alnum($nick)==false ) {
        $all_ok = false;
        $_SESSION['err_nick'] = 'Nickname has to be numbers or letters only';
    };

//3. Check email adress - use filter_var(zmienna, filtr)
    $email = $_POST['email'];
    //sanitize email using built in email filter FILTER_SANITIZE_EMAIL removes forbidden signs 
    $email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);
    //check if email is stil the same or if it passed validation FILTER_VALIDATE_EMAIL
    if ( (filter_var($email_sanitized, FILTER_VALIDATE_EMAIL)==false) || ($email_sanitized!=$email) ) {
        $all_ok = false;
        $_SESSION['err_email'] = 'Enter correct email';
    }

//4. Check passwords
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    //check if password is the right length
    if ( (strlen($password1)<8) || (strlen($password2)>20) ) {
        $all_ok = false;
        $_SESSION['err_password'] = 'Password has to be between 8 and 20 signs';
    }

    //check if both passwords are the same
    if ( $password1 != $password2 ) {
        $all_ok = false;
        $_SESSION['err_password'] = 'You entered different passwords';
    }

    //Hash the password - use 255 length in database for the password because the length may be extended
    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
    
//5. Check if terms and conditions are checked
    if( !isset($_POST['terms']) ) {
        $all_ok = false;
        $_SESSION['err_terms'] = "Accept terms and conditions";
    }

//6. Check recaptcha
    //value of our secret key
    $private_code = '6LcKROAZAAAAAHQUbfrRXUZq7oBNuHvgX4FXApvi';
    //check through google api passing our key and captcha value from our form $_POST['g-recaptcha-response']
    $request = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$private_code.'&response='.$_POST['g-recaptcha-response']);

    $response = json_decode($request);

    if ( !$response->success ) {
        $all_ok = false;
        $_SESSION['err_captcha'] = "Confirm you are not a robot";
    } 

//7. Check if enterend login exists in the database

    require_once'connect.php';
    mysqli_report(MYSQLI_REPORT_STRICT); //instead of warnings visibe for users use exceptions so we can catch them

    try {
        //connect to database
        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
        //if cant connect throw an error so catch block can show it in $err variable
        if ($connection->connect_errno!=0) { //if there was an error the value will not be 0 because 0 is false

            throw new Exception(mysqli_connect_errno());
            
            //CONNECTION SUCCESSFULL
            } else {
                //8. CHECK IF EMAIL EXISTS
                $result = $connection->query("SELECT id FROM uzytkownicy WHERE email='$email'");

                //throw exception if there was error in the querry
                if (!$result) throw new Exception($connection->error);
                //check how many rows returned - if more than 0 then email already exists
                $how_many_emails = $result->num_rows;
                if( $how_many_emails>0 ) {
                    $all_ok = false;
                    $_SESSION['err_email'] = 'Email already exists';
                }

                //9.CHECK IF NICKNAME EXISTS ALREADY
                $result = $connection->query("SELECT id FROM uzytkownicy WHERE user='$nick'");

                //throw exception if there was error in the querry
                if (!$result) throw new Exception($connection->error);
                //check how many rows returned - if more than 0 then email already exists
                $how_many_nicknames = $result->num_rows;
                if( $how_many_nicknames>0 ) {
                    $all_ok = false;
                    $_SESSION['err_nick'] = 'Username already exists';
                }

                //10. ALL TESTS ARE PASSED - INSERT USER TO DB
                if ( $all_ok == true ) {
                    //all good we can register user
                    if( $connection->query(
                        "INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$hashed_password', '$email', 100, 100, 100, 14)"
                    ) ) { //SUCCESS
                        $_SESSION['registration_success'] = true;
                        header('Location: welcome.php');
                    } else { //ERROR
                        throw new Exception($connection->error);
                    }



                    //redirect to page thank you for registration
                };

                //CLOSE CONNECTION
                $connection->close();
            }

    }
    catch(Exception $err) {
        echo '<span style="color:red;">Server error</span>';
        echo "<br />Error log: $err"; //this should be deleted in production so it deosnt show it in the browser
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register new account</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
    .error {
        color: red;
        margin: 10px 0;
    }
    
    
    </style>
</head>
<body>

<form method="post"> 
    Nickname: <br/> <input type="text" name="nick"> <br/> 

    <?php
    if (isset($_SESSION['err_nick'])) {
        echo '<div class="error">'.$_SESSION['err_nick'].'</div>';
        unset($_SESSION['err_nick']);
    }
    ?>

    E-mail: <br/> <input type="text" name="email"> <br/> 

    <?php
    if (isset($_SESSION['err_email'])) {
        echo '<div class="error">'.$_SESSION['err_email'].'</div>';
        unset($_SESSION['err_email']);
    }
    ?>

    Password: <br/> <input type="password" name="password1"> <br/> 

    <?php
    if (isset($_SESSION['err_password'])) {
        echo '<div class="error">'.$_SESSION['err_password'].'</div>';
        unset($_SESSION['err_password']);
    }
    ?>

    Repeat password: <br/> <input type="password" name="password2"> <br/>
    
    <label>
        <input type="checkbox" name="terms" />I accept terms
    </label>
    <?php
    if (isset($_SESSION['err_terms'])) {
        echo '<div class="error">'.$_SESSION['err_terms'].'</div>';
        unset($_SESSION['err_terms']);
    }
    ?>
    <div class="g-recaptcha" data-sitekey="6LcKROAZAAAAACEPCzztb4cjg4DxIyi5wzFAV_PT"></div>
    <?php
    if (isset($_SESSION['err_captcha'])) {
        echo '<div class="error">'.$_SESSION['err_captcha'].'</div>';
        unset($_SESSION['err_captcha']);
    }
    ?>
    <input type="submit" name="submit" value="register" />
</form>

</body>
</html>