<?php

namespace Database\Seeders;

use App\Models\V1\Category\Category;
use App\Models\V1\SubCategory\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            [
                "category" => "Technology",
                "subcategories" => [
                    "Web Development",
                    "Backend",
                    "Frontend",
                    "AI & Machine Learning",
                    "Cyber Security",
                    "Mobile Development",
                    "Cloud Computing",
                ]
            ],
            [
                "category" => "Programming",
                "subcategories" => [
                    "PHP",
                    "Laravel",
                    "JavaScript",
                    "Python",
                    "API Design",
                    "Databases",
                    "Testing",
                ]
            ],
            [
                "category" => "Business",
                "subcategories" => [
                    "Marketing",
                    "Entrepreneurship",
                    "E-Commerce",
                    "Finance",
                    "Startups",
                ]
            ],
            [
                "category" => "Lifestyle",
                "subcategories" => [
                    "Travel",
                    "Food",
                    "Fitness",
                    "Health",
                    "Self Improvement",
                ]
            ],
            [
                "category" => "Entertainment",
                "subcategories" => [
                    "Movies",
                    "Series",
                    "Music",
                    "Books",
                    "Art",
                ]
            ],
            [
                "category" => "Gaming",
                "subcategories" => [
                    "Game Reviews",
                    "Esports",
                    "Walkthroughs",
                    "Gaming News",
                ]
            ],
            [
                "category" => "Education",
                "subcategories" => [
                    "Tutorials",
                    "Guides",
                    "Tips & Tricks",
                    "Courses",
                    "Q&A",
                ]
            ],
            [
                "category" => "News",
                "subcategories" => [
                    "World News",
                    "Sports",
                    "Politics",
                    "Economy",
                    "Technology News",
                ]
            ],
        ];

        foreach ($data as $item) {
            $category = Category::create([
                'name' => $item['category'],
            ]);

            foreach ($item['subcategories'] as $subcategoryName) {
                SubCategory::create([
                    'name' => $subcategoryName,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
