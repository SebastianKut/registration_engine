<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz</title>
</head>
<body>

<h1>Zamówienie online</h1>
<form action="order.php" method="post">
    Liczba pączków (0.99 PLN/szt):
    <input type="text" name="paczki"/>
        <br/><br/>
    Liczba maślanek (1.29 PLN/szt):
    <input type="text" name="maslanki"/>
        <br/><br/>
    <input type="submit" value="Wyślij zamówienie"/>
</form>
</body>
</html>