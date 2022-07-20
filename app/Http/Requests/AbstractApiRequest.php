<?php


namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

/**
 * Class AbstractApiRequest
 * @package App\Modules\Core\Http\Requests
 */
class AbstractApiRequest extends FormRequest
{

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $this->throwValidationException($validator->errors()->toArray(), 400);
    }

    /**
     * Custom validation exception
     *
     * @param array $errors
     * @param int   $status
     *
     * @return void
     *
     * @throws HttpResponseException
     */
    public function throwValidationException(array $errors, int $status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY): void
    {
        throw new HttpResponseException(
            response()->json([
                 'message' => 'The given data was invalid.',
                 'data' => [],
                 'error' => $errors,
                 'status' => $status,
             ], $status)
        );
    }
}
