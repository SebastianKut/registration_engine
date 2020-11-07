<?php

//Create session which is a global values container so you can pass values between php documents, it is kept on a server so client has no access to it
session_start();

//in case user goes straight to this page we want to redirect to index and exit script
if ( (!isset($_POST['login'])) || (!isset($_POST['password'])) ) {
    header('Location: index.php');
    exit();
}

//get database values from connection.php
require_once("connect.php");


//start connection
$connection = @new mysqli($host, $db_user, $db_password, $db_name); //this is how you connect to mysql, putting @ makes php not throw errors to screen

//first we have to check if it was succesfull
if ($connection->connect_errno!=0) { //if there was an error the value will not be 0 because 0 is false

echo "Error: ".$connection->connect_errno;

} else {

    $login = $_POST['login'];
    $password = $_POST['password'];

    //PREVENT SQL INJECTIONS
    //sanitize input data first
    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
    $password = htmlentities($password, ENT_QUOTES, "UTF-8");

    //'%s' placeholders of a data, sprintf(query, value1, value2)
    if ( $result = @$connection->query(
            sprintf("SELECT * FROM uzytkownicy WHERE user='%s' AND pass='%s'",
                mysqli_real_escape_string($connection, $login),
                mysqli_real_escape_string($connection, $password)
            )
        ) ) { //if there was no mistake in the querry so if result is true
        $no_of_rows = $result->num_rows;
        if( $no_of_rows > 0 ) {    //if result is more than 0 records most probably 1

            //set in session that we are logged in
            $_SESSION['loggedin'] = true;

            $row = $result->fetch_assoc();      //we turn result record into into associative array where index instead   of number is the actual column name in the database
            
            //save user name in the session which is a global container for values stored on server accesible betwwen different php scripts
            $_SESSION['id'] = $row['id'];
            $_SESSION['user'] = $row['user'];
            $_SESSION['drewno'] = $row['drewno'];
            $_SESSION['kamien'] = $row['kamien'];
            $_SESSION['zboze'] = $row['zboze'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['dnipremium'] = $row['dnipremium'];
            

            //GARBAGE CLEAN 
            //remove error message from session memory if we logged in
            unset($_SESSION['error']);
            //always clear results from memory at the end
            $result->free_result();

            //redirect to what u want to show
            header('Location: game.php');
            //we dnt use exit() because we want to close connection still
        } else {

            $_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło</span>';
            header('Location: index.php');
            //we dnt use exit() because we want to close connection still
        }
    }

    //we have to always close connection at the end
    $connection->close();

}  


?>