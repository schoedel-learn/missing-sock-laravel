<?php

namespace Tests\Feature\Policies;

use App\Models\Registration;
use App\Models\User;
use App\Policies\RegistrationPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected RegistrationPolicy $policy;
    protected User $admin;
    protected User $parent;
    protected User $randomUser;
    protected User $coordinator;
    protected Registration $registration;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->policy = new RegistrationPolicy();
        $this->admin = User::factory()->admin()->create();
        $this->parent = User::factory()->create();
        $this->randomUser = User::factory()->create();
        $this->registration = Registration::factory()->for($this->parent)->create([
            'user_id' => $this->parent->id,
        ]);
        $this->coordinator = User::factory()->organizationCoordinator()->create();
        $this->registration->school->coordinators()->attach($this->coordinator->id);
    }

    public function test_admin_can_view_any_registrations(): void
    {
        $result = $this->policy->viewAny($this->admin);

        $this->assertTrue($result);
    }

    public function test_parent_can_view_their_registration(): void
    {
        $result = $this->policy->view($this->parent, $this->registration);

        $this->assertTrue($result);
    }

    public function test_guest_cannot_view_registration(): void
    {
        $result = $this->policy->view(null, $this->registration);

        $this->assertFalse($result);
    }

    public function test_user_can_create_registration(): void
    {
        $result = $this->policy->create($this->parent);

        $this->assertTrue($result);
    }

    public function test_user_cannot_update_registration(): void
    {
        $result = $this->policy->update($this->randomUser, $this->registration);

        $this->assertFalse($result);
    }

    public function test_user_cannot_delete_registration(): void
    {
        $result = $this->policy->delete($this->randomUser, $this->registration);

        $this->assertFalse($result);
    }

    public function test_coordinator_can_view_registration_for_their_organization(): void
    {
        $this->assertTrue($this->policy->view($this->coordinator, $this->registration));
    }

    public function test_coordinator_cannot_view_other_organization_registration(): void
    {
        $otherRegistration = Registration::factory()->create();

        $this->assertFalse($this->policy->view($this->coordinator, $otherRegistration));
    }
}
