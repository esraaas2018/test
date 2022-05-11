<?php

namespace App\Http\Controllers;

use App\Http\Requests\SprintStoreRequest;
use App\Http\Requests\SprintUpdateRequest;
use App\Models\Project;
use App\Models\Sprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SprintController extends Controller
{
    public function index(Project $project)
    {
        $user_id= Auth::id();
        if($user_id == $project->user_id){
            $sprints = $project->sprints()->get();
            return response()->json(['sprints:' => $sprints]);
        }
        return response()->json('not allow');
    }

    public function store(Project $project,SprintStoreRequest $request )
    {
        $user_id = Auth::id();
        if($user_id == $project->user_id){
            $sprint = Sprint::create([
                'name'=>$request->name,
                'project_id'=>$project->id,
                'deadline'=>$request->deadline,
                'description'=>$request->description
            ]);
            return response()->json(['success','sprint :' => $sprint]);
        }
        return response()->json('not allow');
    }

    public function show(Project $project,Sprint $sprint)
    {
        $user_id = Auth::id();
        if($user_id == $project->user_id){

            return response()->json([
                'sprint' => $sprint,
            ]);
        }
        return response()->json('not allow');
    }
    public function update(SprintUpdateRequest $request, Project $project,Sprint $sprint)
    {
        $user_id = Auth::id();
        if($user_id == $project->user_id){
            $sprint->update([
                'name'=>$request->name,
                'deadline'=>$request->deadline,
                'description'=>$request->description
            ]);
            return response()->json(['success','sprint :' => $sprint]);
        }
        return response()->json('not allow');
    }
    public function destroy(Project $project,Sprint $sprint)
    {
        $user_id = Auth::id();
        if($user_id == $project->user_id){
            $sprint->delete();
            return response()->json('success');
        }
        return response()->json('not allow');
    }
}
