<?php

namespace App\Services;

use App\Interfaces\Repositories\ProjectRepositoryInterface;
use App\Interfaces\Repositories\TaskRepositoryInterface;

class DashboardService
{
    protected ProjectRepositoryInterface $projectRepository;
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(
        ProjectRepositoryInterface $projectRepository,
        TaskRepositoryInterface $taskRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->taskRepository = $taskRepository;
    }

    public function getDashboardMetrics(int $userId): array
    {
        $projectStats = $this->projectRepository->getProjectStatsForUser($userId);
        $taskStats    = $this->taskRepository->getTaskStatsForUser($userId);

        return array_merge($projectStats, $taskStats);
    }
}
