<?php

namespace App\Http\Controllers;

use App\Http\Requests\SprintStoreRequest;
use App\Http\Requests\SprintUpdateRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Project $project , Sprint $sprint)
    {
        $user_id= Auth::id();
        if($user_id == $project->user_id){
            $tasks = $sprint->tasks()->get();
            return response()->json(['tasks:' => $tasks]);
        }
        $tasks = Task::query()->
        where('user_id','=',$user_id)->
        where('sprint_id','=',$sprint->id)->get();
        return response()->json(['tasks:' => $tasks]);

    }

    public function store(Project $project,Sprint $sprint,TaskStoreRequest $request )
    {
        $user_id = Auth::id();
        //dd($request->user_id);
        if($user_id == $project->user_id){
            $task = Task::create([
                'name'=>$request->name,
                'sprint_id'=>$sprint->id,
                'deadline'=>$request->deadline,
                'description'=>$request->description,
                'user_id' => $request->user_id,
                'status' => 'sprint'
            ]);
            return response()->json(['success','Task :' => $task]);
        }
        return response()->json('not allow');
    }

    public function show(Project $project,Sprint $sprint,Task $task)
    {
        $user_id = Auth::id();
        if($user_id == $project->user_id || $user_id == $task->user_id){

            return response()->json([
                'task' => $task,
            ]);
        }
        return response()->json('not allow');
    }
    public function update(TaskUpdateRequest $request, Project $project,Sprint $sprint,Task $task)
    {
        $user_id = Auth::id();
        if($user_id == $project->user_id){
            $task->update([
                'name'=>$request->name,
                'deadline'=>$request->deadline,
                'description'=>$request->description
            ]);
            return response()->json(['success','task :' => $task]);
        }
        if ($user_id == $task->user_id){
            $task->update([
                'status' => $request->status
            ]);
            return response()->json(['success','task :' => $task]);
        }
        return response()->json('not allow');
    }
    public function destroy(Project $project,Sprint $sprint,Task $task)
    {
        $user_id = Auth::id();
        if($user_id == $project->user_id){
            $task->delete();
            return response()->json('success');
        }
        return response()->json('not allow');
    }
}
