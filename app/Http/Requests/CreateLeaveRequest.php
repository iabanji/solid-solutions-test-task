<?php

namespace App\Http\Requests;

final class CreateLeaveRequest extends AbstractApiRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => ['integer','exists:tree_leaves,id'],
            'title' => ['required', 'string', 'max:60']
        ];
    }
}
