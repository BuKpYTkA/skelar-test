<?php

namespace Tests;

use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AuthenticatedRequestTest extends TestCase
{
    protected readonly User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    abstract protected function getRoute(): string;

    abstract protected function getMethod(): string;

    public function testUnauthenticated(): void
    {
        auth()->logout();
        $this->checkRequestHasCode([], Response::HTTP_UNAUTHORIZED);
    }

    protected function checkRequestHasCode(array $params = [], int $code = Response::HTTP_OK): TestResponse
    {
        $response = $this->json($this->getMethod(), $this->getRoute(), $params);
        $response->assertStatus($code);

        return $response;
    }
}
