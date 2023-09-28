<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;
use Tests\AuthenticatedRequestTest;

class ListProductsTest extends AuthenticatedRequestTest
{
    protected function getRoute(): string
    {
        return route('products.list');
    }

    protected function getMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function testSuccessWithoutFilter(): void
    {
        $products = Product::factory(3)->create();
        $response = $this->checkRequestHasCode();

        $resultItems = $this->collectItemsFromResponse($response, 'props.paginator.data');
        $this->assertResponseComponent($response);
        $this->assertCount($products->count(), $resultItems);
        $this->assertCollectionsContainSameValues($products->pluck('id'), $resultItems->pluck('id'));
    }

    public function testSuccessWithSearchFilter(): void
    {
        $search = Str::random(3);
        $searchableProducts = Product::factory(2)->create([
            'title' => $this->faker->word . $search . $this->faker->word
        ]);
        $extraProducts = Product::factory(2)->create();

        $response = $this->checkRequestHasCode([
            'search' => $search
        ]);

        $resultItems = $this->collectItemsFromResponse($response, 'props.paginator.data');
        $this->assertResponseComponent($response);
        $this->assertCount($searchableProducts->count(), $resultItems);
        $this->assertCollectionsContainSameValues($searchableProducts->pluck('id'), $resultItems->pluck('id'));
    }

    public function testSuccessWithCategoryIdFilter(): void
    {
        $categoryId = Category::factory()->create()->getKey();
        $searchableProducts = Product::factory(2)->create([
            'category_id' => $categoryId
        ]);
        $extraProducts = Product::factory(2)->create();

        $response = $this->checkRequestHasCode([
            'category_id' => $categoryId
        ]);

        $resultItems = $this->collectItemsFromResponse($response, 'props.paginator.data');
        $this->assertResponseComponent($response);
        $this->assertCount($searchableProducts->count(), $resultItems);
        $this->assertCollectionsContainSameValues($searchableProducts->pluck('id'), $resultItems->pluck('id'));
    }

    public function testSuccessWithAllFilters(): void
    {
        $search = Str::random(3);
        $categoryId = Category::factory()->create()->getKey();
        $searchableProducts = Product::factory(2)->create([
            'title' => $this->faker->word . $search . $this->faker->word,
            'category_id' => $categoryId
        ]);
        $extraProducts = Product::factory(2)->create();

        $response = $this->checkRequestHasCode([
            'search' => $search,
            'category_id' => $categoryId,
        ]);

        $resultItems = $this->collectItemsFromResponse($response, 'props.paginator.data');
        $this->assertResponseComponent($response);
        $this->assertCount($searchableProducts->count(), $resultItems);
        $this->assertCollectionsContainSameValues($searchableProducts->pluck('id'), $resultItems->pluck('id'));
    }
}
