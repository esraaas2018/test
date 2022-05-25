<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{

    public static function view(User  $user, Project $project){
        return $user->isParticipant($project);
    }

    public static function revokeParticipant(User $user, Project $project){
        return $user->isAdmin($project);
    }

}
