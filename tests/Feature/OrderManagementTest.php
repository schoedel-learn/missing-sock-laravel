<?php

namespace Tests\Feature;

use App\Models\AddOn;
use App\Models\Child;
use App\Models\Order;
use App\Models\Package;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Registration $registration;
    protected Package $package;
    protected Child $child;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create();
        $this->registration = Registration::factory()->create();
        $this->child = Child::factory()->create([
            'registration_id' => $this->registration->id,
        ]);
        $this->package = Package::factory()->create([
            'name' => 'Standard Package',
            'price_cents' => 4999, // $49.99
        ]);
    }

    public function test_can_create_order(): void
    {
        $orderData = [
            'registration_id' => $this->registration->id,
            'child_id' => $this->child->id,
            'main_package_id' => $this->package->id,
            'main_package_price_cents' => 4999,
            'subtotal_cents' => 4999,
            'shipping_cents' => 0,
            'discount_cents' => 0,
            'total_cents' => 4999,
            'four_poses_upgrade' => false,
            'pose_perfection' => false,
            'premium_retouch' => false,
            'four_poses_upgrade_price_cents' => 0,
            'pose_perfection_price_cents' => 0,
            'premium_retouch_price_cents' => 0,
            'class_picture_price_cents' => 0,
            'sibling_special_fee_cents' => 0,
        ];

        $order = Order::create($orderData);

        $this->assertDatabaseHas('orders', [
            'registration_id' => $this->registration->id,
            'total_cents' => 4999,
        ]);

        $this->assertNotNull($order->order_number);
        $this->assertStringStartsWith('ORD', $order->order_number);
    }

    public function test_order_number_is_auto_generated(): void
    {
        $order = Order::factory()->create();

        $this->assertNotNull($order->order_number);
        $this->assertMatchesRegularExpression('/^ORD-\d{4}-\d{6}$/', $order->order_number);
    }

    public function test_order_belongs_to_registration(): void
    {
        $order = Order::factory()->create([
            'registration_id' => $this->registration->id,
        ]);

        $this->assertEquals($this->registration->id, $order->registration->id);
    }

    public function test_order_has_main_package_relationship(): void
    {
        $order = Order::factory()->create([
            'main_package_id' => $this->package->id,
        ]);

        $this->assertEquals($this->package->id, $order->mainPackage->id);
        $this->assertEquals('Standard Package', $order->mainPackage->name);
    }

    public function test_order_can_have_multiple_packages(): void
    {
        $package2 = Package::factory()->create(['name' => 'Premium Package']);
        $package3 = Package::factory()->create(['name' => 'Deluxe Package']);

        $order = Order::factory()->create([
            'main_package_id' => $this->package->id,
            'second_package_id' => $package2->id,
            'third_package_id' => $package3->id,
        ]);

        $this->assertNotNull($order->mainPackage);
        $this->assertNotNull($order->secondPackage);
        $this->assertNotNull($order->thirdPackage);
    }

    public function test_order_calculates_total_correctly(): void
    {
        $order = Order::factory()->create([
            'main_package_price_cents' => 4999,
            'shipping_cents' => 500,
            'discount_cents' => 1000,
            'subtotal_cents' => 4999,
            'total_cents' => 4499, // 4999 + 500 - 1000
        ]);

        $this->assertEquals(4499, $order->total_cents);
        $this->assertEquals(44.99, $order->total);
        $this->assertEquals('$44.99', $order->formatted_total);
    }

    public function test_order_with_add_ons(): void
    {
        $order = Order::factory()->create([
            'four_poses_upgrade' => true,
            'four_poses_upgrade_price_cents' => 1999,
            'pose_perfection' => true,
            'pose_perfection_price_cents' => 2999,
        ]);

        $this->assertTrue($order->four_poses_upgrade);
        $this->assertTrue($order->pose_perfection);
        $this->assertEquals(1999, $order->four_poses_upgrade_price_cents);
        $this->assertEquals(2999, $order->pose_perfection_price_cents);
    }

    public function test_order_with_premium_retouch(): void
    {
        $order = Order::factory()->create([
            'premium_retouch' => true,
            'premium_retouch_price_cents' => 3999,
            'retouch_specification' => 'Remove braces, whiten teeth',
        ]);

        $this->assertTrue($order->premium_retouch);
        $this->assertEquals(3999, $order->premium_retouch_price_cents);
        $this->assertEquals('Remove braces, whiten teeth', $order->retouch_specification);
    }

    public function test_order_with_coupon_code(): void
    {
        $order = Order::factory()->create([
            'coupon_code' => 'FALL2025',
            'discount_cents' => 1000,
        ]);

        $this->assertEquals('FALL2025', $order->coupon_code);
        $this->assertEquals(1000, $order->discount_cents);
    }

    public function test_can_soft_delete_order(): void
    {
        $order = Order::factory()->create();

        $order->delete();

        $this->assertSoftDeleted('orders', ['id' => $order->id]);
    }

    public function test_order_can_attach_add_ons(): void
    {
        $order = Order::factory()->create();
        $addOn = AddOn::factory()->create([
            'name' => 'Extra Prints',
            'price_cents' => 1999,
        ]);

        $order->addOns()->attach($addOn->id, [
            'quantity' => 2,
            'price_cents' => 3998,
        ]);

        $this->assertCount(1, $order->addOns);
        $this->assertEquals(2, $order->addOns->first()->pivot->quantity);
    }
}

