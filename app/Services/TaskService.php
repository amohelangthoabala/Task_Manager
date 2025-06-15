<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function getAll()
    {
        return Task::with('assignedUser')->latest()->get();
    }

    public function getById($id)
    {
        return Task::with('assignedUser')->find($id);
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update($id, array $data)
    {
        $task = Task::find($id);

        if (! $task) {
            return null;
        }

        $task->update($data);

        return $task;
    }

    public function delete($id)
    {
        $task = Task::find($id);

        if (! $task) {
            return false;
        }

        $task->delete();

        return true;
    }
}
