<?php

namespace Tests\Feature;

use App\Http\Controllers\TaskController;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TaskTest extends TestCase
{
    // use RefreshDatabase;
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /**
     * @see TaskController::index()
     */
    public function testIndex(): void
    {
        $response = $this->getJson('/api/tasks');
        // dd($response->json());
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'title',
                        'task',
                        'is_done',
                    ],
                ],
            ]);
    }

    /**
     * @see TaskController::store()
     */
    public function testStore(): void
    {
        $response = $this->postJson('/api/tasks', [
            'title'            => 'title',
            'task'             => 'task',
            'task_status_id'   => TaskStatus::DONE,
            'assigned_user_id' => 10,
        ]);
        // dd($response->json());
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'task',
                    'is_done',
                ],
            ])
            ->assertJsonFragment([
                'title'   => 'title',
                'task'    => 'task',
                'is_done' => true,
            ]);
        // Database assertion
        $this->assertDatabaseHas('tasks', [
            'title'            => 'title',
            'task'             => 'task',
            'task_status_id'   => TaskStatus::DONE,
            'assigned_user_id' => 10,
        ]);
    }

    /**
     * @see TaskController::store()
     */
    public function testStoreWithValidation(): void
    {
        $response = $this->postJson('/api/tasks', [
            'title'            => '',
            'task'             => '',
            'task_status_id'   => TaskStatus::DONE,
            'assigned_user_id' => 10,
        ]);
        // dd($response->json());
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'title' => 'タイトルは、必ず指定してください。',
            ]);
    }

    /**
     * @see TaskController::update()
     */
    public function testUpdate(): void
    {
        /** @var Task $task */
        $task = Task::factory()->create(['task_status_id' => TaskStatus::DONE]);
        $response = $this->putJson(
            "/api/tasks/{$task->id}",
            $task->fill([
                'title' => 'title',
                'task'  => 'task',
            ])->toArray()
        );
        // dd($response->json());
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'task',
                    'is_done',
                ],
            ])
            ->assertJsonFragment([
                'id'      => $task->id,
                'title'   => $task->title,
                'task'    => $task->task,
                'is_done' => true,
            ]);
        // Database assertion
        $this->assertDatabaseHas('tasks', [
            'id'    => $task->id,
            'title' => 'title',
            'task'  => 'task',
        ]);
    }

    /**
     * @see TaskController::destroy()
     */
    public function testDestroy(): void
    {
        /** @var Task $task */
        $task = Task::factory()->create(['task_status_id' => TaskStatus::DONE]);
        $response = $this->deleteJson("/api/tasks/{$task->id}");
        // dd($response->json());
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'task',
                    'is_done',
                ],
            ])
            ->assertJsonFragment([
                'id'      => $task->id,
                'title'   => $task->title,
                'task'    => $task->task,
                'is_done' => true,
            ]);
        // Database assertion
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
