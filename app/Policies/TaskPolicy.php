<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public static function viewAny(User $user)
    {
        return  false;
    }

    public static function view(User $user,Task $task)
    {
        $project = $task->project;
        if($user->role($project) === 'admin'){
            $allow = true;
        }else if($user->role($project) === 'assignee'){
            $allow = $user->id == $task->user_id;
        }else
            $allow = false;

        return $allow;
    }

    public static function create(User $user,Task $task)
    {
        $project = $task->project;
        return $user->isAdmin($project);
    }

    public static function Update(User $user, Task $task)
    {
        $project = $task->project;
        return $user->isAdmin($project);
    }

    public static function changeStatus(User $user,Task $task)
    {
        $project = $task->project;
        if($user->role($project) === 'admin'){
            $allow = true;
        }else if($user->role($project) === 'assignee'){
            $allow = $user->id == $task->user_id;
        }else
            $allow = false;

        return $allow;
    }

    public static function delete(User $user, Task $task)
    {
        $project = $task->project;
        return $user->isAdmin($project);
    }
}
