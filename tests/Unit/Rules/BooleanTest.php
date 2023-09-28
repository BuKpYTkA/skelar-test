<?php

namespace Tests\Unit\Rules;

use App\Rules\Boolean;
use Exception;
use Tests\TestCase;

class BooleanTest extends TestCase
{
    private readonly \App\Rules\Boolean $rule;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rule = new Boolean;
    }

    public function testPassesOnBoolean(): void
    {
        $this->expectNotToPerformAssertions();
        $this->validateRule($this->faker->boolean);
    }

    public function testPassesOnDigit(): void
    {
        $this->expectNotToPerformAssertions();
        $this->validateRule($this->faker->numberBetween(0, 1));
    }

    public function testPassesOnBooleanAsString(): void
    {
        $this->expectNotToPerformAssertions();
        $this->validateRule($this->faker->boolean ? 'true' : 'false');
    }

    public function testFailsOnNull(): void
    {
        $this->expectException(Exception::class);
        $this->validateRule(null);
    }

    public function testFailsOnDigitLargerThanOne(): void
    {
        $this->expectException(Exception::class);
        $this->validateRule($this->faker->numberBetween(2));
    }

    public function testFailsOnString(): void
    {
        $this->expectException(Exception::class);
        $this->validateRule($this->faker->word);
    }

    private function validateRule(mixed $value): void
    {
        $this->rule->validate('key', $value, fn() => throw new Exception());
    }
}
