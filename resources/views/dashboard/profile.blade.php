@php($panelType = 'user')
@php($panelLinks = [['label' => 'Dashboard', 'icon' => 'fas fa-gauge-high', 'url' => route('dashboard.index')], ['label' => 'My Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('dashboard.orders')], ['label' => 'Profile', 'icon' => 'fas fa-user', 'url' => route('dashboard.profile')]])
@extends('layouts.panel')
@section('title', 'Profile - ScentScape')
@section('page_heading', 'Profile')
@section('content')
    <div class="panel-welcome"><span class="panel-eyebrow">My Account</span><h1>Profile</h1><p>Keep your account information up to date.</p></div>
    <section class="panel-card">
        <form method="POST" action="{{ route('dashboard.profile.update') }}" class="panel-form">
            @csrf @method('PUT')
            <h2 class="panel-form-section-title">Account Information</h2>
            <div class="panel-form-grid"><label>Name<input type="text" name="name" value="{{ old('name', $user->name) }}" required></label><label>Email<input type="email" name="email" value="{{ $user->email }}" readonly required><button type="button" class="profile-email-change-trigger" id="openEmailChange">Change email</button></label><label>Mobile Number<input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" inputmode="numeric" pattern="[0-9]{10}" maxlength="10" placeholder="9876543210" required autocomplete="tel"></label></div>

            <h2 class="panel-form-section-title">Delivery Address</h2>
            <div class="panel-form-grid">
                <label>Full Name<input type="text" name="address_full_name" value="{{ old('address_full_name', $address?->full_name ?: $user->name) }}"></label>
                <label>Address Phone<input type="tel" name="address_phone" value="{{ old('address_phone', $address?->phone ?: $user->phone) }}" inputmode="numeric" pattern="[0-9]{10}" maxlength="10" placeholder="9876543210"></label>
                <label>Address Line 1<input type="text" name="address_line1" value="{{ old('address_line1', $address?->address_line1) }}" placeholder="House number and street"></label>
                <label>Address Line 2<input type="text" name="address_line2" value="{{ old('address_line2', $address?->address_line2) }}" placeholder="Apartment, landmark (optional)"></label>
                <label>State<input type="text" name="state" value="{{ old('state', $address?->state) }}"></label>
                <label>District<input type="text" name="district" value="{{ old('district', $address?->district) }}"></label>
                <label>City<input type="text" name="city" value="{{ old('city', $address?->city) }}"></label>
                <label>PIN Code<input type="text" name="pincode" value="{{ old('pincode', $address?->pincode) }}" inputmode="numeric" pattern="[0-9]{6}" maxlength="6"></label>
                <label>Country<input type="text" name="country" value="{{ old('country', $address?->country ?: 'India') }}"></label>
            </div>
            <button type="submit" class="panel-primary-btn">Save Profile</button>
        </form>
    </section>
    @php($emailChangeOpen = session('email_change_otp') || $errors->has('email') || $errors->has('otp'))
    <div class="checkout-modal profile-email-modal" id="emailChangeModal" @unless($emailChangeOpen) hidden @endunless role="dialog" aria-modal="true" aria-labelledby="emailChangeTitle">
        <div class="checkout-modal-backdrop" data-email-modal-close></div>
        <div class="checkout-modal-card">
            <button type="button" class="checkout-modal-close" data-email-modal-close aria-label="Close"><i class="fas fa-times"></i></button>
            @if(session('email_change_otp'))
                <h2 id="emailChangeTitle">Verify your new email</h2>
                <p class="checkout-modal-note">Enter the six-digit code sent to {{ session('email_change_otp.email') }}.</p>
                <form method="POST" action="{{ route('dashboard.email.verify') }}" class="panel-form">
                    @csrf
                    <label>Verification Code<input name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required autocomplete="one-time-code"></label>
                    <button type="submit" class="panel-primary-btn">Verify &amp; Update Email</button>
                </form>
            @else
                <h2 id="emailChangeTitle">Change email</h2>
                <p class="checkout-modal-note">Your current email remains active until the new address is verified.</p>
                <form method="POST" action="{{ route('dashboard.email.change') }}" class="panel-form">
                    @csrf
                    <label>New Email<input type="email" name="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email"></label>
                    <button type="submit" class="panel-primary-btn">Send Verification Code</button>
                </form>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const emailChangeModal = document.getElementById('emailChangeModal');
    const openEmailChange = document.getElementById('openEmailChange');
    const closeEmailChange = () => { emailChangeModal.hidden = true; document.body.classList.remove('modal-open'); };
    if (emailChangeModal && !emailChangeModal.hidden) document.body.classList.add('modal-open');
    openEmailChange?.addEventListener('click', () => { emailChangeModal.hidden = false; document.body.classList.add('modal-open'); });
    emailChangeModal?.querySelectorAll('[data-email-modal-close]').forEach((button) => button.addEventListener('click', closeEmailChange));
</script>
@endpush

