<div class="container mt-5 p-3 shadow text-left">
    <form target="index.php?wishlist=<?php print($_GET['wishlist']); ?>">
        <?php
        $wish = null;

        if (isset($_GET['edit'])) {
            $wish = Wish::loadFromDb((int)$_GET['edit']);
        }
        printf('<div class="form-group"><label for="editPrio">Priorität</label><input class="form-control" type="number" placeholder="Priorität" id="editPrio" value="%s"/></div>', $wish ? $wish->getPriority() : '');
        printf('<div class="form-group"><label for="editTitle">Wunsch</label><input class="form-control" type="text" placeholder="Wunsch" id="editTitle" value="%s"/></div>', $wish ? $wish->getTitle() : '');
        printf('<div class="form-group"><label for="editUrl">Link</label><input class="form-control" type="url" placeholder="Link" id="editUrl" value="%s"/></div>', $wish ? $wish->getUrl() : '');
        printf('<div class="form-group"><label for="editAmount">Anzahl</label><input class="form-control" type="number" placeholder="Anzahl" id="editAmount" value="%s"/></div>', $wish ? $wish->getAmount() : '');
        printf('<div class="form-group"><label for="editPriceLow">Preis von</label><input class="form-control" type="text" placeholder="Preis von" id="editPriceLow" value="%s"/></div>', $wish ? $wish->getPriceLow() : '');
        printf('<div class="form-group"><label for="editPriceHigh">Preis bis</label><input class="form-control" type="text" placeholder="Preis bis" id="editPriceHigh" value="%s"/></div>', $wish ? $wish->getPriceHigh() : '');
        ?>
        <button type="submit" class="btn btn-primary">Speichern</button>
    </form>
</div>