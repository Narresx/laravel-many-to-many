<?php

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Faker\Generator as Faker;


class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $tag_categories = ['Frontend', 'Backend', 'Fullstack', 'UI/UX', 'Design','CMS'];

        foreach ($tag_categories as $tag_category) {
            $tag = new Tag();

            $tag->label = $tag_category;
            $tag->color = $faker->hexColor();

            $tag->save();
        }
    }
}
