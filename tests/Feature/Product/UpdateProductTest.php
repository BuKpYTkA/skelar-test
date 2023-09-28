<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Request;
use Tests\AuthenticatedRequestTest;

class UpdateProductTest extends AuthenticatedRequestTest
{
    private readonly Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
    }

    protected function getRoute(): string
    {
        return route('products.update', $this->product);
    }

    protected function getMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function testSuccess(): void
    {
        Category::factory(3)->create();
        $categories = Category::all();

        $response = $this->checkRequestHasCode();
        $responseCategories = $this->collectItemsFromResponse($response, 'categories');
        $responseProduct = $this->collectItemsFromResponse($response, 'product');
        $this->assertResponseComponent($response, 'UpdateProduct');
        $this->assertCount($categories->count(), $responseCategories);
        $this->assertCollectionsContainSameValues($categories->pluck('id'), $responseCategories->pluck('id'));
        $this->assertEquals($this->product->getKey(), $responseProduct->get('id'));
    }
}
