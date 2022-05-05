<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonalTaskStoreRequest;
use App\Http\Requests\PersonalTaskUpdateRequest;
use App\Models\PersonalTask;
use Illuminate\Support\Facades\Auth;

class PersonalTaskController extends Controller
{

    public function index()
    {
        return response()->json(PersonalTask::where('user_id',Auth::id())->get());
    }


    public function store(PersonalTaskStoreRequest $request)
    {
        return response()->json( PersonalTask::create(
     $request->all()+ ['user_id'=>Auth::id()])
   );}

    public function show(PersonalTask $personal_task)
    {
        return response()->json($personal_task);
       // return response()->json(['message'=>'Unauthorized'],401);

    }



    public function update(PersonalTask $personal_task,PersonalTaskUpdateRequest $request)
    {
          $personal_task->update($request->all());
          return  response()->json(['data'=>$personal_task,'message'=>'task edited.']);
    }


    public function destroy(PersonalTask $personal_task)
    {
            $personal_task->delete();
            return  response()->json(['message'=>'task deleted.']);

    }
}
