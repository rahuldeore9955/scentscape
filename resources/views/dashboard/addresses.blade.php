@php($panelType = 'user')
@php($panelLinks = [['label' => 'Overview', 'icon' => 'fas fa-grid-2', 'url' => route('dashboard.index')], ['label' => 'My Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('dashboard.orders')], ['label' => 'Wishlist', 'icon' => 'fas fa-heart', 'url' => route('dashboard.wishlist')], ['label' => 'Addresses', 'icon' => 'fas fa-location-dot', 'url' => route('dashboard.addresses')], ['label' => 'Profile', 'icon' => 'fas fa-user', 'url' => route('dashboard.profile')]])
@extends('layouts.panel')
@section('title', 'Addresses - ScentScape')
@section('page_heading', 'Addresses')
@section('content')
    <div class="panel-welcome"><span class="panel-eyebrow">My Account</span><h1>Saved Addresses</h1><p>Manage multiple delivery addresses. Only one address can be the default.</p></div>

    <section class="panel-card">
        <div class="panel-card-heading"><h2>Your Addresses</h2></div>
        @if($addresses->isEmpty())
            <p class="panel-empty">No saved addresses yet. Add your first delivery address below.</p>
        @else
            <div class="address-manage-grid">
                @foreach($addresses as $address)
                    <article class="address-manage-card {{ $address->is_default ? 'default' : '' }}">
                        <div class="address-manage-heading"><h3>{{ ucfirst($address->label) }}</h3>@if($address->is_default)<span>Default</span>@endif</div>
                        <p><strong>{{ $address->full_name }}</strong><br>{{ $address->address_line1 }}@if($address->address_line2), {{ $address->address_line2 }}@endif<br>{{ $address->city }}, {{ $address->state }} {{ $address->pincode }}<br>{{ $address->country }}<br>{{ $address->phone }}</p>
                        <div class="address-manage-actions">
                            @if(!$address->is_default)
                                <form method="POST" action="{{ route('dashboard.addresses.default', $address) }}">@csrf @method('PATCH')<button type="submit" class="panel-link-btn">Make Default</button></form>
                            @endif
                            <form method="POST" action="{{ route('dashboard.addresses.destroy', $address) }}">@csrf @method('DELETE')<button type="submit" class="panel-delete-btn">Remove</button></form>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <section class="panel-card">
        <div class="panel-card-heading"><h2>Add Address</h2></div>
        <form method="POST" action="{{ route('dashboard.addresses.store') }}" class="panel-form">
            @csrf
            <div class="panel-form-grid">
                <label>Label<select name="label" required><option value="home">Home</option><option value="work">Work</option><option value="other">Other</option></select></label>
                <label>Full Name<input type="text" name="full_name" required></label>
                <label>Phone<input type="tel" name="phone" required></label>
                <label>Address Line 1<input type="text" name="address_line1" required></label>
                <label>Address Line 2<input type="text" name="address_line2"></label>
                <label>City<input type="text" name="city" required></label>
                <label>State<input type="text" name="state" required></label>
                <label>Pincode<input type="text" name="pincode" required></label>
                <label>Country<input type="text" name="country" value="India" required></label>
            </div>
            <button type="submit" class="panel-primary-btn">Save Address</button>
        </form>
    </section>
@endsection
