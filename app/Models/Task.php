<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use phpseclib\Math\BigInteger;
use App\Events\TaskListTasksEvent;
use App\Events\TaskDeleteEvent;

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

    protected $dispatchesEvents = [
        'deleted' => TaskListTasksEvent::class,
        'saved' => TaskListTasksEvent::class,
    ];

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
     * Caching task.
     * @param $task
     * @return mixed
     */
    public static function saveToCacheTask($task)
    {
        return \Cache::rememberForever('task_' . $task->id, function() use ($task) {
            return $task;
        });
    }

    /**
     * Show single task.
     * @param $task
     * @return mixed
     */
    public static function getOneTask($task)
    {
        if (!\Cache::has('task_' . $task->id)) {
            self::saveToCacheTask($task);
        }
        return \Cache::get('task_' . $task->id);
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

        $task = $taskList->task()->create([
            'name' => $request->name,
            'description' => $description,
            'priority' => $request->priority,
            'is_active' => 1,
            'deadline' => Carbon::parse($request->deadline),
            'type_id' => $request->type_id,
        ]);
        $taskList->deleteTaskListsContentTasks($taskList);
        $taskList->getTaskListsContentTasks($taskList);
        return $task;
    }

    /**
     * Method change is_active param.
     * @param $task
     * @return mixed
     */
    public static function changeTaskStatus($task, $taskList)
    {
        $newStatusValue = ($task->is_active == 1) ? 0 : 1;

        $task->update([
            'is_active' => $newStatusValue,
        ]);

        $taskList->deleteTaskListsContentTasks($taskList);
        $taskList->getTaskListsContentTasks($taskList);
        self::saveToCacheTask($task);

        return $task;
    }

    /**
     * Update tasks params: name, description, is_active, priority can be changed.
     * @param $request
     * @param $task
     * @return mixed
     */
    public static function updateTask($request, $task, $taskList)
    {
        $task->update($request->all());
        $taskList->deleteTaskListsContentTasks($taskList);
        $taskList->getTaskListsContentTasks($taskList);
        self::saveToCacheTask($task);
        return $task;
    }

    /**
     * Delete task.
     * @param $task
     * @return mixed
     */
    public static function deleteTask($task, $taskList)
    {
        $task->delete();
        $taskList->deleteTaskListsContentTasks($taskList);
        $taskList->getTaskListsContentTasks($taskList);
        return true;
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
