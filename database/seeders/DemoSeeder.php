<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();
        $categories = Category::factory(10)->create();
        foreach ($categories as $category) {
            $products = Product::factory(5)->create([
                'user_id' => $user->getKey(),
                'category_id' => $category->getKey()
            ]);
            $products->each(fn(Product $product) => $product
                ->addMedia(Arr::random(glob(resource_path('img/default') . '/*.*')))
                ->preservingOriginal()
                ->toMediaCollection(Product::MEDIA_COLLECTION_LOGO)
            );
        }
    }
}
