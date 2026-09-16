<?php

declare(strict_types=1);

namespace Core\Http;

use Core\Exceptions\AuthorizationException;

/**
 * Base class for request objects: validation rules + authorization.
 */
abstract class FormRequest
{
    /** @return array<string, string> field => rule string */
    abstract public function rules(): array;

    public function authorize(Request $request): bool
    {
        return true;
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [];
    }

    /** @return array<string, mixed> validated data */
    public function handle(Request $request): array
    {
        if (!$this->authorize($request)) {
            throw new AuthorizationException();
        }

        return $request->validate($this->rules());
    }
}
