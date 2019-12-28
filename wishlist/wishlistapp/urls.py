from django.urls import path

from . import views

urlpatterns = [
    path('', views.index, name='index'),
    path('<int:wishlist_id>/', views.wishlist_detail, name='wishlist_detail'),
    path('<int:wishlist_id>/<int:wish_id>/', views.wish_detail, name='wish_detail'),
    path('<int:wishlist_id>/<int:wish_id>/reserve', views.wish_reserve, name='wish_reserve')
]
