<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use Stripe;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Stripe\Stripe;
use Stripe\Charge;
use App\Models\payment;

use App\Mail\PaymentSuccessful;
use Illuminate\Support\Facades\Mail;


class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(): View
    {
        return view('stripe');
    }
      
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request): RedirectResponse
    {
        // Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
      
        // Stripe\Charge::create ([
        //         "amount" => 10 * 100,
        //         "currency" => "usd",
        //         "source" => $request->stripeToken,
        //         "description" => "Test payment from Stripe." 
        // ]);
                
        // return back()->with('success', 'Payment successful!');

        Stripe::setApiKey(env('STRIPE_SECRET'));


                try {
                    $charge = Charge::create([
                        "amount" => 10 * 100,
                        "currency" => "usd",
                        "source" => $request->stripeToken,
                        "description" => "Test payment from Stripe."
                    ]);
            
                    // Save payment info to database
                   // dd($charge);
                    // payment::create([
                    //     'stripe_payment_id' => $charge->id,
                    //     'amount' => $charge->amount,
                    //     'currency' => $charge->currency,
                    //     'status' => $charge->status,
                    //     'description' => $charge->description,
                    // ]);

                    $payment = new payment();
                    $payment->stripe_payment_id = $charge->id;
                    $payment->amount = $charge->amount;
                    $payment->currency = $charge->currency;
                    $payment->status = $charge->status;
                    $payment->description = $charge->description;
                    $payment->payment_raw = json_encode($charge);
                    $payment->save();


                    // Send mail to user
                    //Mail::to($request->user()->email)->send(new PaymentSuccessful($payment));
                    try{
                        Mail::to('ravi.bhushan@infoicon.in')->send(new PaymentSuccessful($payment));
                    } catch (\Exception $e) {
                        \Log::error('Mail failed: ' . $e->getMessage());
                        return back()->with('error', 'Payment saved, but email sending failed.');
                    }
            
                    return back()->with('success', 'Payment successful!');
                } catch (\Exception $e) {
                    return back()->with('error', 'Error: ' . $e->getMessage());
                }
                
    }

}
