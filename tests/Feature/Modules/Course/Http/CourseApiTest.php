<?php

namespace Tests\Feature\Modules\Course\Http;

use App\Modules\Course\Domain\Models\Course;
use App\Modules\User\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $teacher;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->teacher = User::factory()->teacher()->create();
    }

    public function test_can_list_courses(): void
    {
        Course::factory(3)->create(['teacher_id' => $this->teacher->id]);

        $response = $this->getJson('/api/v1/courses');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'description', 'teacher', 'created_at', 'updated_at']
                ],
                'meta' => ['total', 'count', 'per_page', 'current_page', 'total_pages'],
                'links' => ['first', 'last', 'prev', 'next']
            ]);
    }

    public function test_can_show_single_course(): void
    {
        $course = Course::factory()->create(['teacher_id' => $this->teacher->id]);

        $response = $this->getJson("/api/v1/courses/{$course->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->description,
                ]
            ]);
    }

    public function test_can_create_course(): void
    {
        $courseData = [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'teacher_id' => $this->teacher->id,
        ];

        $response = $this->postJson('/api/v1/courses', $courseData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Course created successfully',
                'data' => [
                    'title' => $courseData['title'],
                    'description' => $courseData['description'],
                ]
            ]);

        $this->assertDatabaseHas('courses', [
            'title' => $courseData['title'],
            'teacher_id' => $this->teacher->id,
        ]);
    }

    public function test_can_update_course(): void
    {
        $course = Course::factory()->create(['teacher_id' => $this->teacher->id]);
        
        $updateData = [
            'title' => 'Updated Course Title',
            'description' => 'Updated description',
            'teacher_id' => $this->teacher->id,
        ];

        $response = $this->putJson("/api/v1/courses/{$course->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Course updated successfully',
                'data' => [
                    'title' => $updateData['title'],
                    'description' => $updateData['description'],
                ]
            ]);

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'title' => $updateData['title'],
        ]);
    }

    public function test_can_delete_course(): void
    {
        $course = Course::factory()->create(['teacher_id' => $this->teacher->id]);

        $response = $this->deleteJson("/api/v1/courses/{$course->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_course_creation_validation(): void
    {
        $response = $this->postJson('/api/v1/courses', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'teacher_id']);
    }

    public function test_course_creation_with_invalid_teacher(): void
    {
        $response = $this->postJson('/api/v1/courses', [
            'title' => 'Test Course',
            'teacher_id' => 999, 
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['teacher_id']);
    }

    public function test_course_title_max_length_validation(): void
    {
        $response = $this->postJson('/api/v1/courses', [
            'title' => str_repeat('a', 256),
            'teacher_id' => $this->teacher->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }
}
