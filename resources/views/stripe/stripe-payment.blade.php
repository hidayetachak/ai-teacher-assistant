@extends('layouts.schoolDashboard')

@section('title', 'Payment')

@section('page-title', 'Payment')

@section('dashboard-content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://js.stripe.com/v3/"></script>
<style>
    @media (max-width: 767px) {
        #outer-container {
            background: white !important;
        }
        #apply_coupon {
            margin-top: 12px;
        }
    }
    .custom-swal-popup {
        background-color: white !important;
        width: 300px !important;
        height: 300px !important;
    }
    @media (max-width: 768px) {
        .custom-swal-popup {
            width: 90% !important;
        }
    }
    .form-control {
        height: 40px;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: white;
        box-shadow: 0 1px 3px 0 #e6ebf1;
    }
    .form-control:focus {
        border-color: #6772e5;
        box-shadow: 0 1px 3px 0 #cfd7df;
    }
    .text-danger {
        color: #fa755a;
        margin-top: 10px;
    }
</style>

<div id="outer-container">
    <div class="container" id="inner-container">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if (Session::has('success'))
            <?php Session::put('payment_completed', true); ?>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Package activated successfully.',
                        showConfirmButton: false,
                        timer: 2000,
                        customClass: { popup: 'custom-swal-popup' }
                    });
                    setTimeout(function () {
                        window.location.href = "{{ route('school.dashboard') }}";
                    }, 2000);
                });
            </script>
        @endif
        @if (Session::has('error'))
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Failed',
                        text: "{{ session('error') }}",
                        showConfirmButton: false,
                        timer: 3000,
                        customClass: { popup: 'custom-swal-popup' }
                    });
                });
            </script>
        @endif

        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Payment</h2>
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
            <div class="col-md-12">
                @if($package->price == 0)
                    <form action="{{ route('package.free.activate', $package->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                        <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                        <button type="submit" class="btn btn-success">Activate Free Package</button>
                    </form>
                @else
                    <form action="{{ route('stripe.post', ['packageId' => $package->id]) }}" method="post" id="payment-form">
                        @csrf
                        <input type="hidden" name="payment_intent_id" value="{{ $paymentIntentId }}">
                        <input type="hidden" name="package_id" value="{{ $package->id }}">

                        <div class="row pb-0">
                            <div class="col-md-6 pb-2">
                                <div class="form-group">
                                    <label for="name">Name on Card</label>
                                    <input type="text" name="name" id="name" class="form-control"  required>
                                </div>
                            </div>
                            <div class="col-md-6 pb-2">
                                <div class="form-group">
                                    <label for="card-number">Card Number</label>
                                    <div id="card-number" class="form-control"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row pb-0">
                            <div class="col-md-6 pb-2">
                                <div class="form-group">
                                    <label for="card-expiry">Expiration Date</label>
                                    <div id="card-expiry" class="form-control"></div>
                                </div>
                            </div>
                            <div class="col-md-6 pb-2">
                                <div class="form-group">
                                    <label for="card-cvc">CVC</label>
                                    <div id="card-cvc" class="form-control"></div>
                                </div>
                            </div>
                        </div>

                        <div id="card-errors" role="alert" class="text-danger"></div>

                        <div class="row pb-0">
                            <div class="col-md-6 pb-2">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $userEmail) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 pb-2">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <div class="form-control" id="display_price">
                                        £{{ number_format($packagePrice, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <img src="{{ asset('assets/icons/Visa_Brandmark_Blue_RGB_2021.png') }}" 
                                 alt="Visa" style="width:50px; margin-right: 10px;">
                            <img src="{{ asset('assets/icons/mc_symbol.svg') }}" 
                                 alt="Mastercard" style="width:50px; margin-right: 10px;">
                            <button class="btn btn-primary" type="submit">Pay Now</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    const stripe = Stripe('{{ $publicKey }}');
    const elements = stripe.elements();

    const style = {
        base: {
            fontSize: '16px',
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            '::placeholder': {
                color: '#aab7c4',
            },
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a',
        },
    };

    const cardNumber = elements.create('cardNumber', { style: style, placeholder: '' });
    cardNumber.mount('#card-number');

    const cardExpiry = elements.create('cardExpiry', { style: style, placeholder: '' });
    cardExpiry.mount('#card-expiry');

    const cardCvc = elements.create('cardCvc', { style: style, placeholder: '' });
    cardCvc.mount('#card-cvc');

    cardNumber.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
    event.preventDefault();
    
    // Disable the submit button to prevent multiple submissions
    document.querySelector('button[type="submit"]').disabled = true;

    try {
        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: 'card',
            card: cardNumber,
            billing_details: {
                name: document.querySelector('#name').value,
                email: document.querySelector('#email').value,
            },
        });

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
            document.querySelector('button[type="submit"]').disabled = false;
            return;
        }

        // Confirm card payment
        const { paymentIntent, error: confirmError } = await stripe.confirmCardPayment('{{ $clientSecret }}', {
            payment_method: paymentMethod.id,
        });

        if (confirmError) {
            document.getElementById('card-errors').textContent = confirmError.message;
            document.querySelector('button[type="submit"]').disabled = false;
            return;
        }
        
        // If we got here, the payment succeeded
        // Add the payment method ID to the form
        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_method');
        hiddenInput.setAttribute('value', paymentMethod.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    } catch (e) {
        document.getElementById('card-errors').textContent = "An unexpected error occurred. Please try again.";
        document.querySelector('button[type="submit"]').disabled = false;
    }
});

    const packageData = @json($package);
    localStorage.setItem('packageData', JSON.stringify(packageData));
</script>

@endsection