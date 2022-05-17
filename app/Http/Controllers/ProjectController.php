<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use App\Scopes\AdminScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::get();

        return response()->json(['projects :' => $projects]);
    }

    public function show(Project $project)
    {
        return response()->json(['project :' => $project]);
    }

    public function store(ProjectStoreRequest $request)
    {
        $user_id = Auth::id();
        $project = Project::create($request->all()+ ['user_id'=>Auth::id()]);
        return response()->json(['success','project :' => $project]);
    }


    public function update(Request $request, Project $project)
    {
        $project->update($request->all());
        return response()->json(['success','project :' => $project]);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json('success');
    }
}
