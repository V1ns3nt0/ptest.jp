<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use phpseclib\Math\BigInteger;

/**
 * Class Task
 * @package App\Models
 * @property string name
 * @property text description
 * @property boolean is_active
 * @property enum priority
 * @property bigInteger list_id
 * @property datetime deadline
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
        'deadline',
        'list_id',
        'type_id',
    ];

    protected $dates = [
        'deadline',
    ];

    protected $with = ['taskType'];

    /**
     * Relation with TaskList class.
     * @return mixed
     */
    public function taskList()
    {
        return $this->belongsTo(TaskList::class, 'list_id');
    }

    /**
     * Relation with taskType class.
     * @return mixed
     */
    public function taskType()
    {
        return $this->hasOne(TaskType::class, 'id', 'type_id');
    }

    /**
     * Store uploaded image and return path to it.
     * Img available along the way: {host}/storage/tasks/{imgName}.
     * @param $request
     * @return string
     */
    public static function storeImgTask($request)
    {
        $path = $request->path->store("public/tasks");
        $pathEX = explode('/', $path);
        return "/storage/tasks/".$pathEX[2];
    }

    /**
     * Method get data create and return new task.
     * @param $request
     * @param $taskList
     * @return mixed
     */
    public static function createNewTask($request, $taskList)
    {
        $description = $request->type_id == 1 ? $request->description :
            self::storeImgTask($request);

        return $taskList->task()->create([
            'name' => $request->name,
            'description' => $description,
            'priority' => $request->priority,
            'is_active' => 1,
            'deadline' => Carbon::parse($request->deadline),
            'type_id' => $request->type_id,
        ]);
    }

    /**
     * Method change is_active param.
     * @param $task
     * @return mixed
     */
    public static function changeTaskStatus($task)
    {
        $newStatusValue = ($task->is_active == 1) ? 0 : 1;

        return $task->update([
            'is_active' => $newStatusValue,
        ]);
    }

    /**
     * Update tasks params: name, description, is_active, priority can be changed.
     * @param $request
     * @param $task
     * @return mixed
     */
    public static function updateTask($request, $task)
    {
        return $task->update($request->all());
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

    /**
     * Return all users tasks on today.
     * @return mixed
     */
    public static function getAllTodayTask()
    {
        return self::whereDate('deadline', today())->with(['taskList'])->get();
    }
}
