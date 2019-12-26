from django.http import HttpResponse
from django.shortcuts import render, get_object_or_404

from .models import Wish, Wishlist


def index(request):
    list_of_wishlists = Wishlist.objects.all()
    context = {'list_of_wishlists': list_of_wishlists}
    return render(request, 'wishlistapp/index.html', context)


def detail(request, wishlist_id):
    wishlist = get_object_or_404(Wishlist, pk=wishlist_id)
    return render(request, 'wishlistapp/wishlist.html', {'wishlist': wishlist})
