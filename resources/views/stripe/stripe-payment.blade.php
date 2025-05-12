@extends('layouts.schoolDashboard')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('dashboard-content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://js.stripe.com/v3/"></script>
<style>
     @media (max-width: 767px) {
   
   #outer-container{
       Background: white !important;
      
      
   }
   #apply_coupon{
    margin-top:12px;
   }
}
        .custom-swal-popup {
            background-color: white !important;
            width: 300px !important;
            height: 300px !important;
        }

@media (max-width: 768px) {
    .custom-swal-popup {
        width: 90% !important; /* Make width relevant for mobile */
    }
}


</style>

<div id="outer-container">
  
    <div class="container" id="inner-container">

        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        @if (Session::has('success'))
        <?php
        Session::put('payment_completed', true);
        ?>
                <script>
                document.addEventListener("DOMContentLoaded", function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Package activated successfully.',
                        showConfirmButton: false,
                        timer: 2000,
                        customClass: {
                            popup: 'custom-swal-popup'
                        }
                    });

                    // Redirect after SweetAlert closes
                    setTimeout(function () {
                        window.location.href = "";
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
                    customClass: {
                        popup: 'custom-swal-popup'
                    }
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
                <input type="hidden" name="package_id" value="{{ $package->id }}">

                <div class="row pb-0">
                    <div class="col-md-6 pb-2">
                        <div class="form-group ">
                            <label for="name">Name on Card</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="" required>
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
                            <input type="email" name="email" id="email" class="form-control" placeholder="" value="{{$userEmail}}" required>
                        </div>
                    </div>

                    <div class="col-md-6 pb-2">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <div class="form-control" id="display_price">
                            ${{$packagePrice}}
                            </div>
                            <!-- Hidden fields for coupon information -->
                            <input type="hidden" name="coupon_applied" id="coupon_applied" value="false">
                            <input type="hidden" name="coupon_code_input" id="coupon_code_input" value="">
                            <input type="hidden" name="coupon_discount" id="coupon_discount" value="0">
                            <input type="hidden" name="final_price" id="final_price" value="{{$packagePrice}}">
                        </div>
                    </div>
                </div>
    

                <p id="coupon_message" class="text-success"></p>

                <div class="d-flex justify-content-end align-items-center mt-3">
                    <img src="{{ asset('assets/icons/Visa_Brandmark_Blue_RGB_2021.png') }}" 
                        alt="Mastercard" style="width:50px; margin-right: 10px;">
                    <img src="{{ asset('assets/icons/mc_symbol.svg') }}" 
                        alt="Visa" style="width:50px; margin-right: 10px;">
                    <button class="btn btn-primary" type="submit">Pay Now</button>
                </div>


            </form>
            @endif
        </div>
    </div>


    </div>
</div>
<script>
  document.getElementById('apply_coupon').addEventListener('click', function () {
    let couponCode = document.getElementById('coupon_code').value;
    
    // Show a loading message
    document.getElementById('coupon_message').innerHTML = '<span class="text-info">Processing...</span>';

    fetch("", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ coupon_code: couponCode })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Coupon response:', data); // Debug: log the response data
        
        if (data.success) {
            let originalPrice = {{$packagePrice}};
            
            let discountAmount = 0;
            let finalPrice = originalPrice;
            
            if (data.type === 'percentage') {
                discountAmount = (originalPrice * data.discount / 100);
                finalPrice = (originalPrice - discountAmount).toFixed(2);
            } else {
                discountAmount = parseFloat(data.discount);
                finalPrice = (originalPrice - discountAmount).toFixed(2);
                if (finalPrice < 0) finalPrice = 0;
            }
            
         

       
            if (document.getElementById('display_price')) {
                document.getElementById('display_price').innerHTML = '£' + finalPrice;
            } else {
                console.error('display_price element not found!');
            }
            
            document.getElementById('coupon_applied').value = 'true';
            document.getElementById('coupon_code_input').value = couponCode;
            document.getElementById('coupon_discount').value = discountAmount;
            document.getElementById('final_price').value = finalPrice;
            
            let discountText = data.type === 'percentage' ? `${data.discount}%` : `£${data.discount}`;
            document.getElementById('coupon_message').innerHTML = `Coupon Applied!`;
        } else {
            document.getElementById('coupon_message').innerHTML = `<span class="text-danger">${data.message}</span>`;
        }
    })
    .catch(error => {
      
        document.getElementById('coupon_message').innerHTML = '<span class="text-danger">Error processing coupon. Check console for details.</span>';
    });
});
</script>


<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
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

    // Create individual Stripe elements
    const cardNumber = elements.create('cardNumber', { 
    style: style, 
    placeholder: '' 
    });
    cardNumber.mount('#card-number');

    const cardExpiry = elements.create('cardExpiry', { 
        style: style, 
        placeholder: '' 
    });
    cardExpiry.mount('#card-expiry');

    const cardCvc = elements.create('cardCvc', { 
        style: style, 
        placeholder: '' 
    });
    cardCvc.mount('#card-cvc');


    const form = document.getElementById('payment-form');
    
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const { token, error } = await stripe.createToken(cardNumber);

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
        } else {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    });

    const packageData = @json($package);
    localStorage.setItem('packageData', JSON.stringify(packageData));
</script>

@endsection
