<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpseclib\Math\BigInteger;

/**
 * Class Task
 * @package App\Models
 * @property string name
 * @property text description
 * @property boolean is_active
 * @property enum priority
 * @property bigInteger list_id
 */
class Task extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'priority',
        'is_active',
        'list_id',
    ];

    /**
     * Relation with TaskList class.
     * @return mixed
     */
    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }

    /**
     * Method get data create and return new task.
     * @param $request
     * @param $taskList
     * @return mixed
     */
    public static function createNewTask($request, $taskList)
    {
        $task = new Task();
        $task->name = $request->name;
        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->is_active = 1;
        $task->list_id = $taskList->id;

        $task->save();

        return $task;
    }

    /**
     * Method change is_active param.
     * @param $task
     * @return mixed
     */
    public static function changeTaskStatus($task)
    {
        $newStatusValue = ($task->is_active == 1) ? 0 : 1;

        $task->is_active = $newStatusValue;
        $task->save();

        return $task;
    }

    /**
     * Update tasks params: name, description, is_active, priority can be changed.
     * @param $request
     * @param $task
     * @return mixed
     */
    public static function updateTask($request, $task)
    {
        $task->name = $request->name;
        $task->description = $request->name;
        $task->priority = $request->priority;
        $task->is_active = $request->is_active ? $request->is_active : $task->is_active;

        $task->save();

        return $task;
    }

    /**
     * Delete task.
     * @param $task
     * @return mixed
     */
    public static function deleteTask($task)
    {
        return $task->delete();
    }
}
