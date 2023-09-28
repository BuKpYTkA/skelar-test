<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\GetProductsListRequest;
use Illuminate\Support\Str;
use Tests\RequestRulesTest;

class GetProductListRequestTest extends RequestRulesTest
{
    protected function getRequestClass(): string
    {
        return GetProductsListRequest::class;
    }

    protected function getValidData(): array
    {
        return [];
    }

    protected function validationSuccessDataProvider(): array
    {
        return [
            'search as null' => [
                'search' => null
            ],
            'category_id as null' => [
                'category_id' => null
            ]
        ];
    }

    protected function failedValidationDataProvider(): array
    {
        return [
            'search is greater than 255 chars' => [
                'search' => Str::random(256)
            ],
            'category_id does not exist' => [
                'category_id' => 0
            ]
        ];
    }
}
