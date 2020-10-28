<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\GetAllListsResource;
use App\Http\Resources\GetOneListResource;
use App\Http\Requests\AddNewTaskListRequest;
use App\Http\Requests\SortingTaskListRequest;
use App\Http\Requests\FilteringTaskListRequest;
use App\Http\Requests\EditTaskListRequest;
use App\Http\Requests\CloseTaskListRequest;
use App\Http\Controllers\BaseController;
use App\Exception\CustomApiCreateException;
use App\Exception\CustomApiUpdateException;

class TaskListController extends BaseController
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
            return $this->sendResponse( [], 200, "There are no lists yet. Let's create it!");
        }

        return $this->sendResponse(
            GetAllListsResource::collection($lists)->response()->getData(true), 200
        );
    }

    /**
     * Store a newly created taskList.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(AddNewTaskListRequest $request, TaskList $taskList)
    {
        try {
            $list = TaskList::createNewTaskList($request, $taskList);
        } catch (Exception $exception) {
            throw new CustomApiCreateException("Something goes wrong. Task list is not created");
        }

        return $this->sendResponse(
            new GetAllListsResource($list), 201, "Task list created success"
        );
    }

    /**
     * Display the specified taskList.
     *
     * @param  \App\Models\TaskList  $taskList
     * @return JsonResponse
     */
    public function show(TaskList $taskList)
    {
        $list = TaskList::getOneTaskList($taskList);

        return $this->sendResponse(
            GetOneListResource::collection($list), 200
        );
    }

    /**
     * Mark taskList as closed.
     *
     * @param  \App\Models\TaskList  $taskList
     * @return JsonResponse
     */
    public function edit(TaskList $taskList)
    {
        try {
            TaskList::changeTaskListStatus($taskList);
        } catch (Exception $exception) {
            throw new CustomApiUpdateException("Something goes wrong. Task list is not updated");
        }

        return $this->sendResponse(
            new GetAllListsResource($taskList), 200, "Task list updated success"
        );
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
        try {
            TaskList::editTaskList($request, $taskList);
        } catch (Exception $exception) {
            throw new CustomApiUpdateException("Something goes wrong. Task list is not updated");
        }

        return $this->sendResponse(
            new GetAllListsResource($taskList), 200, "Task list updated success"
        );
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

        return $this->sendResponse([], 200, "Task List deleted");
    }

    public function sorting(SortingTaskListRequest $request)
    {
       $lists = TaskList::sortUsersTaskLists($request);

        return $this->sendResponse(
            GetAllListsResource::collection($lists)->response()->getData(true), 200
        );
    }
}
