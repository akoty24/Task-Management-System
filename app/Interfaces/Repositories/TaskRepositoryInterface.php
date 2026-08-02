<?php

namespace App\Interfaces\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function allForProject(int $projectId, array $filters = []): Collection;

    public function findForProject(int $id, int $projectId): ?Task;

    public function create(array $data): Task;

    public function update(Task $task, array $data): Task;

    public function delete(Task $task): bool;

    public function getTaskStatsForUser(int $userId): array;
}
