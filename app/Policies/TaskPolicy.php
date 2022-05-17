<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return  false;
    }

    public function view(User $user,Project $project ,Task $task)
    {
        return $user->id === $project->user_id || $user->id === $task->user_id;
    }

    public function create(User $user,Project $project)
    {
        return $user->id === $project->user_id ;
    }

    public static function adminUpdate(User $user, Project $project)
    {
        return $user->id === $project->user_id ;
    }

    public static function assUpdate(User $user,Task $task)
    {
        return $user->id === $task->user_id ;
    }
    public function delete(User $user, Project $project)
    {
        return $user->id === $project->user_id;

    }
}
