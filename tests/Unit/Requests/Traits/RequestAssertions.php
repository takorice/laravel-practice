<?php

namespace Tests\Unit\Requests\Traits;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

trait RequestAssertions
{
    /**
     * @param FormRequest $request
     * @param string      $field
     * @param array       $dataSets
     */
    protected function assertFieldPass(FormRequest $request, string $field, array $dataSets): void
    {
        collect($dataSets)->each(function ($value, $key) use ($request, $field) {
            $validator = $this->makeValidator($request, $field, $key);
            $this->assertTrue($value ? $validator->passes() : $validator->fails());
        });
    }

    /**
     * @param FormRequest $request
     * @param string      $field
     * @param array       $dataSets
     */
    protected function assertFieldError(FormRequest $request, string $field, array $dataSets): void
    {
        collect($dataSets)->each(function ($value, $key) use ($request, $field) {
            $validator = $this->makeValidator($request, $field, $key);
            $this->assertEquals($value, $validator->errors()->first($field));
        });
    }

    /**
     * @param FormRequest $request
     * @param string      $field
     * @param string      $key
     * @return \Illuminate\Validation\Validator
     */
    protected function makeValidator(FormRequest $request, string $field, string $key): \Illuminate\Validation\Validator
    {
        return Validator::make(
            [$field => $key],
            [$field => $request->rules()[$field]],
            [],
            [$field => $request->attributes()[$field]]
        );
    }
}
