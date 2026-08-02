<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ApiResponseTrait;

    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $metrics = $this->dashboardService->getDashboardMetrics($request->user()->id);

            return $this->success(
                $metrics,
                'Dashboard metrics retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve dashboard metrics', 500, ['error' => $e->getMessage()]);
        }
    }
}
