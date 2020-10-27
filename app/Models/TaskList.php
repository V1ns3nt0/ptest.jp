<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TaskList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_opened',
        'user_id',
        'list_id',
    ];

    public function task()
    {
        return $this->hasMany(Task::class,'list_id');
    }

    public static function getAllUsersLists()
    {
        $lists = self::where('user_id', Auth::user()->id)
            ->where('list_id', null)->paginate(10);
        return $lists;
    }

    public static function createNewTaskList($request)
    {
        return self::create([
            'name' => $request->name,
            'is_opened' => 1,
            'user_id' => Auth::user()->id,
            'list_id' => null,
        ]);
    }

    public static function getOneTaskList($taskList)
    {
        return self::where('id', $taskList->id)->with('task')->get();
    }

    public static function editTaskList($request, $taskList)
    {
        return $taskList->update($request->all());
    }

    public static function deleteTaskList($taskList)
    {
        return $taskList->delete();
    }

    public static function changeTaskListStatus($taskList)
    {
        if ($taskList->is_opened == 1) {
            $newStatusValue = 0;
        } else {
            $newStatusValue = 1;
        }

        return $taskList->update([
            'is_opened' => $newStatusValue,
        ]);
    }


}
