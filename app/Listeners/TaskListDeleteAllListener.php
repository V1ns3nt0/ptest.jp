<?php

namespace App\Listeners;

use App\Events\TaskListDeleteAllEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaskListDeleteAllListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TaskListDeleteAllEvent  $event
     * @return void
     */
    public function handle(TaskListDeleteAllEvent $event)
    {
        \Cache::forget('taskList_' . $event->getTaskList()->id);
        \Cache::forget('taskList_tasks_' . $event->getTaskList()->id);
        \Cache::forget('taskList_subTaskLists_' . $event->getTaskList()->id);
    }
}
