<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskListDeleteAllEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $taskList;

    /**
     * Create a new event instance.
     *
     * @param TaskList $taskList
     */
    public function __construct(TaskList $taskList)
    {
        $this->taskList = $taskList;
    }

    /**
     * @return mixed
     */
    public function getTaskList() {
        return $this->taskList;
    }
}
