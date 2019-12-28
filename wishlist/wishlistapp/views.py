from django.db.models import F
from django.http import HttpResponseRedirect
from django.shortcuts import render, get_object_or_404
from django.urls import reverse

from .models import Wish, Wishlist


def index(request):
    list_of_wishlists = Wishlist.objects.all()
    context = {'list_of_wishlists': list_of_wishlists}
    return render(request, 'wishlistapp/index.html', context)


def wishlist_detail(request, wishlist_id):
    wishlist = get_object_or_404(Wishlist, pk=wishlist_id)
    wishes = Wish.objects.filter(wishlist=1).filter(amount__gt=F('reserved_amount'))
    return render(request, 'wishlistapp/wishlist.html', {'wishlist': wishlist, 'wishes': wishes})


def wish_detail(request, wishlist_id, wish_id):
    wishlist = get_object_or_404(Wishlist, pk=wishlist_id)
    wish = get_object_or_404(Wish, pk=wish_id)
    return render(request, 'wishlistapp/wish.html', {'wishlist': wishlist, 'wish': wish})


def wish_reserve(request, wishlist_id, wish_id):
    wishlist = get_object_or_404(Wishlist, pk=wishlist_id)
    wish = get_object_or_404(Wish, pk=wish_id)
    amount = int(request.POST['amount'])
    if (amount > (wish.amount - wish.reserved_amount)):
        return render(
            request,
            'wishlistapp/wish.html',
            {'wishlist': wishlist, 'wish': wish, 'error_message': 'Zu viel reserviert'}
        )
    wish.reserved_amount += amount
    wish.save()
    return HttpResponseRedirect(reverse('wish_detail', args=(wishlist.id, wish.id)))
