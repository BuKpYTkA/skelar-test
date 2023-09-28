<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;
use Tests\AuthenticatedRequestTest;

class SaveProductTest extends AuthenticatedRequestTest
{
    private readonly Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
    }

    protected function getRoute(): string
    {
        return route('products.save', $this->product);
    }

    protected function getMethod(): string
    {
        return Request::METHOD_POST;
    }

    public function testSuccess(): void
    {
        $title = Str::random($this->faker->numberBetween(3, 255));
        $price = $this->faker->numberBetween();
        $description = $this->faker->sentence;
        $categoryId = Category::factory()->create()->getKey();
        $logo = UploadedFile::fake()->image($this->faker->word . '.png');
        $response = $this->checkRequestHasCode([
            'title' => $title,
            'price' => $price,
            'description' => $description,
            'category_id' => $categoryId,
            'logo' => $logo,
            'logo_updated' => true
        ]);

        $this->assertEquals($this->product->getKey(), $response->json('id'));
        $this->assertEquals($title, $response->json('title'));
        $this->assertEquals($description, $response->json('description'));
        $this->assertEquals($categoryId, $response->json('category_id'));
        $this->assertNotNull($response->json('logo_url'));
    }
}
