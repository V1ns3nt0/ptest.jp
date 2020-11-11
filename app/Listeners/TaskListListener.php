<?php

namespace App\Listeners;

use App\Events\TaskListEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaskListListener
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
     * @param  TaskListEvent  $event
     * @return void
     */
    public function handle(TaskListEvent $event)
    {
        \Cache::forget('taskList_' . $event->getTaskList()->id);
    }
}
