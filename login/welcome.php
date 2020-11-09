<?php 

session_start();
//check if registration was successfull 
if ( !isset($_SESSION['registration_success']) ) {
    header('Location: index.php');
    exit;
} else {
    unset( $_SESSION['registration_success'] );
}

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