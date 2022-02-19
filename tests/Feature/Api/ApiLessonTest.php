<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Api\UtilsTrait;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;

class ApiLessonTest extends TestCase
{
    use UtilsTrait;

    public function test_get_lessons_unauthenicated()
    {
        $course = Course::factory()->create();

        $response = $this->getJson("/modules/{$course->id}/lessons");

        $response->assertStatus(401);
    }

    public function test_get_lessons_of_module_notfound()
    {
        $response = $this->getJson('/modules/fake_value/lessons', $this->defaultHeaders());

        $response->assertStatus(200)
                 ->assertJsonCount(0, 'data');
    }
    public function test_get_lessons_module()
    {
        $course = Course::factory()->create();

        $response = $this->getJson("/modules/{$course->id}/lessons", $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_get_lessons_of_module_total()
    {
        $module = Module::factory()->create();

         Lesson::factory()->count(10)->create([ //criando 10 modulos relacionado a este curso
             'module_id' => $module->id
        ]);

        $response = $this->getJson("/modules/{$module->id}/lessons", $this->defaultHeaders());

        $response->assertStatus(200)
                 ->assertJsonCount(10, 'data');;
    }
    public function test_get_lesson_by_id_unauthenticated()
    {

        $response = $this->getJson("/lessons/faker_value");

        $response->assertStatus(401);
    }

    public function test_get_lesson_by_id_not_found()
    {

        $response = $this->getJson("/lessons/fake_value", $this->defaultHeaders());

        $response->assertStatus(404);
    }

    public function test_get_lesson_by_id()
    {
        $lesson = Lesson::factory()->create();

        $response = $this->getJson("/lessons/{$lesson->id}", $this->defaultHeaders());

        $response->assertStatus(200);
    }
}
