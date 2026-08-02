<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    use ApiResponseTrait;

    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(): JsonResponse
    {
        try {
            $projects = $this->projectService->listProjects(Auth::user()->id);

            return $this->success(
                ProjectResource::collection($projects),
                'Projects retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve projects', 500, ['error' => $e->getMessage()]);
        }
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        try {
            $project = $this->projectService->createProject(Auth::user()->id, $request->validated());

            return $this->created(
                new ProjectResource($project),
                'Project created successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to create project', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(Request $request, int $id): JsonResponse
    {
        try {
            $project = $this->projectService->getProject($id, Auth::user()->id);

            if (!$project) {
                return $this->notFound('Project not found');
            }

            return $this->success(
                new ProjectResource($project),
                'Project details retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve project details', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(UpdateProjectRequest $request, int $id): JsonResponse
    {
        try {
            $project = $this->projectService->getProject($id, Auth::user()->id);

            if (!$project) {
                return $this->notFound('Project not found');
            }

            $updatedProject = $this->projectService->updateProject($project, $request->validated());

            return $this->success(
                new ProjectResource($updatedProject),
                'Project updated successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to update project', 500, ['error' => $e->getMessage()]);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $project = $this->projectService->getProject($id,Auth::user()->id);
            if (!$project) {
                return $this->notFound('Project not found');
            }

            $this->projectService->deleteProject($project);

            return $this->deleted('Project deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete project', 500, ['error' => $e->getMessage()]);
        }
    }
}
