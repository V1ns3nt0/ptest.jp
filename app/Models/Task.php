<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'priority',
        'is_active',
        'list_id',
    ];

    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }

    public static function createNewTask($request, $taskList)
    {
        return $taskList->task()->create([
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority,
            'is_active' => 1,
        ]);
    }

    public static function changeTaskStatus($task)
    {
        if ($task->is_active == 1) {
            $newStatusValue = 0;
        } else {
            $newStatusValue = 1;
        }

        return $task->update([
            'is_active' => $newStatusValue,
        ]);
    }

    public static function updateTask($request, $task)
    {
        return $task->update($request->all());
    }

    public static function deleteTask($task)
    {
        return $task->delete();
    }
}
