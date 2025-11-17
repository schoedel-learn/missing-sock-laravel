<?php

namespace Tests\Feature\Policies;

use App\Models\Payment;
use App\Models\Registration;
use App\Models\User;
use App\Policies\PaymentPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected PaymentPolicy $policy;
    protected User $admin;
    protected User $parent;
    protected User $coordinator;
    protected Payment $payment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new PaymentPolicy();
        $this->admin = User::factory()->admin()->create();
        $this->parent = User::factory()->create();
        $registration = Registration::factory()->for($this->parent)->create([
            'user_id' => $this->parent->id,
        ]);
        $this->payment = Payment::factory()
            ->for($this->parent)
            ->for($registration)
            ->create([
                'user_id' => $this->parent->id,
                'registration_id' => $registration->id,
            ]);
        $this->coordinator = User::factory()->organizationCoordinator()->create();
        $registration->school->coordinators()->attach($this->coordinator->id);
    }

    public function test_admin_can_view_any_payments(): void
    {
        $this->assertTrue($this->policy->viewAny($this->admin));
    }

    public function test_parent_can_view_their_payment(): void
    {
        $this->assertTrue($this->policy->view($this->parent, $this->payment));
    }

    public function test_guest_cannot_view_payment(): void
    {
        $this->assertFalse($this->policy->view(null, $this->payment));
    }

    public function test_coordinator_can_view_payment_for_their_organization(): void
    {
        $this->assertTrue($this->policy->view($this->coordinator, $this->payment));
    }

    public function test_coordinator_cannot_view_other_organization_payment(): void
    {
        $otherPayment = Payment::factory()->create();

        $this->assertFalse($this->policy->view($this->coordinator, $otherPayment));
    }
}
