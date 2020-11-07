<?php 

session_start();

if ( (isset($_SESSION['loggedin'])) && ($_SESSION['loggedin'] == true) ) {
    header('Location: game.php');
    exit;
};

//we are doing script on this site so we have to check if form was submitted
if(isset($_POST['email'])) { //isset returns true even if field is empty so after submit button is pressed
//validation checks 
//25minut into the movie


}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register new account</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<form method="post"> 
    Nickname: <br/> <input type="text" name="nick"> <br/> 

    E-mail: <br/> <input type="text" name="email"> <br/> 

    Password: <br/> <input type="password" name="password1"> <br/> 

    Repeat password: <br/> <input type="password" name="password2"> <br/>
    
    <label>
        <input type="checkbox" name="terms" />I accept terms
    </label>
    <div class="g-recaptcha" data-sitekey="6LcKROAZAAAAACEPCzztb4cjg4DxIyi5wzFAV_PT"></div>

    <input type="submit" name="submit" value="register" />
</form>

</body>
</html>