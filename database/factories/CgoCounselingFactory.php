<?php

namespace Database\Factories;

use App\Models\CgoCounseling;
use App\Models\CgoCounselingAssignHistory;
use App\Models\CounselingField;
use App\Models\TraineeUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CgoCounselingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $feedbackMessages = [
            'kind',
            'friendly',
            'organized',
            'good_service',
            'detailed',
        ];

        $statuses = [
            \App\Enums\CgoCounselingStatusEnums::REQUEST,
            \App\Enums\CgoCounselingStatusEnums::CONFIRM,
            \App\Enums\CgoCounselingStatusEnums::COMPLETED,
        ];

        $status = $this->faker->randomElement($statuses);

        $types = [
            \App\Enums\CgoCounselingTypeEnums::ONLINE,
            \App\Enums\CgoCounselingTypeEnums::OFFLINE_CGO,
            \App\Enums\CgoCounselingTypeEnums::OFFLINE,
        ];

        $type = $this->faker->randomElement($types);

        return [
            'type' => $type,
            'counseling_field_id' => 1,
            'title' => $this->faker->sentence,
            'registration_date' => $this->faker->dateTime,
            'location' => $this->faker->text,
            'detail_information' => $this->faker->text,
            'available_time' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'trainee_id' => $type === \App\Enums\CgoCounselingTypeEnums::OFFLINE_CGO ? null : $this->faker->randomElement(TraineeUser::pluck('id')->toArray()),
            'trainee_nic' => $type === \App\Enums\CgoCounselingTypeEnums::OFFLINE_CGO ? $this->generateRandomNic() : function (array $attributes) {
                return TraineeUser::find($attributes['trainee_id'])->nic;
            },
            'status' => $status,
            'result' => $status === \App\Enums\CgoCounselingStatusEnums::COMPLETED ? $this->faker->text : null,
            'feedback' => $status === \App\Enums\CgoCounselingStatusEnums::COMPLETED ? $this->faker->numberBetween(1,5) : null,
            'feedback_message' => $status === \App\Enums\CgoCounselingStatusEnums::COMPLETED ?
                json_encode($this->faker->randomElements($feedbackMessages,
                    $this->faker->numberBetween(1, 5)), JSON_THROW_ON_ERROR) : null,
            'cancel_reason' => $status === \App\Enums\CgoCounselingStatusEnums::CANCELED->value ? $this->faker->text : null,
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
            'deleted_at' => null,
            'institute_id' => 1,
            'trainee_offline_firstname' => $type === \App\Enums\CgoCounselingTypeEnums::OFFLINE_CGO ? $this->faker->firstName : null,
            'trainee_offline_lastname' => $type === \App\Enums\CgoCounselingTypeEnums::OFFLINE_CGO ? $this->faker->lastName : null,
        ];
    }

    private function generateRandomNic(): string
    {
        if (rand(0, 1)) {
            return $this->faker->regexify('[0-9]{9}[A-Z]');
        } else {
            return $this->faker->regexify('[0-9]{12}');
        }
    }

    public function configure() {
        return $this->afterCreating(function (CgoCounseling $counseling) {
            CgoCounselingAssignHistory::factory()->count(1)->create([
                'counseling_id' => $counseling->id
            ]);
        });
    }
}
