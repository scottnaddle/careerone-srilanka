<?php

namespace Database\Factories;

use App\Models\AdminUser;
use App\Models\CareerGuidanceCategory;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CareerGuidance>
 */
class CareerGuidanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageUrl = 'https://picsum.photos/seed/picsum/300/200';

        // Get image contents
        $imageContents = file_get_contents($imageUrl);

        // Create a unique filename
        $imageName = $this->faker->unique()->word . '.jpg';

        // Store the image in the public storage
        Storage::disk('public')->put('cgo/career_guidance/thumbnails/' . $imageName, $imageContents);
        $title = $this->faker->name;
        $slug = Str::slug($title, '-', 'ta');
        $system = $this->faker->randomElement(['cgo', 'admin', 'company']);
        $created_by = 1;
        switch ($system) {
            case 'admin':
                $created_by = $this->faker->randomElement(AdminUser::all()->pluck('id')->toArray());
                break;
            case 'cgo':
                $created_by = $this->faker->randomElement(CgoUser::all()->pluck('id')->toArray());
                break;
            case 'company':
                $created_by = $this->faker->randomElement(CompanyRecruiter::all()->pluck('id')->toArray());
                break;
        }
        return [
            'title' => $this->faker->name,
            'category_id' => $this->faker->randomElement(CareerGuidanceCategory::all()->pluck('id')->toArray()),
            'thumbnail' => 'storage/cgo/career_guidance/thumbnails/' . $imageName,
            'slug' => $slug,
            'intro' => $this->faker->sentence,
            'video_url' => 'https://www.youtube.com/watch?v=z5p79-tOiPc',
            'system' => $system,
            'status' => $this->faker->numberBetween(0, 2),
            'created_by' => $created_by
        ];
    }
}
