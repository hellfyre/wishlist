<!doctype html>
<html lang="de">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="css/signin.css" rel="stylesheet">

    <title>Wunschliste - Login</title>
</head>
<body class="text-center">

<?php
require_once "controllers/User.php";

session_start();
$wrong_password = false;

if(isset($_POST["username"]) && isset($_POST["current-password"])) {
    $user = User::loadFromDb($_POST["username"]);
    if ($user->passwordMatches($_POST["current-password"])) {
        $_SESSION["logged_in"] = "true";
        header("Location: index.php");
    }
    else {
        $wrong_password = true;
    }
}
?>

<form class="form-signin" method="post" action="login.php">
    <?php
    if ($wrong_password) {
        printf("<div class=\"alert alert-danger\" role=\"alert\">%s</div>", "Wrong password!");
    }
    ?>
    <label for="username" class="sr-only">Benutzername</label>
    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus/>
    <label for="current-password" class="sr-only">Passwort</label>
    <input type="password" id="current-password" name="current-password" class="form-control" placeholder="Password" required/>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>
</html>