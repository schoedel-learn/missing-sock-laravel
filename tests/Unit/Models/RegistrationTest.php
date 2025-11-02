<?php

namespace Tests\Unit\Models;

use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_generates_unique_registration_number(): void
    {
        $registration1 = Registration::factory()->create();
        $registration2 = Registration::factory()->create();

        $this->assertNotEquals($registration1->registration_number, $registration2->registration_number);
        $this->assertStringStartsWith('RG', $registration1->registration_number);
        $this->assertStringStartsWith('RG', $registration2->registration_number);
    }

    public function test_registration_number_format_is_correct(): void
    {
        $registration = Registration::factory()->create();

        $this->assertMatchesRegularExpression('/^RG-\d{4}-\d{6}$/', $registration->registration_number);
    }

    public function test_casts_boolean_fields_correctly(): void
    {
        $registration = Registration::factory()->create([
            'sibling_special' => true,
            'auto_select_images' => false,
            'email_opt_in' => true,
        ]);

        $this->assertIsBool($registration->sibling_special);
        $this->assertIsBool($registration->auto_select_images);
        $this->assertIsBool($registration->email_opt_in);
        
        $this->assertTrue($registration->sibling_special);
        $this->assertFalse($registration->auto_select_images);
        $this->assertTrue($registration->email_opt_in);
    }

    public function test_casts_number_of_children_to_integer(): void
    {
        $registration = Registration::factory()->create([
            'number_of_children' => '3',
        ]);

        $this->assertIsInt($registration->number_of_children);
        $this->assertEquals(3, $registration->number_of_children);
    }

    public function test_signature_date_is_carbon_instance(): void
    {
        $registration = Registration::factory()->create([
            'signature_date' => now(),
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $registration->signature_date);
    }
}

