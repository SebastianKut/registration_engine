<?php

session_start();

if ( isset($_POST['email']) ) {

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); //returns value input in the form if validation is positive or false if validation fails
    if ( empty($email) ) {//returns true if value is empty so NULL, false, '' etc...
        //FAILED VALIDATION
        $_SESSION['entered_email'] = $_POST['email'];
        header('Location: index.php');

    } else {
        //SUCCESSFULL VALIDATION
        
        //CONNECT TO DATABASE FIRST
        require_once 'database.php'; //we dnt have to require config.php because database.php requires it already
        //FIRST CHECK IF EMAIL EXISTS
         //1. Prepare the query
         $query = $db->prepare( 'SELECT * FROM users WHERE email = :email' );
         //2.Bind the value to the placeholder from query (pass 3 parameters (where, what, what type))
         $query->bindValue( ':email', $email, PDO::PARAM_STR ); 
         //3.Execute the query
         $query->execute();
            //using rowCount we check if given email returned any records
         if ( ($query->rowCount()) > 0 ) {
            $_SESSION['email_exists'] = $email;
            header('Location: index.php');
         } else {
            //INSERT EMAIL TO DB
            //1. Prepare the query
            $query = $db->prepare( 'INSERT INTO users VALUES (NULL, :email)' );
            //2.Bind the value to the placeholder from query (pass 3 parameters (where, what, what type))
            $query->bindValue( ':email', $email, PDO::PARAM_STR ); 
            //3.Execute the query
            $query->execute();

            //we dnt have to close connection using PDO because it gets closed at the end of php script when PDO object no longer exists. If the script was super long we can close connection by making PDO object = NULL
         }

    }

} else {
    header('Location: index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="utf-8">
    <title>Zapisanie się do newslettera</title>
    <meta name="description" content="Używanie PDO - zapis do bazy MySQL">
    <meta name="keywords" content="php, kurs, PDO, połączenie, MySQL">

    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">

        <header>
            <h1>Newsletter</h1>
        </header>

        <main>
            <article>
                <p>Dziękujemy za zapisanie się na listę mailową naszego newslettera!</p>
            </article>
        </main>

    </div>

</body>
</html>