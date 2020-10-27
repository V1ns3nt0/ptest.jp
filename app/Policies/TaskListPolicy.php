<?php

namespace App\Policies;

use App\Models\TaskList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TaskListPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TaskList  $taskList
     * @return mixed
     */
    public function view(User $user, TaskList $taskList)
    {
        return $user->id == $taskList->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @param TaskList $taskList
     * @return mixed
     */
    public function create(User $user, TaskList $taskList)
    {
        return $user->id == $taskList->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TaskList  $taskList
     * @return mixed
     */
    public function update(User $user, TaskList $taskList)
    {
        return $user->id == $taskList->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TaskList  $taskList
     * @return mixed
     */
    public function delete(User $user, TaskList $taskList)
    {
        return $user->id == $taskList->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TaskList  $taskList
     * @return mixed
     */
    public function restore(User $user, TaskList $taskList)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TaskList  $taskList
     * @return mixed
     */
    public function forceDelete(User $user, TaskList $taskList)
    {
        //
    }
}
