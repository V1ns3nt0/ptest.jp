<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckListsAndTasksMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if ($request->route()->parameter('taskList')->id === $request->route()
                ->parameter('task')->list_id) {
            return $next($request);

        }
        throw new ModelNotFoundException;

    }
}
