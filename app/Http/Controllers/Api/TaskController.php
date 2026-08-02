<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    use ApiResponseTrait;

    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request, int $projectId): JsonResponse
    {
        try {
            $filters = $request->only(['status', 'priority', 'search', 'per_page']);
            $tasks = $this->taskService->listTasksForProject($projectId, Auth::user()->id, $filters);

            return $this->paginated($tasks, 'Tasks retrieved successfully');
        } catch (\Exception $e) {
            $statusCode = $e->getCode() === 404 ? 404 : 500;
            return $this->error($e->getMessage(), $statusCode);
        }
    }

    public function store(StoreTaskRequest $request, int $projectId): JsonResponse
    {
        try {
            $task = $this->taskService->createTask($projectId, Auth::user()->id, $request->validated());

            return $this->created(
                new TaskResource($task),
                'Task created successfully'
            );
        } catch (\Exception $e) {
            $statusCode = $e->getCode() === 404 ? 404 : 500;
            return $this->error($e->getMessage(), $statusCode);
        }
    }

    public function show(Request $request, int $id): JsonResponse
    {
        try {
            $task = $this->taskService->getTask($id, Auth::user()->id);

            return $this->success(
                new TaskResource($task),
                'Task details retrieved successfully'
            );
        } catch (\Exception $e) {
            $statusCode = $e->getCode() === 404 ? 404 : 500;
            return $this->error($e->getMessage(), $statusCode);
        }
    }

    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        try {
            $task = $this->taskService->getTask($id, Auth::user()->id);
            $updatedTask = $this->taskService->updateTask($task, $request->validated());

            return $this->success(
                new TaskResource($updatedTask),
                'Task updated successfully'
            );
        } catch (\Exception $e) {
            $statusCode = $e->getCode() === 404 ? 404 : 500;
            return $this->error($e->getMessage(), $statusCode);
        }
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        try {
            $task = $this->taskService->getTask($id, Auth::user()->id);
            $this->taskService->deleteTask($task);

            return $this->deleted('Task deleted successfully');
        } catch (\Exception $e) {
            $statusCode = $e->getCode() === 404 ? 404 : 500;
            return $this->error($e->getMessage(), $statusCode);
        }
    }
}
