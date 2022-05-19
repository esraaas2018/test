<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TaskScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
//        $user = Auth::user();
//        return $builder->whereHas('project', function($q) use ($user) {
//            return $q->where('user_id', $user->id);
//        })->orWhereHas('assignee', function ($q) use ($user) {
//            return $q->where('tasks.user_id', $user->id );
//        });
    }
}
