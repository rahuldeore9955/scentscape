<div class="checkout-modal" id="checkoutModal" hidden>
    <div class="checkout-modal-backdrop" data-close-checkout></div>
    <div class="checkout-modal-card" role="dialog" aria-modal="true" aria-labelledby="checkoutModalTitle">
        <button type="button" class="checkout-modal-close" aria-label="Close" data-close-checkout><i class="fas fa-times"></i></button>
        <span class="section-tag">Before You Buy</span>
        <h2 id="checkoutModalTitle">Create your account</h2>
        <p class="checkout-modal-note">We need these details for delivery and order history.</p>
        <form method="POST" action="{{ route('checkout.guest') }}" id="guestCheckoutForm">
            @csrf
            <input type="hidden" name="product_id" id="checkoutProductId">
            <input type="hidden" name="quantity" id="checkoutQuantity" value="1">
            <div class="checkout-form-grid">
                <label>Name<input type="text" name="name" required autocomplete="name"></label>
                <label>Email<input type="email" name="email" required autocomplete="email"></label>
                <label>Password<input type="password" name="password" required minlength="6" autocomplete="new-password"></label>
                <label>Confirm Password<input type="password" name="password_confirmation" required minlength="6" autocomplete="new-password"></label>
                <label>Phone<input type="tel" name="phone" required autocomplete="tel"></label>
                <label>Address<input type="text" name="address_line1" required autocomplete="street-address"></label>
                <label>City<input type="text" name="city" required autocomplete="address-level2"></label>
                <label>State<input type="text" name="state" required autocomplete="address-level1"></label>
                <label>Pincode<input type="text" name="pincode" required autocomplete="postal-code"></label>
            </div>
            <button type="submit" class="checkout-modal-submit">Continue to Payment <i class="fas fa-arrow-right"></i></button>
        </form>
    </div>
</div>
