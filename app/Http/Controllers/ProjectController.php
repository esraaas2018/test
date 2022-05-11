<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;

class ProjectController extends Controller
{
    public function index()
    {
        $user_id= Auth::id();
        $projects = Project::query()->where('user_id' ,'=' ,$user_id)->get();
        return response()->json(['projects :' => $projects]);
    }
    public function show(Project $project)
    {
        $user_id = Auth::id();
        if($user_id == $project->user_id){
            return response()->json(['project :' => $project]);
        }
        return response()->json('not allow');
    }
    public function store(ProjectStoreRequest $request)
    {
        $user_id = Auth::id();
        $project = Project::create([
            'user_id' => $user_id,
            'name'=>$request->name,
            'deadline'=>$request->deadline,
            'description'=>$request->description,
        ]);
        return response()->json(['success','project :' => $project]);
    }


    public function update(Request $request, Project $project)
    {
        $user_id = Auth::id();
        if($user_id == $project->user_id){
            $project->update([
                'name'=>$request->name,
                'deadline'=>$request->deadline,
                'description'=>$request->description,
            ]);
            return response()->json(['success','project :' => $project]);
        }
        return response()->json('not allow');
    }
    public function destroy(Project $project)
    {
        $user_id = Auth::id();
        if($user_id == $project->user_id){
            $project->delete();
            return response()->json('success');
        }
        return response()->json('not allow');
    }
}
