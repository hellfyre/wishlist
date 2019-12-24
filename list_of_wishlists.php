<?php
if (!$user->hasWishlist((int)$_GET['wishlist'])) {
    printf("<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        <strong>Fehler:</strong> Wunschliste %s gehört nicht dir!
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
        </button>
    </div>", $_GET['wishlist']);
    die();
}

$wishlist = Wishlist::loadFromDb($_GET['wishlist']);
print(
'<div class="container mt-5">
            <table class="table shadow">
                <thead class="thead-dark">
                    <tr>
                        <th>Priorität</th>
                        <th>Wunsch</th>
                        <th>Link</th>
                        <th>Anzahl</th>
                        <th>Preis von</th>
                        <th>Preis bis</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>'
);
foreach ($wishlist->getWishes() as $wish_id => $wish) {
    printf(
        '<tr>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>Edit Delete</td>
        </tr>',
        $wish->getPriority(),
        $wish->getTitle(),
        $wish->getUrl(),
        $wish->getAmount(),
        $wish->getPriceLow(),
        $wish->getPriceHigh()
    );
}
print('</tbody></table></div>');
