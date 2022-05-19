<?php

namespace App\Models;

use App\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'deadline',
        'description'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class);
    }
    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }
    public function tasks()
    {
        return $this->hasManyThrough(
            Task::class,
            Sprint::class
        );
    }
    public function personal_tasks()
    {
        return $this->hasMany(PersonalTask::class);
    }

    //bring all users in this project
    public function participants(){
        return $this->belongsToMany(User::class);
    }

}
