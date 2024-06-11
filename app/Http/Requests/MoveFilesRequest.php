<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MoveFilesRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'new_folder_id' => ['nullable', 'exists:folders,id'],
            'file_ids' => ['required', 'array'],
            'file_ids.*' => ['required', 'exists:files,id']
        ];
    }
}
