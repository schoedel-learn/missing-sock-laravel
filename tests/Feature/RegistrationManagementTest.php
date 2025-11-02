<?php

namespace Tests\Feature;

use App\Models\Child;
use App\Models\Project;
use App\Models\Registration;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected School $school;
    protected Project $project;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create();
        $this->school = School::factory()->create();
        $this->project = Project::factory()->create([
            'school_id' => $this->school->id,
        ]);
    }

    public function test_can_create_registration(): void
    {
        $registrationData = [
            'school_id' => $this->school->id,
            'project_id' => $this->project->id,
            'parent_first_name' => 'Jane',
            'parent_last_name' => 'Smith',
            'parent_email' => 'jane@example.com',
            'parent_phone' => '512-555-5678',
            'registration_type' => 'prepay',
            'number_of_children' => 1,
            'sibling_special' => false,
            'shipping_method' => 'school',
            'auto_select_images' => true,
            'email_opt_in' => true,
            'status' => 'pending',
        ];

        $registration = Registration::create($registrationData);

        $this->assertDatabaseHas('registrations', [
            'parent_email' => 'jane@example.com',
            'status' => 'pending',
        ]);

        $this->assertNotNull($registration->registration_number);
        $this->assertStringStartsWith('RG', $registration->registration_number);
    }

    public function test_registration_number_is_auto_generated(): void
    {
        $registration = Registration::factory()->create();

        $this->assertNotNull($registration->registration_number);
        $this->assertMatchesRegularExpression('/^RG-\d{4}-\d{6}$/', $registration->registration_number);
    }

    public function test_registration_belongs_to_school_and_project(): void
    {
        $registration = Registration::factory()->create([
            'school_id' => $this->school->id,
            'project_id' => $this->project->id,
        ]);

        $this->assertEquals($this->school->id, $registration->school->id);
        $this->assertEquals($this->project->id, $registration->project->id);
    }

    public function test_registration_can_have_children(): void
    {
        $registration = Registration::factory()
            ->hasChildren(2)
            ->create();

        $this->assertCount(2, $registration->children);
        
        foreach ($registration->children as $child) {
            $this->assertInstanceOf(Child::class, $child);
        }
    }

    public function test_registration_can_have_orders(): void
    {
        $registration = Registration::factory()
            ->hasOrders(1)
            ->create();

        $this->assertCount(1, $registration->orders);
    }

    public function test_can_update_registration_status(): void
    {
        $registration = Registration::factory()->create([
            'status' => 'pending',
        ]);

        $registration->update(['status' => 'confirmed']);

        $this->assertDatabaseHas('registrations', [
            'id' => $registration->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_can_filter_registrations_by_status(): void
    {
        Registration::factory()->count(3)->create(['status' => 'pending']);
        Registration::factory()->count(2)->create(['status' => 'confirmed']);
        Registration::factory()->count(1)->create(['status' => 'completed']);

        $pending = Registration::where('status', 'pending')->get();
        $confirmed = Registration::where('status', 'confirmed')->get();

        $this->assertCount(3, $pending);
        $this->assertCount(2, $confirmed);
    }

    public function test_registration_with_sibling_special(): void
    {
        $registration = Registration::factory()->create([
            'sibling_special' => true,
            'number_of_children' => 2,
        ]);

        $this->assertTrue($registration->sibling_special);
        $this->assertEquals(2, $registration->number_of_children);
    }

    public function test_can_soft_delete_registration(): void
    {
        $registration = Registration::factory()->create();

        $registration->delete();

        $this->assertSoftDeleted('registrations', ['id' => $registration->id]);
    }
}

