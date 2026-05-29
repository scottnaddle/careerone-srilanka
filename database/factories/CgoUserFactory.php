<?php

namespace Database\Factories;

use App\Models\CgoUser;
use App\Models\District;
use App\Models\Institute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CgoUser>
 */
class CgoUserFactory extends Factory
{
    protected $model = CgoUser::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageUrl = 'https://picsum.photos/seed/' . $this->faker->unique()->word . '/200/200';

        // Get image contents
        $imageContents = file_get_contents($imageUrl);

        // Create a unique filename
        $imageName = $this->faker->unique()->word . '.jpg';

        // Store the image in the public storage
        Storage::disk('public')->put('profile_images/' . $imageName, $imageContents);
        return [
            'nic' => $this->generateUniqueNic(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => bcrypt('Videa@2024'),
            'telephone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'institute_id' => $this->faker->randomElement(Institute::pluck('id')->toArray()),
            'district_id' => $this->faker->randomElement(District::pluck('id')->toArray()),
            'verify_at' => date("Y-m-d H:i:s"),
            'verify_by' => 1,
            'profile_image' => 'storage/profile_images/' . $imageName,
            'email_verified_at' => date("Y-m-d H:i:s"),
            'attached_file' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];
    }

    private function generateUniqueNic(): string
    {
        if (rand(0, 1)) {
            return $this->faker->unique()->regexify('[0-9]{9}[A-Z]');
        } else {
            return $this->faker->unique()->regexify('[0-9]{12}');
        }
    }
}
