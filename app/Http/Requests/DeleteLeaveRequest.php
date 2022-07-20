<?php

namespace App\Http\Requests;

final class DeleteLeaveRequest extends AbstractApiRequest
{
    public function authorize(): bool
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);

        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer','exists:tree_leaves,id'],
        ];
    }
}
