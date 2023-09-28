<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions, WithFaker;

    protected function assertCollectionsContainSameValues(Collection $expected, Collection $actual): void
    {
        $result = $expected->count() === $actual->count();

        if ($result) {
            foreach ($expected as $item) {
                if (!$result = ($actual->contains($item))) {
                    break;
                }
            }
        }

        $this->assertTrue($result, 'Failed Asserting that collection ' . $actual . ' is same as ' . $expected);
    }

    protected function assertResponseComponent(TestResponse $response): void
    {
        $this->assertEquals('Products', $this->getViewData($response, 'component'));
    }

    protected function collectItemsFromResponse(TestResponse $response, $key): Collection
    {
        return collect($this->getViewData($response, $key));
    }

    protected function getViewData(TestResponse $response, string $key): mixed
    {
        return Arr::get($response->viewData('page'), $key);
    }
}
