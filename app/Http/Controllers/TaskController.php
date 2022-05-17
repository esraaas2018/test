<?php

namespace App\Http\Controllers;

use App\Http\Requests\SprintStoreRequest;
use App\Http\Requests\SprintUpdateRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\Task;
use App\Policies\TaskPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\AssertableJsonString;

class TaskController extends Controller
{
    public function index(Project $project , Sprint $sprint)
    {
        $tasks = Task::query()->isass()->orWhere->isadd($project,$sprint)->get();
        return response()->json(['tasks:' => $tasks]);
    }

    public function store(Project $project,Sprint $sprint,TaskStoreRequest $request )
    {
        //dd(Gate::allows('create-task',$project));
        if(Gate::allows('create-task',$project)){
            $task = Task::create($request->all() +['status' => 'sprint','sprint_id'=>$sprint->id]);
            return response()->json(['success','Task :' => $task],201);
        }
        return response()->json('unauthorized',403);

    }

    public function show(Project $project,Sprint $sprint,Task $task)
    {
        if(Gate::allows('view-task',[$project,$task])){
            return response()->json([
                'task' => $task,
            ],200);
        }
        return response()->json('unauthorized',403);

    }
    public function update(TaskUpdateRequest $request, Project $project,Sprint $sprint,Task $task)
    {
        $task->update([
            'name'=>$request->name,
            'deadline'=>$request->deadline,
            'description'=>$request->description
        ]);
        return apiResponse($task);
    }

    public function changeStatus(TaskChangeStatusRequest $request,$task){

    }

    public function destroy(Project $project,Sprint $sprint,Task $task)
    {
        if(Gate::allows('delete-task',$project)){
            $task->delete();
            return response()->json('success');
        }
        return response()->json('unauthorized',403);

    }
}
