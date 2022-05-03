<?php

namespace App\Http\Controllers;

use App\Models\PersonalTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalTaskController extends Controller
{

    public function index()
    {
        return response()->json(PersonalTask::where('user_id',Auth::id())->get());
    }


    public function store(Request $request)
    {
        $request->validate(['name'=>'required']);
        return response()->json( PersonalTask::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'deadline'=> $request->deadline,
            'project_id'=>$request->project_id,
            'user_id'=>Auth::id(),
        ])
   );}

    public function show(PersonalTask $personal_task)
    {
        if(Auth::id()==$personal_task->user_id)
        return response()->json($personal_task);
        return response()->json(['message'=>'Unauthorized'],401);

    }



    public function update(PersonalTask $personal_task,Request $request)
    {
        $this->validate($request,['name'=>'required']);
        if($personal_task->user_id==Auth::id())
        {
            $personal_task->update($request->all());
            return  response()->json(['data'=>$personal_task,'message'=>'task edited.']);
        }
        return response()->json(['message'=>'Unauthorized'],401);

    }


    public function destroy(PersonalTask $personal_task)
    {
        if($personal_task->user_id==Auth::id())
        {
            $personal_task->delete();
            return  response()->json(['message'=>'task deleted.']);
        }
        return response()->json(['message'=>'Unauthorized'],401);
    }
}
