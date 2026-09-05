@php($panelType = 'user')
@php($panelLinks = [['label' => 'Overview', 'icon' => 'fas fa-grid-2', 'url' => route('dashboard.index')], ['label' => 'My Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('dashboard.orders')], ['label' => 'Wishlist', 'icon' => 'fas fa-heart', 'url' => route('dashboard.wishlist')], ['label' => 'Addresses', 'icon' => 'fas fa-location-dot', 'url' => route('dashboard.addresses')], ['label' => 'Profile', 'icon' => 'fas fa-user', 'url' => route('dashboard.profile')]])
@extends('layouts.panel')
@section('title', 'Wishlist - ScentScape')
@section('page_heading', 'Wishlist')
@section('content')
    <div class="panel-welcome"><span class="panel-eyebrow">My Account</span><h1>Wishlist</h1><p>Keep your favorite fragrances close at hand.</p></div>
    <section class="panel-card"><p class="panel-empty">{{ $wishlist->count() ? 'Your saved products will appear here.' : 'Your wishlist is empty.' }}</p></section>
@endsection
