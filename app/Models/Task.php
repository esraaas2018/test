<?php

namespace App\Models;

use App\Scopes\TaskScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Znck\Eloquent\Traits\BelongsToThrough;

class Task extends Model
{
    use HasFactory, BelongsToThrough;

    protected $fillable = [
        'name',
        'deadline',
        'sprint_id',
        'user_id',
        'status_id',
        'description'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new TaskScope());

    }

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function project(){
        return $this->belongsToThrough(Project::class,Sprint::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }
}
