<?php

namespace Database\Factories;

use App\Models\Faq;
use App\Models\FaqArticle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Faq>
 */
class FaqFactory extends Factory
{
    protected $model = Faq::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'system' => $this->faker->randomElement([
                \App\Enums\FaqSystemEnums::TRAINEE,
                \App\Enums\FaqSystemEnums::CGO,
                \App\Enums\FaqSystemEnums::COMPANY,
            ]),
        ];
    }

    public function configure() {
        return $this->afterCreating(function (Faq $faq) {
            FaqArticle::factory()->count(random_int(1,6))->create([
                'faq_id' => $faq->id
            ]);
        });
    }
}
