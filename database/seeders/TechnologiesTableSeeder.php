<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technology;
use Faker\Generator as Faker;

class TechnologiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $technologies = ['HTML', 'CSS', 'Bootstrap', 'JavaScript', 'Vue.js', 'Node.js', 'PHP', 'MySQL', 'Laravel',];

        foreach ($technologies as $technology) {
            Technology::create(
                [
                    "name" => $technology,
                    "color" => $faker->rgbColor(),
                    "slug" => \Illuminate\Support\Str::slug($technology)
                ]
            );
        }
    }
}
