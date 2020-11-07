<?php

session_start();

if( !isset($_SESSION['loggedin']) ) {
    header('Location: index.php');
    exit();
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
    
    <?php

echo '<a href="logout.php">Logout</a>';
echo "<h1>Witaj " .$_SESSION['user']." !</h1>";
echo "<p>Drewo: ".$_SESSION['drewno']." | Kamień: ".$_SESSION['kamien']." | Zboże: ".$_SESSION['zboze']." <br/>";
echo "Email: ".$_SESSION['email']." <br/>";
echo "Dni premium: ".$_SESSION['dnipremium']." </p>";

    ?>

</body>
</html>