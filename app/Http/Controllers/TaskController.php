<?php

namespace App\Http\Controllers;

use App\Http\Requests\SprintStoreRequest;
use App\Http\Requests\SprintUpdateRequest;
use App\Http\Requests\TaskChangeStatusRequest;
use App\Http\Requests\TaskIndexRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\Status;
use App\Models\Task;
use App\Policies\TaskPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\AssertableJsonString;
use Modules\Notification\NotificationSender;

class TaskController extends Controller
{
    public function index(TaskIndexRequest $request, Project $project)
    {
        //TaskScope applied
        $tasks = $project->tasks()->whereHas('status', function ($q) use ($request) {
            return $q->where('id', $request->status_id);
        });
        return apiResponse($tasks);
    }

    public function store(Sprint $sprint, TaskStoreRequest $request)
    {
        $task = Task::create($request->validated() + [
                'status' => 'sprint',
                'sprint_id' => $sprint->id
            ]);
        return apiResponse($task, 'task created successfully', 201);

    }

    public function show(Project $project, Sprint $sprint, Task $task)
    {
        if (Gate::allows('view-task', [$project, $task])) {
            return response()->json([
                'task' => $task,
            ], 200);
        }
        return response()->json('unauthorized', 403);
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        $task->update([
            'name' => $request->name,
            'deadline' => $request->deadline,
            'description' => $request->description
        ]);
        return apiResponse($task);
    }

    public function changeStatus(TaskChangeStatusRequest $request, Task $task)
    {

        //// for edward
        ///
        ///
        $project = $task->project;
        $status = $project->statuses()->firstOrFail([
            'name' => $request->status
        ]);
        $task->status_id = $status->id;
        $task->save();
        return apiResponse($task);
    }

    public function destroy(Project $project, Sprint $sprint, Task $task)
    {
        if (Gate::allows('delete-task', $project)) {
            $task->delete();
            return response()->json('success');
        }
        return response()->json('unauthorized', 403);
    }
}
