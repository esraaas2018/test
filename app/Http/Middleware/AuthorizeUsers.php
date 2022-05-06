<?php

namespace App\Http\Middleware;

use App\Models\PersonalTask;
use App\Models\Project;
use App\Models\Task;
use App\Providers\RouteServiceProvider;
use Closure;
use Faker\Provider\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizeUsers
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $model)
    {

        $models_array = explode('|',$model);
        $specified_models = [PersonalTask::class,Project::class,Task::class];
        $authrized_models= array_intersect($models_array, $specified_models);
        $pars = $request->route()->parameters();
        $entity= head($pars);
        if(in_array(get_class($entity), $authrized_models)){
              if($entity->user_id!=Auth::id())
                abort(response()->json('Unauthorized', 403));
        }
          return $next($request);


       //if ($entity->user_id !== Auth::id())
     //      abort(response()->json('Unauthorized', 403));

      // return $next($request);

    }
}
