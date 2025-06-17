<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Task;

/**
 * @authenticated
 */
class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Get all tasks.
     *
     * @response 200 [{
     *   "id": 1,
     *   "title": "Task 1",
     *   "description": "Description",
     *   "assigned_to": 2,
     *   "status": "pending",
     *   "start_date": "2025-06-01",
     *   "end_date": "2025-06-10"
     * }]
     */
    public function index()
    {
        return response()->json($this->taskService->getAll());
    }

    /**
     * Get a specific task by ID.
     *
     * @urlParam id integer required The ID of the task.
     *
     * @response 200 {
     *   "id": 1,
     *   "title": "Task 1",
     *   "description": "Description",
     *   "assigned_to": 2,
     *   "status": "pending",
     *   "start_date": "2025-06-01",
     *   "end_date": "2025-06-10"
     * }
     * @response 404 {
     *   "message": "Task not found"
     * }
     */
    public function show($id)
    {
        $task = $this->taskService->getById($id);

        if (! $task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task);
    }

    /**
     * Create a new task.
     *
     * @bodyParam title string required The title of the task. Example: "New task"
     * @bodyParam description string The description of the task. Example: "Task details"
     * @bodyParam assigned_to integer required User ID the task is assigned to. Example: 2
     * @bodyParam status string required The status of the task. Possible values: pending, in_progress, completed. Example: pending
     * @bodyParam start_date date The start date of the task. Example: "2025-06-01"
     * @bodyParam end_date date The end date of the task (must be after or equal to start_date). Example: "2025-06-10"
     *
     * @response 201 {
     *   "id": 3,
     *   "title": "New task",
     *   "description": "Task details",
     *   "assigned_to": 2,
     *   "status": "pending",
     *   "start_date": "2025-06-01",
     *   "end_date": "2025-06-10"
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'status' => ['required', Rule::in(Task::statuses())],
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $task = $this->taskService->create($validated);

        return response()->json($task, 201);
    }

    /**
     * Update only the status of a task.
     * Here are status options: pending, active, completed, deferred, rejected
     * @urlParam id integer required The ID of the task.
     *
     * @bodyParam status string required The status of the task. Possible values: pending, active, completed, deferred, rejected
     *
     * @response 200 {
     *   "id": 3,
     *   "title": "Some task",
     *   "description": "Some description",
     *   "assigned_to": 1,
     *   "status": "active",
     *   "start_date": "2025-06-01",
     *   "end_date": "2025-06-10"
     * }
     * @response 404 {
     *   "message": "Task not found"
     * }
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(Task::statuses())],
        ]);

        $updatedTask = $this->taskService->update($id, $validated);

        if (! $updatedTask) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($updatedTask);
    }

    /**
     * Delete a task.
     *
     * @urlParam id integer required The ID of the task.
     *
     * @response 200 {
     *   "message": "Task deleted"
     * }
     * @response 404 {
     *   "message": "Task not found"
     * }
     */
    public function destroy($id)
    {
        $deleted = $this->taskService->delete($id);

        if (! $deleted) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json(['message' => 'Task deleted']);
    }
}
