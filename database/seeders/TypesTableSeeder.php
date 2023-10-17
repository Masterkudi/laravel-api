<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $types = ['FrontEnd', 'BackEnd', 'FullStack', 'Design', 'DevOps'];

        foreach ($types as $type) {
            $new_type = new Type();
            $new_type->type = $type;
            $new_type->slug = Str::slug($new_type->name);
            $new_type->description = $faker->text(100);
            $new_type->color = $faker->rgbColor();
            $new_type->save();
        }
    }
}
