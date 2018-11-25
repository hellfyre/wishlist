<?php

session_start();

if (!isset($_SESSION["logged_in"])) {
    header("Location: login.php");
}
if (isset($_GET["logout"])) {
    unset($_SESSION["logged_in"]);
    header("Location: login.php");
}
else {
    print("Yay");
}

?>