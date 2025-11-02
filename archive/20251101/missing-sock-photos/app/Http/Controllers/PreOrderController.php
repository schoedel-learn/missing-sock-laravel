<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

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
    public function confirmation(Registration $registration)
    {
        return view('pre-order.confirmation', [
            'registration' => $registration->load(['school', 'project', 'children', 'orders'])
        ]);
    }
}

