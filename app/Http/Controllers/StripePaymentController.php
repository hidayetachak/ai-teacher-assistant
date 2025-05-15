<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Charge;
use Stripe\SetupIntent;
use Stripe\Customer;
use App\Models\Package;
use App\Models\PaymentRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

class StripePaymentController extends Controller
{
    public function activateFreePackage(Request $request, $packageId)
{
    $validated = $request->validate([
        'email' => 'required|email',
        'name' => 'required|string',
    ]);

    $user = auth()->user();
    $package = Package::findOrFail($packageId);

    if ($package->price > 0) {
        return redirect()->back()->with('error', 'This package is not free.');
    }
    $alreadySubscribed = PaymentRecord::where('user_id', $user->id)
        ->where('package_id', $package->id)
        ->where('amount', 0) 
        ->exists();

    if ($alreadySubscribed) {
        return redirect()->back()->with('error', 'You have already used this free package.');
    }
    $paymentRecord = PaymentRecord::create([
        'user_id' => $user->id,
        'package_id' => $package->id,
        'payment_method' => 'free',
        'amount' => 0,
        'original_amount' => $package->price,
        'email' => $request->email,
        'name' => $request->name,
        'stripe_payment_id' => 'free-' . uniqid(),
        'stripe_customer_id' => null,
        'package_duration' => $package->duration,
        'credits' => $package->credits,
    ]); 
    $user->increment('credits', $package->credits);

    Session::flash('success', 'Free package activated successfully.');
    Session::put('payment_id', $paymentRecord->id);


    return redirect()->back();
}
public function stripe($packageId)
{
    Stripe::setApiKey(env('STRIPE_SECRET'));

    $package = Package::findOrFail($packageId);
    $user = auth()->user();
    if ($package->price == 0) {
        // Optionally, you can handle free package activation here
        $alreadySubscribed = PaymentRecord::where('user_id', $user->id)
            ->where('package_id', $package->id)
            ->where('amount', 0)
            ->exists();

        if ($alreadySubscribed) {
            return redirect()->back()->with('error', 'You have already used this free package.');
        }

        // Create payment record for free package
        $paymentRecord = PaymentRecord::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'payment_method' => 'free',
            'amount' => 0,
            'original_amount' => $package->price,
            'email' => $user->email,
            'name' => $user->name,
            'stripe_payment_id' => 'free-' . uniqid(),
            'stripe_customer_id' => null,
            'package_duration' => $package->duration,
            'credits' => $package->credits,
        ]);

        $user->increment('credits', $package->credits);

        \Session::flash('success', 'Free package activated successfully.');
        \Session::put('payment_id', $paymentRecord->id);

        return redirect()->back();
    }
    // Ensure customer exists
    if (!$user->stripe_customer_id) {
        $customer = Customer::create([
            'email' => $user->email,
            'name' => $user->name,
        ]);
        $user->stripe_customer_id = $customer->id;
        $user->save();
    }

    $paymentIntent = PaymentIntent::create([
        'amount' => round($package->price * 100),
        'currency' => 'usd',
        'payment_method_types' => ['card'],
        'customer' => $user->stripe_customer_id,
        'setup_future_usage' => 'off_session', // ensures the card can be reused later
        'metadata' => [
            'user_id' => $user->id,
            'package_id' => $package->id,
            'package_name' => $package->name,
        ],
    ]);

    \Session::put('package_duration', $package->duration);

    return view('stripe.stripe-payment', [
        'clientSecret' => $paymentIntent->client_secret,
        'package' => $package,
        'packagePrice' => $package->price,
        'userEmail' => $user->email,
        'publicKey' => env('STRIPE_PUBLIC_KEY'),
        'paymentIntentId' => $paymentIntent->id,
    ]);
}


