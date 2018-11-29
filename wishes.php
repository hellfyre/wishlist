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
            if ($wish->isReserved()) {
                $button = "<button type='button' class='btn btn-danger'>Schon weg :(</button>";
            }
            else {
                $button = sprintf(
                    "<button type='button' class='btn btn-success' data-toggle='modal' data-target='#keyModal' data-wishname='%s' data-wishid='%d' data-wishlistid='%d'>Will ich schenken!</button>",
                    $wish->getTitle(),
                    $wish->getId(),
                    $wish->getWishlistId()
                );
            }

            print("<tr>");
            printf(
                "
<td class='align-middle'>%d</td>
<td class='align-middle'>%s</td>
<td class='align-middle'><a href='%s' target='_blank'>%s</a></td>
<td class='align-middle'>%d</td>
<td class='align-middle'>%s€</td>
<td class='align-middle'>%s€</td>
<td class='align-middle'>%s</td>",
                $wish->getPriority(),
                $wish->getTitle(),
                $wish->getUrl(),
                $wish->getUrl(),
                $wish->getAmount(),
                $wish->getPriceLow(),
                $wish->getPriceHigh(),
                $button
            );
            print("</tr>");
        }
        ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="keyModal" tabindex="-1" role="dialog" aria-labelledby="keyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="keyModalLabel">Reservierung</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="keyModalForm">
                    <input type="hidden" id="wishid" value="-1"/>
                    <input type="hidden" id="wishlistid" value="-1"/>
                    <div class="form-group">
                        <label for="reservation-key" class="col-form-label">Du kannst hier ein Kennwort festlegen, um die Reservierung wieder aufheben zu können. Legst du kein Kennwort fest, ist der Wunsch unwiderruflich für dich reserviert und du MUSST ihn schenken.</label>
                        <input type="text" class="form-control" id="reservation-key" name="reservation-key">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Doch nicht.</button>
                <button type="button" class="btn btn-primary" id="reservation-submit">Reservieren!</button>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<script src="reservation_modals.js"></script>
</body>
</html>