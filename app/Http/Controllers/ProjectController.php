<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectAddParticipantRequest;
use App\Http\Requests\ProjectRevokeParticipantRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\SprintResource;
use App\Models\Project;
use App\Models\User;
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
        return apiResponse(SprintResource::collection($project->sprints));
    }

    public function store(ProjectStoreRequest $request)
    {
        $project = Project::create($request->all()+ ['user_id'=>Auth::id()]);
        return response()->json(['success','project :' => $project]);
    }

    //add user to a project
    public function addUser(ProjectAddParticipantRequest $request, Project $project){
        $user = User::where('email', $request->email)->firstOrFail();
        $project->participants()->attach($user);

        apiResponse($project, 'user added to project successfully');
    }

    //revoke user from a project
    public function revokeUser(ProjectRevokeParticipantRequest $request, Project $project, User $user){
        $project->participants()->detach($user);
        $user->tasks()->ofProject($project)->get()->map(function($task){
            $task->user_id = null;
            $task->save();
        });
        $user->personal_tasks()->where('project_id', $project->id)->get()->map(function($task){
            $task->project_id = null;
            $task->save();
        });;

        apiResponse($project, 'user revoked to project successfully');
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
