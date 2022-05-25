<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusStoreRequest;
use App\Http\Resources\StatusResource;
use App\Models\Project;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(Project $project){
        $statuses = $project->statuses()->withPivot('order')->orderBy('order')->get();
        return apiResponse(StatusResource::collection($statuses));
    }
}
