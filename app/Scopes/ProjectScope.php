<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\callback;

class ProjectScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();
        return $builder->whereHas('participants',function($q) use ($user) {
            return $q->where('users.id', $user->id);
        } )->orWhere('user_id' , $user->id);

    }

}