public function stripePost(Request $request, $packageId)
{
    $validated = $request->validate([
        'email' => 'required|email',
        'name' => 'required|string',
        'payment_method' => 'required|string',
        'payment_intent_id' => 'required|string',
    ]);

    try {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $package = Package::findOrFail($packageId);
        $user = auth()->user();
        $finalPrice = $package->price;
        $credits = $package->credits;
        $duration = $package->duration;

        // Retrieve or create customer
        if (!$user->stripe_customer_id) {
            $customer = Customer::create([
                'email' => $request->email,
                'name' => $request->name,
            ]);
            $user->stripe_customer_id = $customer->id;
            $user->save();
        } else {
            $customer = Customer::retrieve($user->stripe_customer_id);
        }

        // Attach the payment method to the customer
        \Stripe\PaymentMethod::retrieve($request->payment_method)->attach([
            'customer' => $user->stripe_customer_id,
        ]);

        // Set as default payment method
        \Stripe\Customer::update($user->stripe_customer_id, [
            'invoice_settings' => [
                'default_payment_method' => $request->payment_method,
            ],
        ]);

        // Retrieve the confirmed payment intent
        $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

        if ($paymentIntent->status === 'succeeded') {
            // Create payment record
            $paymentRecord = PaymentRecord::create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'payment_method' => 'stripe',
                'amount' => $finalPrice,
                'original_amount' => $finalPrice,
                'email' => $request->email,
                'name' => $request->name,
                'stripe_payment_id' => $paymentIntent->id,
                'stripe_customer_id' => $user->stripe_customer_id,
                'package_duration' => $duration,
                'credits' => $credits,
            ]);

            $user->increment('credits', $credits);

            \Session::flash('success', 'Your payment was successful.');
            \Session::put('payment_id', $paymentRecord->id);

            return redirect()->back();
        } else {
            throw new \Exception('PaymentIntent did not succeed: ' . $paymentIntent->status);
        }

    } catch (\Exception $e) {
        \Log::error('Payment processing error: ' . $e->getMessage());
        \Session::flash('error', 'Payment processing error. Please try again.');
        return redirect()->back()->withInput();
    }
}


    private function getCardErrorMessage($declineCode, $defaultMessage)
    {
        $messages = [
            'card_declined' => 'Your card was declined. Please try a different card.',
            'insufficient_funds' => 'Your card has insufficient funds. Please use a different card.',
            'authentication_required' => 'Your card requires authentication. Please try again.',
            'expired_card' => 'Your card has expired. Please use a different card.',
            'incorrect_cvc' => 'The card’s security code is incorrect. Please check and try again.',
            'invalid_card_number' => 'The card number is invalid. Please check and try again.',
        ];

        return $messages[$declineCode] ?? $defaultMessage;
    }
    
    

 
     

    public function stripeRenew(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentRecord = PaymentRecord::where('advert_id', $request->advert_id)
                                    ->where('user_id', auth()->user()->id)
                                    

                                    ->first();

        if ($paymentRecord) {
            $package = Package::find($paymentRecord->package_id);
            
            if ($package) {
                try {
                    $user = auth()->user();
                    $customer = \Stripe\Customer::retrieve($user->stripe_customer_id);

                    if (!$customer->default_source) {
                        Session::flash('error', 'No default payment method found for the customer.');
                        return back();
                    }

                    $paymentIntent = \Stripe\PaymentIntent::create([
                        'amount' => $package->price * 100,
                        'currency' => 'gbp',
                        'customer' => $customer->id,
                        'payment_method' => $customer->default_source,
                        'off_session' => true,
                        'confirm' => true,
                    ]);
                    if ($paymentIntent->status == 'succeeded') {
                        $paymentRecord = PaymentRecord::create([
                            'user_id' => $user->id,
                            'package_id' => $package->id,
                            'payment_method' => 'stripe',
                            'amount' => $paymentIntent->amount_received / 100,
                            'email' => $user->email,
                            'name' => $user->name,
                            'stripe_payment_id' => $paymentIntent->id,
                            'stripe_customer_id' => $customer->id,
                            'advert_id' => $request->advert_id,
                        ]);
                    $packageDuration = (int) $package->duration;
                    $newExpiryDate = now()->addDays($packageDuration);
                    // Advert::where('advert_id', $request->advert_id)->update([
                    //     'expiry_date' => $newExpiryDate,
                    //     'status' => 'active',
                    // ]);
                    $advert = Advert::where('advert_id', $request->advert_id)->first();
                    $advert->update([
                        'expiry_date' => $newExpiryDate,
                        'status' => 'active',
                        'subscription'=>true,
                    ]);
                       
                        Mail::to($user->email)->send(new StripeRenewMail(
                            $advert->name, 
                            $newExpiryDate, 
                            $paymentIntent->amount_received / 100, 
                            $package->title
                        ));
                        Session::flash('success', 'Payment successful!');
                        return redirect()->route('some.route');
                    } else {
                        Session::flash('error', 'Payment failed. Please try again.');
                        return back();
                    }

                } catch (\Exception $e) {
                    Session::flash('error', 'An error occurred: ' . $e->getMessage());
                    return back();
                }
            }
        }
        Session::flash('error', 'Payment record not found!');
        return back();
    }
    public function autoRenewPayment(Request $request)
    {
        $advertId = $request->advert_id;
        $paymentRecord = PaymentRecord::where('advert_id', $advertId)
            ->where('user_id', auth()->user()->id)
            ->first();
        if ($paymentRecord) {
            $package = Package::where('id', $paymentRecord->package_id)
                ->where('recovery_payment', 'yes') 
                ->first();

            if ($package) {
                return $this->stripeRenew($request);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Recovery payment not enabled or payment record/package not found.',
        ]);
    }
    public function cancelSubscription(Request $request)
    {
        $advertId = $request->input('advert_id');

        $advert = Advert::where('advert_id', $advertId)
                        ->where('user_id', auth()->id())
                        ->first();
        if ($advert) {
            $advert->update([
                'status' => 'inactive',
                'expiry_date' => Carbon::now()->subDays(365),
                'subscription'=>false,
            ]);
            Mail::to(auth()->user()->email)->send(new SubscriptionCancelMail(
                $advert->name,
                now() // cancellation date
            ));
            return redirect()->back();
        }

        return response()->json([
            'success' => false,
            'message' => 'Advert not found or you do not have permission to cancel it.',
        ]);
    }



}