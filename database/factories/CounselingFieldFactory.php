<?php

namespace Database\Factories;

use App\Models\CgoCounseling;
use App\Models\CounselingField;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CounselingFieldFactory extends Factory
{
    protected $model = CounselingField::class;

    private $uniqueNames = [
        'Career Path',
        'Employment',
        'Portfolio Clinic'
    ];
    private $usedNames = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement($this->getUnusedNames());

        $this->usedNames[] = $name;

        return [
            'name' => $name,
        ];
    }

    private function getUnusedNames(): array
    {
        return array_diff($this->uniqueNames, $this->usedNames);
    }

    public function configure() {
        return $this->afterCreating(function (CounselingField $counselingField) {
            CgoCounseling::factory()->count(15)->create([
                'counseling_field_id' => $counselingField->id
            ]);
        });
    }
}
