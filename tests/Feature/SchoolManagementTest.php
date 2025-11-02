<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'email' => 'admin@example.com',
            'name' => 'Test Admin',
        ]);
    }

    public function test_can_create_school(): void
    {
        $schoolData = [
            'name' => 'Test Elementary School',
            'slug' => 'test-elementary',
            'address' => '123 Main St',
            'city' => 'Austin',
            'state' => 'TX',
            'zip' => '78701',
            'contact_name' => 'John Doe',
            'contact_email' => 'john@school.edu',
            'contact_phone' => '512-555-1234',
            'is_active' => true,
        ];

        $school = School::create($schoolData);

        $this->assertDatabaseHas('schools', [
            'name' => 'Test Elementary School',
            'slug' => 'test-elementary',
            'is_active' => true,
        ]);

        $this->assertEquals('Test Elementary School', $school->name);
    }

    public function test_school_slug_must_be_unique(): void
    {
        School::factory()->create(['slug' => 'duplicate-school']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        School::factory()->create(['slug' => 'duplicate-school']);
    }

    public function test_can_list_active_schools(): void
    {
        School::factory()->count(3)->create(['is_active' => true]);
        School::factory()->count(2)->create(['is_active' => false]);

        $activeSchools = School::where('is_active', true)->get();

        $this->assertCount(3, $activeSchools);
    }

    public function test_can_update_school(): void
    {
        $school = School::factory()->create([
            'name' => 'Old School Name',
        ]);

        $school->update(['name' => 'New School Name']);

        $this->assertDatabaseHas('schools', [
            'id' => $school->id,
            'name' => 'New School Name',
        ]);
    }

    public function test_can_soft_delete_school(): void
    {
        $school = School::factory()->create();

        $school->delete();

        $this->assertSoftDeleted('schools', ['id' => $school->id]);
    }

    public function test_school_has_projects_relationship(): void
    {
        $school = School::factory()
            ->hasProjects(3)
            ->create();

        $this->assertCount(3, $school->projects);
    }

    public function test_school_has_registrations_relationship(): void
    {
        $school = School::factory()
            ->hasRegistrations(5)
            ->create();

        $this->assertCount(5, $school->registrations);
    }
}

