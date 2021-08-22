<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskDoneRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        // $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return TaskResource::collection(Task::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return TaskResource
     */
    public function store(TaskRequest $request)
    {
        $task = DB::transaction(function () {
            $task = Task::query()->create(request()->all());
            if ($task) {
                return $task;
            }
            throw new HttpResponseException(response()->json([
                'message' => '登録できませんでした。',
            ], 403));
        });
        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Task         $task
     * @return TaskResource
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task = DB::transaction(function () use ($task) {
            $task->fill([
                'title' => request()->title,
                'task'  => request()->task,
            ]);
            if ($task->save()) {
                return $task;
            }
            throw new HttpResponseException(response()->json([
                'message' => '更新できませんでした。',
            ], 403));
        });
        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Task $task
     * @return TaskResource
     */
    public function destroy(Task $task)
    {
        DB::transaction(function () use ($task) {
            if ($task->delete()) {
                return true;
            }
            throw new HttpResponseException(response()->json([
                'message' => '削除できませんでした。',
            ], 403));
        });
        return new TaskResource($task);
    }

    // public function updateStatus(TaskRequest $request, Task $task)
    // {
    //     $task = DB::transaction(function () use ($task) {
    //         $task->fill([
    //             'task_status_id' => request()->task_status_id,
    //         ]);
    //         if ($task->save()) {
    //             return $task;
    //         }
    //         throw new HttpResponseException(response()->json([
    //             'message' => 'ステータスを更新できませんでした。',
    //         ], 403));
    //     });
    //     return new TaskResource($task);
    //
    // }

    public function updateDone(TaskDoneRequest $request, Task $task)
    {
        $task = DB::transaction(function () use ($task) {
            $task->fill([
                'task_status_id' => request()->is_done ? TaskStatus::DONE : TaskStatus::DOING,
            ]);
            if ($task->save()) {
                return $task;
            }
            throw new HttpResponseException(response()->json([
                'message' => 'ステータスを更新できませんでした。',
            ], 403));
        });
        return new TaskResource($task);
    }
}
