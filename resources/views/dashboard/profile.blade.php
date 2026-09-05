@php($panelType = 'user')
@php($panelLinks = [['label' => 'Overview', 'icon' => 'fas fa-grid-2', 'url' => route('dashboard.index')], ['label' => 'My Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('dashboard.orders')], ['label' => 'Wishlist', 'icon' => 'fas fa-heart', 'url' => route('dashboard.wishlist')], ['label' => 'Addresses', 'icon' => 'fas fa-location-dot', 'url' => route('dashboard.addresses')], ['label' => 'Profile', 'icon' => 'fas fa-user', 'url' => route('dashboard.profile')]])
@extends('layouts.panel')
@section('title', 'Profile - ScentScape')
@section('page_heading', 'Profile')
@section('content')
    <div class="panel-welcome"><span class="panel-eyebrow">My Account</span><h1>Profile</h1><p>Keep your account information up to date.</p></div>
    <section class="panel-card">
        <form method="POST" action="{{ route('dashboard.profile.update') }}" class="panel-form">
            @csrf @method('PUT')
            <h2 class="panel-form-section-title">Account Information</h2>
            <div class="panel-form-grid"><label>Name<input type="text" name="name" value="{{ old('name', $user->name) }}" required></label><label>Email<input type="email" name="email" value="{{ old('email', $user->email) }}" required></label><label>Phone<input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"></label></div>

            <h2 class="panel-form-section-title">Default Delivery Address</h2>
            <div class="panel-form-grid">
                <label>Full Name<input type="text" name="address_full_name" value="{{ old('address_full_name', $address?->full_name ?: $user->name) }}"></label>
                <label>Address Phone<input type="tel" name="address_phone" value="{{ old('address_phone', $address?->phone ?: $user->phone) }}"></label>
                <label>Address Line 1<input type="text" name="address_line1" value="{{ old('address_line1', $address?->address_line1) }}" placeholder="House number and street"></label>
                <label>Address Line 2<input type="text" name="address_line2" value="{{ old('address_line2', $address?->address_line2) }}" placeholder="Apartment, landmark (optional)"></label>
                <label>City<input type="text" name="city" value="{{ old('city', $address?->city) }}"></label>
                <label>State<input type="text" name="state" value="{{ old('state', $address?->state) }}"></label>
                <label>Pincode<input type="text" name="pincode" value="{{ old('pincode', $address?->pincode) }}"></label>
                <label>Country<input type="text" name="country" value="{{ old('country', $address?->country ?: 'India') }}"></label>
            </div>
            <button type="submit" class="panel-primary-btn">Save Profile</button>
        </form>
    </section>
@endsection
