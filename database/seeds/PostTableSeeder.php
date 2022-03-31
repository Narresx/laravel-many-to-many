<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;


class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $category_ids = Category::pluck('id')->toArray();

        for($i=0; $i<10; $i++){
            $post= new Post();
            $post->category_id = Arr::random($category_ids);
            $post->title = $faker->sentence(1);
            $post->content = $faker->paragraphs(2, true);
            $post->image = $faker->imageUrl(200, 200);
            $post->slug = Str::slug($post->title, '-');
            $post->save();
        }
    }
}
