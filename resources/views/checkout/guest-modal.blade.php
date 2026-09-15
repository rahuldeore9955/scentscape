<div class="checkout-modal" id="checkoutModal" hidden>
    <div class="checkout-modal-backdrop" data-close-checkout></div>
    <div class="checkout-modal-card" role="dialog" aria-modal="true" aria-labelledby="checkoutModalTitle">
        <button type="button" class="checkout-modal-close" aria-label="Close" data-close-checkout><i class="fas fa-times"></i></button>
        <div id="guestCheckoutAccountStep">
            <span class="section-tag">Secure Checkout</span>
            <h2 id="checkoutModalTitle">Complete your purchase</h2>
            <div class="checkout-product-summary"><strong id="checkoutProductName">Selected fragrance</strong><span id="checkoutProductPrice"></span></div>
            <p class="checkout-modal-note">Create your account and add delivery details. We will verify your email before opening Razorpay.</p>
            <form id="guestCheckoutForm" class="checkout-form">
                <input type="hidden" name="product_id" id="checkoutProductId">
                <input type="hidden" name="quantity" id="checkoutQuantity" value="1">
                <div class="checkout-form-section-title">Account details</div>
                <div class="checkout-form-grid">
                    <label>Name<input type="text" name="name" required autocomplete="name"></label>
                    <label>Email<input type="email" name="email" required autocomplete="email"></label>
                    <label>Mobile Number<input type="tel" name="phone" inputmode="numeric" pattern="[0-9]{10}" maxlength="10" placeholder="9876543210" required autocomplete="tel"></label>
                    <label>Password<input type="password" name="password" minlength="6" required autocomplete="new-password"></label>
                    <label>Confirm Password<input type="password" name="password_confirmation" minlength="6" required autocomplete="new-password"></label>
                </div>
                <div class="checkout-form-section-title">Delivery address</div>
                <div class="checkout-form-grid">
                    <label class="checkout-full-field">Address Line 1<input type="text" name="address_line1" required autocomplete="street-address"></label>
                    <label class="checkout-full-field">Address Line 2<input type="text" name="address_line2" autocomplete="address-line2"></label>
                    <label>State<input type="text" name="state" required autocomplete="address-level1"></label>
                    <label>District<input type="text" name="district" required autocomplete="address-level2"></label>
                    <label>City<input type="text" name="city" required autocomplete="address-level2"></label>
                    <label>PIN Code<input type="text" name="pincode" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required autocomplete="postal-code"></label>
                </div>
                <label class="checkout-terms"><input type="checkbox" name="terms" value="1" required> I agree to create an account for this purchase.</label>
                <button type="submit" class="checkout-modal-submit">Send Verification Code <i class="fas fa-arrow-right"></i></button>
            </form>
            <p class="checkout-modal-login">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
        <div id="guestCheckoutVerifyStep" hidden>
            <span class="section-tag">Email Verification</span>
            <h2>Enter your code</h2>
            <p class="checkout-modal-note">We sent a six-digit verification code to <strong id="checkoutVerificationEmail"></strong>.</p>
            <form id="guestCheckoutVerifyForm" class="checkout-form">
                <label>Verification Code<input type="text" name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" placeholder="123456" required autocomplete="one-time-code" autofocus></label>
                <button type="submit" class="checkout-modal-submit">Verify &amp; Continue to Payment <i class="fas fa-lock"></i></button>
            </form>
        </div>
        <p id="guestCheckoutError" class="form-error" role="alert" hidden></p>
    </div>
</div>
