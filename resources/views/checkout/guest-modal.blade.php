<div class="checkout-modal" id="checkoutModal" hidden>
    <div class="checkout-modal-backdrop" data-close-checkout></div>
    <div class="checkout-modal-card" role="dialog" aria-modal="true" aria-labelledby="checkoutModalTitle">
        <button type="button" class="checkout-modal-close" aria-label="Close" data-close-checkout><i class="fas fa-times"></i></button>
        <h2 id="checkoutModalTitle">Sign in to buy</h2>
        <p class="checkout-modal-note">Create an account, verify your email, and add your delivery address before buying.</p>
        <input type="hidden" id="checkoutProductId">
        <input type="hidden" id="checkoutQuantity" value="1">
        <a class="btn btn-primary" href="{{ route('register') }}">Create Account</a>
        <a class="btn btn-secondary" href="{{ route('login') }}">Sign In</a>
    </div>
</div>
