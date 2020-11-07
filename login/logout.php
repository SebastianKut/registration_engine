<?php 

session_start();

session_unset(); //remove session variables

header('Location: index.php');

?>
