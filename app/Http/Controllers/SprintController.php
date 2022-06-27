<?php

namespace App\Http\Controllers;

use App\Http\Requests\SprintDeleteRequest;
use App\Http\Requests\SprintShowRequest;
use App\Http\Requests\SprintStoreRequest;
use App\Http\Requests\SprintUpdateRequest;
use App\Http\Resources\SprintResource;
use App\Models\Project;
use App\Models\Sprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SprintController extends Controller
{
    public function index(Project $project)
    {
        $sprints = $project->sprints()->get();
        return apiResponse(SprintResource::collection($sprints));

    }

    public function store(Project $project,SprintStoreRequest $request )
    {
        $sprint = Sprint::create($request->validated()+ ['project_id'=>$project->id]);
        return apiResponse(new SprintResource($sprint));
    }

    public function show(SprintShowRequest $request, Sprint $sprint)
    {
       return apiResponse(new SprintResource($sprint));
    }

    public function update(SprintUpdateRequest $request, Project $project,Sprint $sprint)
    {
        $sprint->update($request->validated());
        return apiResponse(new SprintResource($sprint));

    }
    public function destroy(SprintDeleteRequest $request,Project $project,Sprint $sprint)
    {
        $sprint->delete();
        return response()->json('success');
    }
}
