<?php

namespace Tests\Unit\Utils\Services;

use App\Models\Product;
use App\Utils\Services\ProductService;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    private readonly ProductService $productService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = $this->app->make(ProductService::class);
    }

    public function testSetLogoAsFile(): void
    {
        /** @var Product $product */
        $product = Product::factory()->create();
        $logo = UploadedFile::fake()->image($this->faker->word);
        $this->productService->setLogo($product, $logo);

        $productLogo = $product->getFirstMedia(Product::MEDIA_COLLECTION_LOGO) ;
        $this->assertNotNull($productLogo);
        $this->assertEquals($productLogo->name, $logo->name);
    }

    public function testSetLogoAsNull(): void
    {
        /** @var Product $product */
        $product = Product::factory()->create();
        $product->addMedia(UploadedFile::fake()->image($this->faker->word))->toMediaCollection(Product::MEDIA_COLLECTION_LOGO);
        $this->productService->setLogo($product);

        $productLogo = $product->getFirstMedia(Product::MEDIA_COLLECTION_LOGO) ;
        $this->assertNull($productLogo);
    }
}
