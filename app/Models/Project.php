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

//    protected static function boot()
//    {
//        parent::boot();
//        static::addGlobalScope(new AdminScope);
//    }

//    public function scopeIsAdmain($query)
//    {
//        return $query->where('user_id', '=', Auth::id());
//    }
//
    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }


    public function statuses()
    {
        return $this->belongsToMany(Status::class)->withPivot(['order']);
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

}
