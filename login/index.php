<?php 

session_start();
//check if logged in and redirect and stop the script 
if ( (isset($_SESSION['loggedin'])) && ($_SESSION['loggedin'] == true) ) {
    header('Location: game.php');
    exit;
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
    
    <a href="register.php">Register</a>

    <form action="login.php" method="post">

        Login:  <br /> <input type="text" name="login" /> <br />
        Hasło:  <br /> <input type="password" name="password" /> <br /> 
                <br /> <input type="submit" value="Login" />

    </form>

<?php 
if ( isset($_SESSION['error']) ) echo $_SESSION['error'];
?>


</body>
</html>