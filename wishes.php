<?php
require_once "controllers/User.php";
require_once "controllers/Wishlist.php";
require_once "controllers/Wish.php";

if (isset($_GET["wishlist"])) {
    try {
        $wishlist = Wishlist::loadFromDb($_GET["wishlist"]);
    }
    catch (Exception $exception) {
        die($exception->getMessage());
    }
}
else {
    die("No wishlist given.");
}

try {
    $user = User::loadFromDb($wishlist->getUserId());
}
catch (Exception $e) {
    die("Error loading user.");
}

$name = $user->getFirstName();
if (empty($name)) {
    $name = $user->getUsername();
}
?>
<!doctype html>
<html lang="de">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title><?php printf("%s - %s", $name, $wishlist->getTitle()); ?></title>
</head>
<body class="text-center">

<div class="container">
    <h1><?php printf("%s - %s", $name, $wishlist->getTitle()); ?></h1>
</div>
<div class="container">
    <table class="table shadow">
        <thead class="thead-dark">
        <tr>
            <th>Priorität</th>
            <th>Wunsch</th>
            <th>Link</th>
            <th>Anzahl</th>
            <th>Preis von</th>
            <th>Preis bis</th>
            <th>Schenken</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($wishlist->getWishes() as $wish_id => $wish) {
            print("<tr>");
            printf(
                "<td>%d</td><td>%s</td><td>%s</td><td>%d</td><td>%s€</td><td>%s€</td><td>Button</td>",
                $wish->getPriority(),
                $wish->getTitle(),
                $wish->getUrl(),
                $wish->getAmount(),
                $wish->getPriceLow(),
                $wish->getPriceHigh()
            );
            print("</tr>");
        }
        ?>
        </tbody>
    </table>
</div>
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