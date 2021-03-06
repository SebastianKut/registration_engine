<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Newsletter - zapisz się!</title>
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
                <form method="post" action="save.php">
                    <label>Podaj adres e-mail
                        <input type="email" name="email" value="<?= //add entered email to the input field using tenary operator and <?= which = <?php echo
                         isset($_SESSION['entered_email']) ? $_SESSION['entered_email'] : '';

                        ?>">
                    </label>
                    <input type="submit" value="Zapisz się!">

                    <?php 
                    if ( isset($_SESSION['entered_email']) ) {
                        echo '<p>This is not a correct email adddress</p>';
                        unset( $_SESSION['entered_email'] );
                    }
                    if ( isset($_SESSION['email_exists']) ) {
                        echo "<p>{$_SESSION['email_exists']} already exists. Enter another email</p>";
                        unset( $_SESSION['email_exists'] );
                    }
                    ?>
                </form>
            </article>
        </main>

    </div>
</body>
</html>