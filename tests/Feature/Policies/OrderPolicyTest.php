<?php

namespace Tests\Feature\Policies;

use App\Models\Order;
use App\Models\User;
use App\Policies\OrderPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected OrderPolicy $policy;
    protected User $admin;
    protected User $parent;
    protected User $randomUser;
    protected User $coordinator;
    protected Order $order;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->policy = new OrderPolicy();
        $this->admin = User::factory()->admin()->create();
        $this->parent = User::factory()->create();
        $this->randomUser = User::factory()->create();
        $this->order = Order::factory()->for($this->parent)->create([
            'user_id' => $this->parent->id,
        ]);
        $this->coordinator = User::factory()->organizationCoordinator()->create();
        $this->order->registration->school->coordinators()->attach($this->coordinator->id);
    }

    public function test_admin_can_view_any_orders(): void
    {
        $result = $this->policy->viewAny($this->admin);

        $this->assertTrue($result);
    }

    public function test_parent_can_view_their_order(): void
    {
        $result = $this->policy->view($this->parent, $this->order);

        $this->assertTrue($result);
    }

    public function test_guest_cannot_view_order(): void
    {
        $result = $this->policy->view(null, $this->order);

        $this->assertFalse($result);
    }

    public function test_user_cannot_create_order(): void
    {
        $result = $this->policy->create($this->randomUser);

        $this->assertFalse($result);
    }

    public function test_user_cannot_update_order(): void
    {
        $result = $this->policy->update($this->randomUser, $this->order);

        $this->assertFalse($result);
    }

    public function test_user_cannot_delete_order(): void
    {
        $result = $this->policy->delete($this->randomUser, $this->order);

        $this->assertFalse($result);
    }

    public function test_coordinator_can_view_order_for_their_organization(): void
    {
        $this->assertTrue($this->policy->view($this->coordinator, $this->order));
    }

    public function test_coordinator_cannot_view_other_organization_order(): void
    {
        $otherOrder = Order::factory()->create();

        $this->assertFalse($this->policy->view($this->coordinator, $otherOrder));
    }
}
