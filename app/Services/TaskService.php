<?php

namespace App\Services;

use App\Interfaces\Repositories\ProjectRepositoryInterface;
use App\Interfaces\Repositories\TaskRepositoryInterface;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    protected TaskRepositoryInterface $taskRepository;
    protected ProjectRepositoryInterface $projectRepository;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        ProjectRepositoryInterface $projectRepository
    ) {
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;
    }

    public function listTasksForProject(int $projectId, int $userId, array $filters = []): Collection
    {
        $project = $this->projectRepository->findForUser($projectId, $userId);

        if (!$project) {
            throw new \Exception('Project not found or unauthorized access', 404);
        }

        return $this->taskRepository->allForProject($projectId, $filters);
    }

    public function createTask(int $projectId, int $userId, array $data): Task
    {
        $project = $this->projectRepository->findForUser($projectId, $userId);

        if (!$project) {
            throw new \Exception('Project not found or unauthorized access', 404);
        }

        $data['project_id'] = $projectId;
        return $this->taskRepository->create($data);
    }

    public function getTask(int $id, int $userId): ?Task
    {
        $task = Task::whereHas('project', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('id', $id)->first();

        if (!$task) {
            throw new \Exception('Task not found or unauthorized access', 404);
        }

        return $task;
    }

    public function updateTask(Task $task, array $data): Task
    {
        return $this->taskRepository->update($task, $data);
    }

    public function deleteTask(Task $task): bool
    {
        return $this->taskRepository->delete($task);
    }
}
