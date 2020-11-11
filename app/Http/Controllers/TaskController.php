<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Resources\PreviewTaskWithListResource;
use App\Http\Requests\AddNewTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Controllers\BaseController;
use App\Exception\CustomApiCreateException;
use App\Exception\CustomApiUpdateException;


/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends BaseController
{

    /**
     * Store a newly created task.
     * Validate request with AddNewTaskRequest.
     *
     * @param AddNewTaskRequest $request
     * @param TaskList $taskList
     * @return JsonResponse
     * @throws CustomApiCreateException
     */
    public function store(AddNewTaskRequest $request, TaskList $taskList)
    {
        try {
            $task = Task::createNewTask($request, $taskList);
        } catch(Exception $exception) {
            throw new CustomApiCreateException("Something goes wrong. Task is not created");
        }

        return $this->sendResponse(
            new TaskResource($task), 201, "Task created success"
        );
    }

    /**
     * Display the specified task.
     *
     * @param \App\Models\Task $task
     * @param TaskList $taskList
     * @return JsonResponse
     */
    public function show(TaskList $taskList, Task $task)
    {
        $taskNew = Task::getOneTask($task);
        return $this->sendResponse(new TaskResource($taskNew), 200);
    }

    /**
     * Change tasks status.
     *
     * @param TaskList $taskList
     * @param \App\Models\Task $task
     * @return JsonResponse
     * @throws CustomApiUpdateException
     */
    public function edit(TaskList $taskList, Task $task)
    {
        try {
            Task::changeTaskStatus($task, $taskList);
        } catch (Exception $exception) {
            throw new CustomApiUpdateException("Something goes wrong. Task list is not updated");
        }

        return $this->sendResponse(
            new TaskResource($task), 200, "Task updated success"
        );
    }

    /**
     * Update the specified task.
     * Validate request with UpdateTaskRequest
     *
     * @param UpdateTaskRequest $request
     * @param TaskList $taskList
     * @param \App\Models\Task $task
     * @return JsonResponse
     * @throws CustomApiUpdateException
     */
    public function update(UpdateTaskRequest $request, TaskList $taskList, Task $task)
    {
        try {
            Task::updateTask($request, $task, $taskList);
        } catch (Exception $exception) {
            throw new CustomApiUpdateException("Something goes wrong. Task list is not updated");
        }

        return $this->sendResponse(
            new TaskResource($task), 200, "Task updated success"
        );
    }

    /**
     * Remove the specified task.
     *
     * @param  \App\Models\Task  $task
     * @return JsonResponse
     */
    public function destroy(TaskList $taskList, Task $task)
    {
        Task::deleteTask($task, $taskList);

        return $this->sendResponse([], 200, "Task deleted");
    }

    /**
     * Show all users tasks on today.
     * @return mixed
     */
    public function taskDeadline()
    {
        $list = Task::getAllTodayTask();

        return $this->sendResponse(
            PreviewTaskWithListResource::collection($list), 200);
    }
}
