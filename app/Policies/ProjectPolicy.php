<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{

    public static function view(User  $user, Project $project){
        return $project && $user->isParticipant($project);
    }

    public static function revokeParticipant(User $user, Project $project){
        return $project && $user->isAdmin($project);
    }

    public static function addParticipant(User $user, Project $project){
        return $project && $user->isAdmin($project);
    }

    public static function Update(User $user, Project $project)
    {
        return $project && $user->isAdmin($project);
    }
    public static function delete(User $user, Project $project)
    {
        return $project && $user->isAdmin($project);
    }
}
