<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\CreateUpdateProductRequest;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Tests\RequestRulesTest;

class CreateUpdateProductRequestTest extends RequestRulesTest
{
    protected function getRequestClass(): string
    {
        return CreateUpdateProductRequest::class;
    }

    protected function getValidData(): array
    {
        return [
            'title' => Str::random($this->faker->numberBetween(3, 255)),
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(),
            'category_id' => Category::factory()->create()->getKey(),
            'logo' => UploadedFile::fake()->image($this->faker->word . '.png'),
            'logo_updated' => $this->faker->boolean
        ];
    }

    protected function validationSuccessDataProvider(): array
    {
        return [
            'description is null' => [
                'description' => null
            ],
            'logo is null' => [
                'logo' => null
            ]
        ];
    }

    protected function failedValidationDataProvider(): array
    {
        return [
            'title is null' => [
                'title' => null
            ],
            'title smaller than 2 chars' => [
                'title' => Str::random(2)
            ],
            'title greater than 255 chars' => [
                'title' => Str::random(256)
            ],
            'description smaller than 3 chars' => [
                'description' => Str::random(2)
            ],
            'description greater than 1000 chars' => [
                'description' => Str::random(1001)
            ],
        ];
    }
}
