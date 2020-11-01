<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use phpseclib\Math\BigInteger;

/**
 * Class TaskList
 * @package App\Models
 * @property string name
 * @property boolean is_opened
 * @property bigInteger user_id
 * @property bigInteger list_id
 */
class TaskList extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'is_opened',
        'user_id',
        'list_id',
    ];

    /**
     * Relation with Task class.
     * @return mixed
     */
    public function task()
    {
        return $this->hasMany(Task::class,'list_id');
    }

    /**
     * Recursive relationship with TaskList class.
     * @return mixed
     */
    public function taskList()
    {
        return $this->hasMany(TaskList::class, 'list_id');
    }

    /**
     * Return all current users task list. Result is paginated by 10 items per page.
     * @return mixed
     */
    public static function getAllUsersLists()
    {
        $lists = self::where('user_id', Auth::user()->id)
            ->where('list_id', null)->paginate(10);
        return $lists;
    }

    /**
     * Get request data and create new task list.
     * @param $request
     * @param null $taskList
     * @return mixed
     */
    public static function createNewTaskList($request, $taskList = null)
    {
        $list = new TaskList();
        $list->name = $request->name;
        $list->is_opened = 1;
        $list->user_id = Auth::user()->id;
        $list->list_id = $taskList->id;
        $list->save();
        return $list;
    }

    /**
     * Return to user full requested task list with sub-lists and tasks.
     * @param $taskList
     * @return mixed
     */
    public static function getOneTaskList($taskList)
    {
        return self::where('id', $taskList->id)->with('task', 'taskList')->get();
    }

    /**
     * Update task List params:  name, is_opened can be changed.
     * @param $request
     * @param $taskList
     * @return mixed
     */
    public static function editTaskList($request, $taskList)
    {
        $taskList->name = $request->name;
        $taskList->is_opened = $request->is_opened ? $request->is_opened : $taskList->is_opened;
        $taskList->save();
        return $taskList;
    }

    /**
     * Delete task list.
     * @param $taskList
     * @return mixed
     */
    public static function deleteTaskList($taskList)
    {
        return $taskList->delete();
    }

    /**
     * Method change is_opened param.
     * @param $taskList
     * @return mixed
     */
    public static function changeTaskListStatus($taskList)
    {
        if ($taskList->is_opened == 1) {
            $newStatusValue = 0;
            $taskList->task()->update([
                'is_active' => 0
            ]);
            $taskList->taskList()->update([
                'is_opened' => 0
            ]);
        } else {
            $newStatusValue = 1;
        }

        $taskList->is_opened = $newStatusValue;
        $taskList->save();

        return $taskList;
    }

    /**
     * Return sorted task lists by requested params.
     * Probably sorting params: created_at, updated_at, name.
     * Probably sorting order params: desc,asc.
     * @param $request
     * @return mixed
     */
    public static function sortUsersTaskLists($request)
    {
        if ($request->order == 'desc') {
            return self::getAllUsersLists()->sortByDesc($request->order_params);
        }
        return self::getAllUsersLists()->sortBy($request->order_params);
    }
}
