<?php

namespace App\Repositories;

use App\Enums\TaskStatus;
use App\Interfaces\Repositories\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class TaskRepository implements TaskRepositoryInterface
{
    protected Task $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function allForProject(int $projectId, array $filters = []): Collection
    {
        $query = $this->model->where('project_id', $projectId);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        $perPage = $filters['per_page'] ?? 15;
        return $query->latest()->paginate($perPage);
    }

    public function findForProject(int $id, int $projectId): ?Task
    {
        return $this->model
            ->where('id', $id)
            ->where('project_id', $projectId)
            ->first();
    }

    public function create(array $data): Task
    {
        return $this->model->create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task->fresh();
    }

    public function delete(Task $task): bool
    {
        return (bool) $task->delete();
    }

    public function getTaskStatsForUser(int $userId): array
    {
        $today = Carbon::today()->toDateString();

        $query = Task::whereHas('project', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });

        return [
            'total_tasks'     => (clone $query)->count(),
            'completed_tasks' => (clone $query)->where('status', TaskStatus::DONE->value)->count(),
            'pending_tasks'   => (clone $query)->whereIn('status', [
                TaskStatus::TODO->value,
                TaskStatus::IN_PROGRESS->value,
            ])->count(),
            'overdue_tasks'   => (clone $query)
                ->where('due_date', '<', $today)
                ->where('status', '!=', TaskStatus::DONE->value)
                ->count(),
        ];
    }
}
