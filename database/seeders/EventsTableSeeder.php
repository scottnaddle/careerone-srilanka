<?php

namespace Database\Seeders;

use App\Models\CgoUser;
use App\Models\CodeManagement;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $folderThumb = 'storage/' . activeGuard() . '/events/thumbnails/' . $i;
            if (File::exists($folderThumb)) File::deleteDirectory($folderThumb);
            $imageUrl = 'https://picsum.photos/seed/picsum/300/200';
            // Get image contents
            $imageContents = file_get_contents($imageUrl);
            // Create a unique filename
            $imageName = $faker->unique()->word . '.jpg';
            // Store the image in the public storage
            Storage::disk('public')->put('cgo/events/thumbnails/' . $i . '/' . $imageName, $imageContents);
            DB::table('events')->insert([
                'title' => $faker->sentence,
                'event_type' => $faker->randomElement(CodeManagement::where('module', 'event_type')->pluck('code_id')->toArray()),
                'slug' => Str::slug($faker->sentence),
                'details' => $faker->paragraph,
                'thumbnail' => 'storage/cgo/events/thumbnails/' . $i . '/' . $imageName,
                'start_time' => Carbon::parse(now())->format('Y-m-d'),
                'end_time' => Carbon::parse(now())->format('Y-m-d'),
                'system' => 'cgo',
                'status' => $faker->numberBetween(0, 2),
                'created_by' => $faker->randomElement(CgoUser::pluck('id')->toArray()),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
