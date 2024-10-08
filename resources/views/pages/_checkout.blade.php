@extends('layouts.app', [
'class' => '',
'elementActive' => 'home'
])

@section('content')
<style>
    #card-element {
    background-color: #f7f7f7;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    max-width: 400px;
    margin-bottom: 20px;
}

#card-errors {
    color: red;
    margin-top: 10px;
}

</style>
<h1>Goducate Payment Checkout</h1>

    @if (session('success_message'))
        <div>{{ session('success_message') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="post" id="payment-form">
        @csrf
        <input type="hidden" class="form-control" name="email" id="email">
        <input type="text" class="form-control" name="amount" required>

        <div>
            <label for="card-element">Credit or debit card</label>
            <div id="card-element">
                <!-- Stripe Element will be inserted here -->
            </div>
            <div id="card-errors" role="alert"></div>
        </div>

        <button type="submit" class="btn btn-primary">Submit Payment</button>
    </form>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>

<script>
    const parsedUrl = new URL(window.location.href);

    const path = parsedUrl.pathname;

    const segments = path.split('/');

    const email = segments[segments.length - 1];
    $('#email').val(email);

    var stripe = Stripe('{{ env('STRIPE_KEY') }}');

    var elements = stripe.elements();
    var card = elements.create('card');
    card.mount('#card-element');

    card.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                stripeTokenHandler(result.token);
            }
        });
    });

    function stripeTokenHandler(token) {
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }
</script>
@endpush
