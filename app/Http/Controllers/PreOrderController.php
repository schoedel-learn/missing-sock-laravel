<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowRegistrationRequest;
use App\Models\Registration;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PreOrderController extends Controller
{
    /**
     * Display the public pre-order wizard form
     */
    public function start()
    {
        return view('pre-order.wizard');
    }
    
    /**
     * Display success page after order completion
     */
    public function success()
    {
        return view('pre-order.success');
    }
    
    /**
     * Display order confirmation
     */
    public function confirmation(ShowRegistrationRequest $request, Registration $registration)
    {
        // Optimize eager loading to prevent N+1 queries
        $registration->load([
            'school',
            'project',
            'children',
            'orders.addOns',
            'orders.child',
            'orders.mainPackage',
            'orders.secondPackage',
            'orders.thirdPackage',
            'orders.siblingPackage',
            'payments',
            'timeSlotBooking.timeSlot'
        ]);

        return view('pre-order.confirmation', [
            'registration' => $registration
        ]);
    }

    /**
     * Handle successful Stripe payment
     */
    public function paymentSuccess(Request $request, Order $order)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('pre-order.start')
                ->with('error', 'Invalid payment session.');
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = Session::retrieve($sessionId);

            // Verify session matches order
            if ($session->metadata->order_id != $order->id) {
                return redirect()->route('pre-order.start')
                    ->with('error', 'Payment session mismatch.');
            }

            // Get or create user
            $user = User::find($session->metadata->user_id);
            if (!$user) {
                return redirect()->route('pre-order.start')
                    ->with('error', 'User not found.');
            }

            // Create payment record
            $payment = Payment::create([
                'user_id' => $user->id,
                'registration_id' => $order->registration_id,
                'order_id' => $order->id,
                'stripe_payment_intent_id' => $session->payment_intent,
                'stripe_customer_id' => $session->customer ?? null,
                'amount_cents' => $order->total_cents,
                'currency' => 'usd',
                'status' => 'succeeded',
                'paid_at' => now(),
            ]);

            // Update order status (if you have a status field)
            // $order->update(['status' => 'paid']);

            // Update registration status
            $registration = $order->registration;
            $registration->update(['status' => 'confirmed']);

            return redirect()->route('pre-order.confirmation', ['registration' => $registration->registration_number])
                ->with('success', 'Payment successful! Your order has been confirmed.');
        } catch (\Exception $e) {
            Log::error('Payment success error: ' . $e->getMessage());
            return redirect()->route('pre-order.start')
                ->with('error', 'Error processing payment. Please contact support.');
        }
    }

    /**
     * Handle cancelled Stripe payment
     */
    public function paymentCancel(Order $order)
    {
        // Order remains in pending state
        // User can retry payment later
        
        return redirect()->route('pre-order.confirmation', ['registration' => $order->registration->registration_number])
            ->with('info', 'Payment was cancelled. You can complete payment later from your account.');
    }
}

