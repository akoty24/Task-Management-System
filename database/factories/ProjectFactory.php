<?php

namespace Database\Factories;

use App\Models\Project;
use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<Project> */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(ProjectStatus::cases())->value,
        ];
    }
}
