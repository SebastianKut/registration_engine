<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Podsumowanie zamówienia</title>
</head>
<body>


<?php
$paczki = $_POST['paczki'];  //we grab value from input form name 'paczki' taken form post method, if using GET it would be $_GET
$maslanki = $_POST['maslanki'];
$suma = (0.99 * $paczki) + (1.29 * $maslanki);

echo<<<END

<h2>Podsumowanie zamówienia</h2>

<table border="1" cellpadding="10" cellspacing="0">
<tr>
    <td>Pączki (0.99PLN/szt)</td> <td>$paczki</td>
</tr>
<tr>
    <td>Grzebień (1.29PLN/szt)</td> <td>$maslanki</td>
</tr>
<tr>
    <td>SUMA</td> <td>$suma</td>
</tr>
</table>
<br/>
<a href="index.php">Wróć</a>

END;
?>
</body>
</html>