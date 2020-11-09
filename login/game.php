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
echo "Expiry date: ".$_SESSION['dnipremium']." </p>";

//SHOW HOW MANY DAYS LEFT UNTIL EXPIRATION
//get current date in datetime format
$current_date = new DateTime();

echo "Current date: ".$current_date->format('Y-m-d H:i:s')."<br/>";
//convert date from database to php datetime format
$expiration_date = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']);

//now get difference between 2 dates
$difference = $current_date->diff($expiration_date);

if ( $current_date<$expiration_date )
    echo "Your account expires in: ".$difference->format('%y years, %m months, %d days, %h hours, %i minutes, %s seconds');
else 
    echo "Your account has been expired for the last: ".$difference->format('%y years, %m months, %d days, %h hours, %i minutes, %s seconds')."days.";


// //TIME MANIPULATION NOTES
// echo time()."<br/>"; //time() shows seconds from 1970;

// echo date('Y-m-d H:i:s')."<br/>"; //shows server date in the format that we put in brakcets - this is format of date in mysql btw. Other formats for example:
// //echo date('Y-M-d D')."<br/>"

// //OBJECTIVE WAY TO GET DATE
// $datetime = new DateTime(); //if empty show current time
// echo $datetime->format('Y-m-d H:i:s');

// //Check if date is correct
// $day = 40;
// $month = 7;
// $year = 1914;

// if ( checkdate($month, $day, $year) ) 
//     echo "<br/>Correct date";
// else 
//     echo "<br/>Incorrect date";

    ?>

</body>
</html>