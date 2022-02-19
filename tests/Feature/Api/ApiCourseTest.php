<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Api\UtilsTrait;
use App\Models\Course;

class ApiCourseTest extends TestCase
{
    use UtilsTrait;

    public function test_unauthenticated()
    {

        $response = $this->getJson('/courses');

        $response->assertStatus(401);
    }

    public function test_get_all_courses()
    {
        $token = $this->createTokenUser();

        $response = $this->getJson('/courses', $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_get_all_course_total()
    {
        Course::factory()->count(10)->create();

        $response = $this->getJson('/courses', $this->defaultHeaders());

        $response->assertStatus(200)
                 ->assertJsonCount(10, 'data');
    }

    public function test_get_single_courses_unauthenticated()
    {

        $response = $this->getJson('/courses/fdfsddd');

        $response->assertStatus(401);

    }

    public function test_get_single_course_not_found()
    {

        $response = $this->getJson('/courses/fdfsddd', $this->defaultHeaders());

        $response->assertStatus(404);

    }

    public function test_get_single_course()
    {
       // $token = $this->createTokenUser();

        $course = Course::factory()->create();

        $response = $this->getJson("/courses/{$course->id}", $this->defaultHeaders());

        $response->assertStatus(200);

    }
}
