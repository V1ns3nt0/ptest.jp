<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\GetAllListsResource;
use App\Http\Requests\AddNewTaskListRequest;
use App\Http\Requests\EditTaskListRequest;
use App\Http\Requests\CloseTaskListRequest;

class TaskListController extends Controller
{
    /**
     * Display all users lists.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $lists = TaskList::getAllUsersLists();

        if ($lists->isEmpty()) {
            return response()->json([
                'message' => "There are no lists yet. Let's create it!",
            ], 200);
        }

        return response()->json([
            'data' => GetAllListsResource::collection($lists)->response()->getData(true),
        ], 200);
    }

    /**
     * Store a newly created taskList.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(AddNewTaskListRequest $request)
    {
        $list = TaskList::createNewTaskList($request);

        if (!$list) {
            throw new HttpResponseException(
                new JsonResponse(['errors' => "Something goes wrong. Task list is not created"], 404)
            );
        }

        return response()->json([
            'data' => new GetAllListsResource($list),
            'message' => "Task list created success",
        ], 201);
    }

    /**
     * Display the specified taskList.
     *
     * @param  \App\Models\TaskList  $taskList
     * @return \Illuminate\Http\Response
     */
    public function show(TaskList $taskList)
    {
        //
    }

    /**
     * Mark taskList as closed.
     *
     * @param  \App\Models\TaskList  $taskList
     * @return JsonResponse
     */
    public function edit(TaskList $taskList)
    {
        TaskList::changeTaskListStatus($taskList);

        if(!$taskList->wasChanged('is_opened')) {
            throw new HttpResponseException(
                new JsonResponse(['errors' => "Something goes wrong. Task list is not updated"], 400)
            );
        }

        return response()->json([
            'data' => new GetAllListsResource($taskList),
            'message' => "Task list updated success"
        ], 200);
    }

    /**
     * Update the specified taskList.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskList  $taskList
     * @return JsonResponse
     */
    public function update(EditTaskListRequest $request, TaskList $taskList)
    {
        TaskList::editTaskList($request, $taskList);

        if(!$taskList->wasChanged()) {
            throw new HttpResponseException(
                new JsonResponse(['errors' => "Something goes wrong. Task list is not updated"], 400)
            );
        }

        return response()->json([
            'data' => new GetAllListsResource($taskList),
            'message' => "Task list updated success"
        ], 200);
    }

    /**
     * Remove the specified taskList.
     *
     * @param  \App\Models\TaskList  $taskList
     * @return JsonResponse
     */
    public function destroy(TaskList $taskList)
    {
        TaskList::deleteTaskList($taskList);

        return response()->json([
            'message' => "Task List deleted"
        ], 200);
    }
}
