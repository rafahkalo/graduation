<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors()->all();

        throw new HttpResponseException(
            $this->errorResponse($errors, JsonResponse::HTTP_BAD_REQUEST)
        );
    }

    /**
     * Get all the input and files for the request including route parameters.
     *
     * @param  array|mixed|null  $keys
     */
    public function all($keys = null): array
    {
        return array_replace_recursive(
            parent::all(),
            $this->route()?->parameters() ?? []
        );
    }

    /**
     * Create JSON response for errors.
     */
    private function errorResponse(array $errors, int $statusCode): JsonResponse
    {
        return response()->json([
            'success' => false,
            'messages' => $errors,
        ], $statusCode);
    }
}
