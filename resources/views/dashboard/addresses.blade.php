@php($panelType = 'user')
@php($panelLinks = [['label' => 'Dashboard', 'icon' => 'fas fa-gauge-high', 'url' => route('dashboard.index')], ['label' => 'Products', 'icon' => 'fas fa-box-open', 'url' => route('dashboard.products')], ['label' => 'My Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('dashboard.orders')], ['label' => 'Wishlist', 'icon' => 'fas fa-heart', 'url' => route('dashboard.wishlist')], ['label' => 'Profile', 'icon' => 'fas fa-user', 'url' => route('dashboard.profile')]])
@extends('layouts.panel')
@section('title', 'Addresses - ScentScape')
@section('page_heading', 'Addresses')
@section('content')
    <div class="panel-welcome"><span class="panel-eyebrow">My Account</span><h1>Delivery Address</h1><p>Keep one delivery address ready for checkout.</p></div>

    <section class="panel-card">
        <div class="panel-card-heading"><h2>Your Address</h2></div>
        @if(!$address)
            <p class="panel-empty">No delivery address has been saved yet. Add it below.</p>
        @else
            <div class="address-manage-grid">
                <article class="address-manage-card default">
                    <div class="address-manage-heading"><h3>Delivery</h3><span>Saved</span></div>
                    <p><strong>{{ $address->full_name }}</strong><br>{{ $address->address_line1 }}@if($address->address_line2), {{ $address->address_line2 }}@endif<br>{{ $address->city }}, {{ $address->state }} {{ $address->pincode }}<br>{{ $address->country }}<br>{{ $address->phone }}</p>
                    <div class="address-manage-actions">
                        <form method="POST" action="{{ route('dashboard.addresses.destroy', $address) }}">@csrf @method('DELETE')<button type="submit" class="panel-delete-btn">Remove</button></form>
                    </div>
                </article>
            </div>
        @endif
    </section>

    <section class="panel-card">
        <div class="panel-card-heading"><h2>{{ $address ? 'Update Address' : 'Add Address' }}</h2></div>
        <form method="POST" action="{{ route('dashboard.addresses.store') }}" class="panel-form">
            @csrf
            <div class="panel-form-grid">
                <input type="hidden" name="label" value="home">
                <label>Full Name<input type="text" name="full_name" value="{{ old('full_name', $address?->full_name) }}" required></label>
                <label>Phone<input type="tel" name="phone" value="{{ old('phone', $address?->phone) }}" required></label>
                <label>Address Line 1<input type="text" name="address_line1" value="{{ old('address_line1', $address?->address_line1) }}" required></label>
                <label>Address Line 2<input type="text" name="address_line2" value="{{ old('address_line2', $address?->address_line2) }}"></label>
                @include('partials.location-selects', ['selectedState' => old('state', $address?->state), 'selectedCity' => old('city', $address?->city)])
                <label>Pincode<input type="text" name="pincode" value="{{ old('pincode', $address?->pincode) }}" required></label>
                <label>Country<input type="text" name="country" value="{{ old('country', $address?->country ?: 'India') }}" required></label>
            </div>
            <button type="submit" class="panel-primary-btn">Save Address</button>
        </form>
    </section>
@endsection

