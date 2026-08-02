<?php

namespace App\Repositories;

use App\Enums\ProjectStatus;
use App\Interfaces\Repositories\ProjectRepositoryInterface;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    protected Project $model;

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    public function allForUser(int $userId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->withCount('tasks')
            ->latest()
            ->get();
    }

    public function findForUser(int $id, int $userId): ?Project
    {
        return $this->model
            ->where('id', $id)
            ->where('user_id', $userId)
            ->with('tasks')
            ->first();
    }

    public function create(array $data): Project
    {
        return $this->model->create($data);
    }

    public function update(Project $project, array $data): Project
    {
        $project->update($data);
        return $project->fresh();
    }

    public function delete(Project $project): bool
    {
        return (bool) $project->delete();
    }

    public function getProjectStatsForUser(int $userId): array
    {
        $query = $this->model->where('user_id', $userId);

        return [
            'total_projects'  => (clone $query)->count(),
            'active_projects' => (clone $query)->where('status', ProjectStatus::ACTIVE->value)->count(),
        ];
    }
}
