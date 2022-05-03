<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'deadline',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }
    public function personal_tasks()
    {
        return $this->hasMany(PersonalTask::class);
    }
}
