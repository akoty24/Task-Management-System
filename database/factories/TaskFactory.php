<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<Task> */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph,
            'priority' => $this->faker->randomElement(TaskPriority::cases())->value,
            'status' => $this->faker->randomElement(TaskStatus::cases())->value,
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
        ];
    }
}
