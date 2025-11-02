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
    protected User $user;
    protected Registration $registration;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->policy = new RegistrationPolicy();
        $this->user = User::factory()->create();
        $this->registration = Registration::factory()->create();
    }

    public function test_user_can_view_any_registrations(): void
    {
        $result = $this->policy->viewAny($this->user);

        $this->assertTrue($result);
    }

    public function test_user_can_view_registration(): void
    {
        $result = $this->policy->view($this->user, $this->registration);

        $this->assertTrue($result);
    }

    public function test_user_can_create_registration(): void
    {
        $result = $this->policy->create($this->user);

        $this->assertTrue($result);
    }

    public function test_user_cannot_update_registration(): void
    {
        $result = $this->policy->update($this->user, $this->registration);

        $this->assertFalse($result);
    }

    public function test_user_cannot_delete_registration(): void
    {
        $result = $this->policy->delete($this->user, $this->registration);

        $this->assertFalse($result);
    }
}

