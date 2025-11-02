<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowRegistrationRequest;
use App\Models\Registration;

class PreOrderController extends Controller
{
    /**
     * Redirect to Filament pre-order wizard
     */
    public function start()
    {
        // Redirect to Filament wizard page
        return redirect('/admin/pre-order-wizard');
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
}

