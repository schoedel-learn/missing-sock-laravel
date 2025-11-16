@extends('layouts.app')

@section('title', 'Pre-Order Registration - The Missing Sock Photography')
@section('description', 'Register and pre-pay for your child\'s school picture day')

@section('content')
<div class="min-h-screen bg-background-main py-12">
    <div class="container-custom">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Pre-Order Registration</h1>
                <p class="text-gray-600">Complete your registration for school picture day</p>
            </div>

            <!-- Wizard Component -->
            @livewire('pre-order-wizard')
        </div>
    </div>
</div>
@endsection

