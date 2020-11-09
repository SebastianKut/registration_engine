<?php 

session_start();
//check if registration was successfull if not redirect
if ( !isset($_SESSION['registration_success']) ) {
    header('Location: index.php');
    exit;
} else {
    unset( $_SESSION['registration_success'] );
}

//garbage clean all session variables from registration after registration was successful
if( isset($_SESSION['form_nick']) ) unset( $_SESSION['form_nick'] );
if( isset($_SESSION['form_email']) ) unset( $_SESSION['form_email'] );
if( isset($_SESSION['form_password1']) ) unset( $_SESSION['form_password1'] );
if( isset($_SESSION['form_password2']) ) unset( $_SESSION['form_password2'] );
if( isset($_SESSION['form_terms']) ) unset( $_SESSION['form_terms'] );

if( isset($_SESSION['err_nick']) ) unset( $_SESSION['err_nick'] );
if( isset($_SESSION['err_email']) ) unset( $_SESSION['err_email'] );
if( isset($_SESSION['err_password']) ) unset( $_SESSION['err_password'] );
if( isset($_SESSION['err_terms']) ) unset( $_SESSION['err_terms'] );
if( isset($_SESSION['err_captcha']) ) unset( $_SESSION['err_captcha'] );

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gra przeglądarkowa</title>
</head>
<body>
    
    Thank you for registering on our website! You can login to your account!
    <a href="index.php">Log In</a>

</body>
</html>