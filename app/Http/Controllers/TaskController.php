<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Requests\AddNewTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param AddNewTaskRequest $request
     * @param TaskList $taskList
     * @return JsonResponse
     */
    public function store(AddNewTaskRequest $request, TaskList $taskList)
    {
        try {
            $task = Task::createNewTask($request, $taskList);
        } catch(Exception $exception) {
            throw new HttpResponseException(
                new JsonResponse(['errors' => "Something goes wrong. Task list is not created"], 404)
            );
        }

        return response()->json([
            'data' => new TaskResource($task),
            'message' => "Task created success",
        ], 201);


    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Task $task
     * @param TaskList $taskList
     * @return JsonResponse
     */
    public function show(TaskList $taskList, Task $task)
    {
        return response()->json([
            'data' => new TaskResource($task),
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TaskList $taskList
     * @param \App\Models\Task $task
     * @return JsonResponse
     */
    public function edit(TaskList $taskList, Task $task)
    {
        try {
            Task::changeTaskStatus($task);
        } catch (Exception $exception) {
            throw new HttpResponseException(
                new JsonResponse(['errors' => "Something goes wrong. Task is not updated"], 400)
            );
        }

        return response()->json([
            'data' => new TaskResource($task),
            'message' => "Task updated success"
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $request
     * @param TaskList $taskList
     * @param \App\Models\Task $task
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, TaskList $taskList, Task $task)
    {
        try {
            Task::updateTask($request, $task);
        } catch (Exception $exception) {
            throw new HttpResponseException(
                new JsonResponse(['errors' => "Something goes wrong. Task is not updated"], 400)
            );
        }

        return response()->json([
            'data' => new TaskResource($task),
            'message' => "Task updated success"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return JsonResponse
     */
    public function destroy(TaskList $taskList, Task $task)
    {
        Task::deleteTask($task);

        return response()->json([
            'message' => "Task deleted"
        ], 200);
    }
}
