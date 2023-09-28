<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use Symfony\Component\HttpFoundation\Request;
use Tests\AuthenticatedRequestTest;

class CreateProductTest extends AuthenticatedRequestTest
{
    protected function getRoute(): string
    {
        return route('products.create');
    }

    protected function getMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function testSuccess(): void
    {
        $categories = Category::factory(3)->create();

        $response = $this->checkRequestHasCode();
        $responseCategories = $this->collectItemsFromResponse($response, 'categories');
        $this->assertResponseComponent($response, 'CreateProduct');
        $this->assertCount($categories->count(), $responseCategories);
        $this->assertCollectionsContainSameValues($categories->pluck('id'), $responseCategories->pluck('id'));
    }
}
