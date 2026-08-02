<?php

namespace App\Interfaces\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function allForUser(int $userId): Collection;

    public function findForUser(int $id, int $userId): ?Project;

    public function create(array $data): Project;

    public function update(Project $project, array $data): Project;

    public function delete(Project $project): bool;

    public function getProjectStatsForUser(int $userId): array;
}
