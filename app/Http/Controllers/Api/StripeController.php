<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\EphemeralKey;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

class StripeController extends BaseController
{
    public function createCustomerAndEphemeralKey(Request $request)
    {
        try {
            Stripe::setApiKey(config('arc_config.STRIPE_SECRET_KEY'));

            $customer = Customer::create([
                'description' => 'example customer',
                'email' => 'email@example.com', // Adjust as needed
                'payment_method' => 'pm_card_visa', // Ensure you have this payment method ID
            ]);

            $ephemeralKey = EphemeralKey::create([
                'customer' => $customer->id,
            ], [
                'stripe_version' => config('arc_config.STRIPE_VERSION'),
            ]);

            // Handle successful creation
            return response()->json(['success' => true, 'customer' => $customer, 'ephemeralKey' => $ephemeralKey]);
        } catch (\Exception $e) {
            // Handle errors
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function createPaymentIntent(Request $request)
    {
        $index = $request->all();
        $validator = Validator::make($index, [
            'customer' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'ephemeralKey' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }
        try {
            Stripe::setApiKey(config('arc_config.STRIPE_SECRET_KEY'));

            // Assuming you have the customer ID and ephemeral key available
            $customerId = $request->input('customer'); // Or retrieve from database
            $currency = $request->input('currency'); // Or retrieve from session
            $amount = $request->input('amount');
            $ephemeralKey = $request->input('ephemeralKey');

            $paymentIntent = PaymentIntent::create([
                'amount' => (float)$amount  * 100,
                'currency' => $currency,
                'customer' => $customerId,
                // 'payment_method' => 'pm_card_visa'
                'automatic_payment_methods' => ['enabled' => 'true']
            ]);

            return response()->json([
                'paymentIntent' => $paymentIntent->client_secret,
                'ephemeralKey' => $ephemeralKey,
                'customer' => $customerId,
                'publishableKey' => config('arc_config.STRIPE_PUBLISABLE_KEY'),
            ]);
        } catch (\Exception $e) {
             logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            // Handle errors
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function createStripeToken(Request $request)
    {
        $index = $request->all();
        $validator = Validator::make($index, [
            'number' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvc' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        try {
            Stripe::setApiKey(config('arc_config.STRIPE_SECRET_KEY'));

            // Create a Stripe token with hardcoded card details
            $token = \Stripe\Token::create([
                'card' => [
                    'number' => $request->number,
                    'exp_month' => $request->number,
                    'exp_year' => $request->number,
                    'cvc' => $request->number
                ],
            ]);

            $data['token'] = $token->id;
            if (isset($token) && !empty($token)) {
                return $this->apiResponseJson(true, 200, "Token created successfully.", $data);
            } else {
                return $this->apiResponseJson(false, 200, "Failed!", '');
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->apiResponseJson(false, 500, config('custom.MSG_ERROR_TRY_AGAIN'), '');
        }
    }

    public function makeStripePaymet(Request $request)
    {
        $index = $request->all();
        $validator = Validator::make($index, [
            'amount' => 'required',
            'currency' => 'required',
            'source' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        try {
            $stripe = new StripeClient(config('arc_config.STRIPE_SECRET_KEY'));

            // Create a charge
            $charge = $stripe->charges->create([
                'amount' => (float)$request->amount * 100,
                'currency' => $request->currency,
                'source' => $request->source,
                // 'description' => auth()->user()->name . ' ' . auth()->user()->email,
                'description' => $request->description,
            ]);

            $data['charge'] = $charge;
            if (isset($charge) && !empty($charge)) {
                return $this->apiResponseJson(true, 200, "Payment successfully.", $data);
            } else {
                return $this->apiResponseJson(false, 200, "Failed!", '');
            }
        } catch (\Exception $e) {
             logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            // Handle errors
            return $this->apiResponseJson(false, 500, config('custom.MSG_ERROR_TRY_AGAIN'), '');
        }
    }
}
