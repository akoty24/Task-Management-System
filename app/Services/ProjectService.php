<?php

namespace App\Services;

use App\Interfaces\Repositories\ProjectRepositoryInterface;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    protected ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function listProjects(int $userId): Collection
    {
        return $this->projectRepository->allForUser($userId);
    }

    public function createProject(int $userId, array $data): Project
    {
        $data['user_id'] = $userId;
        return $this->projectRepository->create($data);
    }

    public function getProject(int $id, int $userId): ?Project
    {
        return $this->projectRepository->findForUser($id, $userId);
    }

    public function updateProject(Project $project, array $data): Project
    {
        return $this->projectRepository->update($project, $data);
    }

    public function deleteProject(Project $project): bool
    {
        return $this->projectRepository->delete($project);
    }
}
