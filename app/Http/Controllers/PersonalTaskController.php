<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonalTaskStoreRequest;
use App\Http\Requests\PersonalTaskUpdateRequest;
use App\Models\PersonalTask;
use App\Models\Project;
use App\Policies\ProjectPolicy;
use App\Services\NotificationSender;
use Illuminate\Support\Facades\Auth;
class PersonalTaskController extends Controller
{

    public function index()
    {
        $user =Auth::user();
     return apiResponse($user->personal_tasks()->get());
    }

    public function store(PersonalTaskStoreRequest $request,Project $project)
    {
        $newTask = PersonalTask::create(
            $request->validated() + [
                'user_id' => Auth::id(),
                'description' => $request->description,
                'completed' => $request->has('completed'),
                'project_id' => ProjectPolicy::view($this->project_id,$project) ? $request->project_id : null
            ]);
        return apiResponse($newTask, 'task created.');
    }

    public function show(PersonalTask $personal_task)
    {
        return apiResponse($personal_task);
    }

    public function update(PersonalTask $personal_task,PersonalTaskUpdateRequest $request)
    {
        NotificationSender::send(Auth::user(), ['title'=>'updating tasks','body'=>'you updated a task']);
        $personal_task->update($request->all());
        return apiResponse($personal_task,'task updated.');
    }

    public function destroy(PersonalTask $personal_task)
    {
            $personal_task->delete();
        return apiResponse(null,'task deleted');
    }
}
