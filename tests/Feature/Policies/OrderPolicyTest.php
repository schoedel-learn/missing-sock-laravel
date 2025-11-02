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
    protected User $user;
    protected Order $order;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->policy = new OrderPolicy();
        $this->user = User::factory()->create();
        $this->order = Order::factory()->create();
    }

    public function test_user_can_view_any_orders(): void
    {
        $result = $this->policy->viewAny($this->user);

        $this->assertTrue($result);
    }

    public function test_user_can_view_order(): void
    {
        $result = $this->policy->view($this->user, $this->order);

        $this->assertTrue($result);
    }

    public function test_user_cannot_create_order(): void
    {
        $result = $this->policy->create($this->user);

        $this->assertFalse($result);
    }

    public function test_user_cannot_update_order(): void
    {
        $result = $this->policy->update($this->user, $this->order);

        $this->assertFalse($result);
    }

    public function test_user_cannot_delete_order(): void
    {
        $result = $this->policy->delete($this->user, $this->order);

        $this->assertFalse($result);
    }
}

