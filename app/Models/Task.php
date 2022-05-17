<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'deadline',
        'sprint_id',
        'user_id',
        'status',
        'description'
    ];

    public function scopeIsass($query)
    {
        return $query->where('user_id', '=', Auth::id());
    }
    public function scopeIsadd($query,Project $project,Sprint $sprint)
    {
        if($project->user_id == Auth::id()){
            return $query->where('sprint_id', '=', $sprint->id);
        }

    }
    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
