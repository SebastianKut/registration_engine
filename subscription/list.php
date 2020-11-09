<?php
session_start();

//connect to db
require_once 'database.php';

//check if logged in already 
if ( !isset($_SESSION['logged_id']) ) {
    //check if POST happened 
    if ( isset($_POST['login']) ) {

        $login = filter_input(INPUT_POST, 'login');
        $password = filter_input(INPUT_POST, 'pass');

        $user_query = $db->prepare('SELECT id, password FROM admins WHERE login = :login');
        $user_query->bindValue(':login', $login, PDO::PARAM_STR);
        $user_query->execute();

        //check how many records in response 2 ways:
        //first - $user_query->rowCount();

        //second
        $response = $user_query->fetch(); //returns assoc array where item names are db colum names
        
        //if response is not empty and verified password is true
        if ( $response && password_verify($password, $response['password']) ) {
            $_SESSION['logged_id'] = $response['id'];
            unset($_SESSION['bad_attempt']);
        } else {
            $_SESSION['bad_attempt'] = true;
            header('Location: admin.php');
            exit();
        }

    } else {
        header('Location: admin.php');
        exit();
    }
}

//check the list of emails - we dnt have to secure against sql injections because nothing that user inputs goes to the query

$query = $db->query('SELECT * FROM users');
$response = $query->fetchAll(); //fetch all returns assoc array and number indexed one together


?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Panel administracyjny</title>
    <meta name="description" content="Używanie PDO - odczyt z bazy MySQL">
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
                <table>
                    <thead>
                        <tr><th colspan="2">Number of records: <?= $query->rowCount(); ?></th></tr>
                        <tr><th>ID</th><th>E-mail</th></tr>
                    </thead>
                    <body>
                        <?php 
                        // make a loop to map all the records
                        foreach ( $response as $user ) {
                            echo "<tr><td>{$user['id']}</td><td>{$user['email']}</td></tr>";
                        }
                        ?>
                    </body>
                </table>
                <p><a href="logout.php">Logout</a></p>
            </article>
        </main>

    </div>

</body>
</html>