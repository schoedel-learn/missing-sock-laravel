<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_generates_unique_order_number(): void
    {
        $order1 = Order::factory()->create();
        $order2 = Order::factory()->create();

        $this->assertNotEquals($order1->order_number, $order2->order_number);
        $this->assertStringStartsWith('ORD', $order1->order_number);
        $this->assertStringStartsWith('ORD', $order2->order_number);
    }

    public function test_order_number_format_is_correct(): void
    {
        $order = Order::factory()->create();

        $this->assertMatchesRegularExpression('/^ORD-\d{4}-\d{6}$/', $order->order_number);
    }

    public function test_calculates_total_in_dollars(): void
    {
        $order = Order::factory()->create([
            'total_cents' => 4999,
        ]);

        $this->assertEquals(49.99, $order->total);
    }

    public function test_formats_total_as_currency(): void
    {
        $order = Order::factory()->create([
            'total_cents' => 12345,
        ]);

        $this->assertEquals('$123.45', $order->formatted_total);
    }

    public function test_casts_boolean_upgrade_fields(): void
    {
        $order = Order::factory()->create([
            'four_poses_upgrade' => true,
            'pose_perfection' => false,
            'premium_retouch' => true,
        ]);

        $this->assertIsBool($order->four_poses_upgrade);
        $this->assertIsBool($order->pose_perfection);
        $this->assertIsBool($order->premium_retouch);
        
        $this->assertTrue($order->four_poses_upgrade);
        $this->assertFalse($order->pose_perfection);
        $this->assertTrue($order->premium_retouch);
    }

    public function test_casts_price_fields_to_integers(): void
    {
        $order = Order::factory()->create([
            'main_package_price_cents' => '4999',
            'subtotal_cents' => '5999',
            'total_cents' => '5499',
        ]);

        $this->assertIsInt($order->main_package_price_cents);
        $this->assertIsInt($order->subtotal_cents);
        $this->assertIsInt($order->total_cents);
    }
}

