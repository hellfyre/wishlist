<?php
require_once "controllers/Wish.php";
if (isset($_POST["reservation_wishid"])) {
    $key = isset($_POST["reservation_key"]) ? $_POST["reservation_key"] : "";
    $wish = Wish::loadFromDb($_POST["reservation_wishid"]);
    $wish->reserve($key);
}
?>