<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use App\Models\Status;
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
        $data = [
            'name' => $request->name,
            'deadline' => $request->deadline,
            'description' => $request->description,
            'user_id' => Auth::id()
        ];

        $project = Project::create($data);

        //ordering the statuses and merge the defaults
        $statuses = collect(['pending']);
        $statuses = $statuses->merge((array)$request->statuses);
        $statuses->push('done');

        $statuses->map(function($status, $key) use ($project) {
            $new_status = Status::firstOrCreate(['name' => $status]);
            $project->statuses()->attach($new_status->id, ['order' => $key]);
        });

        return apiResponse($project);
    }

    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $project->update($request->validated());
        return apiResponse($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json('success');
    }
}
