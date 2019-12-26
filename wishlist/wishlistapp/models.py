from django.contrib.auth.models import User
from django.db import models

class Wishlist(models.Model):
    owner = models.ForeignKey(User, on_delete=models.CASCADE)
    title = models.CharField(max_length=255)

    def __str__(self):
        return self.title

class Wish(models.Model):
    wishlist = models.ForeignKey(Wishlist, on_delete=models.CASCADE)

    # Short description of the Wish
    title = models.CharField(max_length=255)

    # Long description of the Wish
    description = models.TextField(blank=True, default='')

    # A link to the product, to minimize confusion
    url = models.CharField(max_length=2083, blank=True, default='')

    # This wish's priority. Lower number means higher priority.
    priority = models.IntegerField()

    # The lower end of an estimated price range for this product
    price_low = models.DecimalField(max_digits=10, decimal_places=2, blank=True, default=1)

    # The higher end of an estimated price range for this product
    price_high = models.DecimalField(max_digits=10, decimal_places=2, blank=True, default=1)

    # The amount of this wish (e.g. if you'd like to get 5 identical hats)
    amount = models.IntegerField(default=1)

    # How many items of this wish have already been reserved by someone (so the gifting persons can split a wish)
    reserved_amount = models.IntegerField(default=0)

    # A unique key to change a reservation without having a user account
    reservation_key = models.CharField(max_length=255, blank=True, default='')

    def __str__(self):
        return self.title