<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected School $school;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create();
        $this->school = School::factory()->create();
    }

    public function test_can_create_project(): void
    {
        $projectData = [
            'school_id' => $this->school->id,
            'name' => 'Fall 2025 Portraits',
            'slug' => 'fall-2025-portraits',
            'type' => 'fall',
            'available_backdrops' => ['Blue', 'Gray', 'Green'],
            'has_two_backdrops' => true,
            'registration_deadline' => now()->addDays(30),
            'session_date' => now()->addDays(45),
            'is_active' => true,
        ];

        $project = Project::create($projectData);

        $this->assertDatabaseHas('projects', [
            'name' => 'Fall 2025 Portraits',
            'slug' => 'fall-2025-portraits',
            'school_id' => $this->school->id,
        ]);

        $this->assertTrue($project->is_active);
        $this->assertIsArray($project->available_backdrops);
    }

    public function test_project_belongs_to_school(): void
    {
        $project = Project::factory()->create([
            'school_id' => $this->school->id,
        ]);

        $this->assertEquals($this->school->id, $project->school->id);
        $this->assertEquals($this->school->name, $project->school->name);
    }

    public function test_can_get_available_time_slots(): void
    {
        $project = Project::factory()
            ->hasTimeSlots(5, ['is_available' => true, 'max_participants' => 10, 'current_bookings' => 5])
            ->create();

        $availableSlots = $project->availableTimeSlots()->get();

        $this->assertGreaterThan(0, $availableSlots->count());
    }

    public function test_project_with_registrations(): void
    {
        $project = Project::factory()
            ->hasRegistrations(3)
            ->create();

        $this->assertCount(3, $project->registrations);
    }

    public function test_can_filter_active_projects(): void
    {
        Project::factory()->count(3)->create(['is_active' => true]);
        Project::factory()->count(2)->create(['is_active' => false]);

        $activeProjects = Project::where('is_active', true)->get();

        $this->assertCount(3, $activeProjects);
    }

    public function test_can_soft_delete_project(): void
    {
        $project = Project::factory()->create();

        $project->delete();

        $this->assertSoftDeleted('projects', ['id' => $project->id]);
    }

    public function test_project_deadline_is_date(): void
    {
        $deadline = now()->addDays(30);
        
        $project = Project::factory()->create([
            'registration_deadline' => $deadline,
        ]);

        $this->assertTrue($project->registration_deadline->isSameDay($deadline));
    }
}

