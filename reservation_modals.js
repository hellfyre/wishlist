$('#keyModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var wish_name = button.data('wishname');
    var wish_id = button.data('wishid');
    var wishlist_id = button.data('wishlistid');

    $('#wishid').val(wish_id);
    $('#wishlistid').val(wishlist_id);

    $('#keyModalLabel').text('Kennwort für Wunsch ' + wish_name);
});
$('#keyModal').on('shown.bs.modal', function (event) {
    $('#reservation-key').trigger('focus');
});
$('#reservation-submit').click(function (event) {
    var wish_id = $('#wishid').val();
    var wishlist_id = $('#wishlistid').val();
    var reservation_key = $('#reservation-key').val();

    console.log("Wish id is " + wish_id);
    console.log("Wishlist id is " + wishlist_id);
    console.log("Reservation key is " + reservation_key);

    var target = "reservation.php?wishlist=" + wishlist_id;
    $.post(target, {reservation_wishid: wish_id, reservation_key: reservation_key}, function () {
        $('#keyModal').modal('hide');
        location.reload();
    });
});