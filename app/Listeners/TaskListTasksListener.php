<?php

namespace App\Listeners;

use App\Events\TaskListTasksEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaskListTasksListener
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
     * @param  TaskListTasksEvent  $event
     * @return void
     */
    public function handle(TaskListTasksEvent $event)
    {
        \Cache::forget('task_' . $event->getTask()->id);
    }
}
