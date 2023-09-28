<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Symfony\Component\HttpFoundation\Request;
use Tests\AuthenticatedRequestTest;

class DeleteProductTest extends AuthenticatedRequestTest
{
    private readonly Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
    }

    protected function getRoute(): string
    {
        return route('products.delete', $this->product);
    }

    protected function getMethod(): string
    {
        return Request::METHOD_DELETE;
    }

    public function testSuccess(): void
    {
        $this->checkRequestHasCode();
        $this->assertNull(Product::query()->find($this->product->getKey()));
    }
}
