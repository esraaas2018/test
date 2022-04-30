<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'deadline',
        'sprint_id',
        'assignee_id',
        'status'
    ];
    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,);
    }
}
