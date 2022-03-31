<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            ['label' => 'HTML', 'color' =>'danger'],
            ['label' => 'CSS', 'color' =>'info'],
            ['label' => 'ES6', 'color' =>'warning'],
            ['label' => 'Bootstrap', 'color' =>'success'],
            ['label' => 'PHP', 'color' =>'primary'],
            ['label' => 'SQL', 'color' =>'secondary'],
            ['label' => 'Laravel', 'color' =>'danger'],
            ['label' => 'VueJS', 'color' =>'success'],
        ];

        foreach ($category as $category){
            $newCategory = new Category();
            $newCategory->label = $category['label'];
            $newCategory->color = $category['color'];
            $newCategory->save();

        }
    }
}
