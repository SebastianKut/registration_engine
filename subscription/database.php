<?php

$config = require_once 'config.php';

try {

    $db = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']};charset=utf8",
        $config['user'],
        $config['password'],
        [   //set conncetion attributes
            PDO::ATTR_EMULATE_PREPARES => false, //this is safer and less prone for sql injections but slower
            PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION 
        ]
    );

}
catch (PDOException $error) {
    //inside exit function we can put message to be displayed
    echo $error."<br/>";
    exit('Database error');

}