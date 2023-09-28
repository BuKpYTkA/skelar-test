<?php

namespace Tests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psy\Util\Json;

abstract class RequestRulesTest extends TestCase
{
    protected Request $request;
    protected array $validData;

    protected function setUp(): void
    {
        parent::setUp();

        $requestClass = $this->getRequestClass();
        $this->request = (new $requestClass());
        $this->validData = $this->getValidData();
    }

    abstract protected function getRequestClass(): string;

    abstract protected function getValidData(): array;

    public function testValidationFails(): void
    {
        foreach ($this->failedValidationDataProvider() as $key => $data) {
            $this->checkValidationFails($key, $this->getRequestData($data));
        }

        $this->assertTrue(true);
    }

    public function testValidationSuccess(): void
    {
        $requestData = $this->validationSuccessDataProvider() ? $this->validationSuccessDataProvider() : [$this->getRequestData()];
        foreach ($requestData as $key => $data) {
            $this->checkValidationSucceeds($key, $this->getRequestData($data));
        }

        $this->assertTrue(true);
    }

    protected function checkValidationFails(int|string $key, array $attributes = [])
    {
        $this->request->merge($attributes);
        $validator = Validator::make($attributes, $this->request->rules());
        $this->assertTrue(
            $validator->fails(),
            "Validation not failed for dataset '$key':  \n\n\n" . Json::encode($attributes, JSON_PRETTY_PRINT)
        );
    }

    protected function checkValidationSucceeds(int|string $key, array $attributes = [])
    {
        $this->request->merge($attributes);
        $validator = Validator::make($attributes, $this->request->rules());
        $this->assertFalse(
            $validator->fails(),
            "Validation not succeeded for dataset '$key':  \n\n\n" . Json::encode($attributes, JSON_PRETTY_PRINT) .
            "\n\n\nValidation Errors: \n\n\n" . Json::encode($validator->errors(), JSON_PRETTY_PRINT)
        );
    }

    protected function failedValidationDataProvider(): array
    {
        return [];
    }

    protected function validationSuccessDataProvider(): array
    {
        return [];
    }

    private function getRequestData(array $merge = []): array
    {
        return array_merge($this->validData, $merge);
    }
}
