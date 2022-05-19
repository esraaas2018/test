<?php

namespace App\Http\Controllers;

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
        return response()->json(['sprints:' => $sprints]);
    }

    public function store(Project $project,SprintStoreRequest $request )
    {
            $sprint = Sprint::create($request->all()+ ['project_id'=>$project->id]);
            return response()->json(['success','sprint :' => $sprint]);
    }

    public function show(SprintShowRequest $request, Sprint $sprint)
    {
       return apiResponse(SprintResource::make($sprint));
    }

    public function update(SprintUpdateRequest $request, Project $project,Sprint $sprint)
    {
        $sprint->update($request->all());
        return response()->json(['success','sprint :' => $sprint]);
    }
    public function destroy(Project $project,Sprint $sprint)
    {
        $sprint->delete();
        return response()->json('success');
    }
}
