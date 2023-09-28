<?php

namespace Tests\Unit\Utils\Repositories;

use App\Http\Requests\GetProductsListRequest;
use App\Models\Category;
use App\Models\Product;
use App\Utils\Interfaces\ProductFilter;
use App\Utils\Repositories\ProductRepository;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    private readonly ProductRepository $productRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository = $this->app->make(ProductRepository::class);
    }

    public function testGetQueryByFilterWithNoParams()
    {
        $products = Product::factory(3)->create();
        $result = $this->productRepository->getQueryByFilter($this->getMockedFilter())->get();

        $this->assertCount($products->count(), $result);
        $this->assertCollectionsContainSameValues($products->pluck('id'), $result->pluck('id'));
    }

    public function testGetQueryByFilterWithSearch(): void
    {
        $search = Str::random(3);
        $searchableProducts = Product::factory(2)->create([
            'title' => $this->faker->word . $search . $this->faker->word
        ]);
        $extraProducts = Product::factory(2)->create();
        $result = $this->productRepository->getQueryByFilter($this->getMockedFilter([
            'search' => $search
        ]))->get();

        $this->assertCount($searchableProducts->count(), $result);
        $this->assertCollectionsContainSameValues($searchableProducts->pluck('id'), $result->pluck('id'));
    }

    public function testGetQueryByFilterWithCategoryId(): void
    {
        $categoryId = Category::factory()->create()->getKey();
        $searchableProducts = Product::factory(2)->create([
            'category_id' => $categoryId
        ]);
        $extraProducts = Product::factory(2)->create();
        $result = $this->productRepository->getQueryByFilter($this->getMockedFilter([
            'category_id' => $categoryId
        ]))->get();

        $this->assertCount($searchableProducts->count(), $result);
        $this->assertCollectionsContainSameValues($searchableProducts->pluck('id'), $result->pluck('id'));
    }

    public function testGetQueryByFilterWithAllParams(): void
    {
        $search = Str::random(3);
        $categoryId = Category::factory()->create()->getKey();
        $searchableProducts = Product::factory(2)->create([
            'title' => $this->faker->word . $search . $this->faker->word,
            'category_id' => $categoryId
        ]);
        $extraProducts = Product::factory(2)->create();
        $result = $this->productRepository->getQueryByFilter($this->getMockedFilter([
            'category_id' => $categoryId,
            'search' => $search
        ]))->get();

        $this->assertCount($searchableProducts->count(), $result);
        $this->assertCollectionsContainSameValues($searchableProducts->pluck('id'), $result->pluck('id'));
    }

    private function getMockedFilter(array $values = []): ProductFilter
    {
        return (new GetProductsListRequest())->merge($values);
    }
}
