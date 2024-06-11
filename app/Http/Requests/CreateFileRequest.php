<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFileRequest extends FormRequest
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
            'folder_id' => ['nullable', 'exists:folders,id'],
            'attachment' => ['required', 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,mp4,mov,avi,mp3,wav,jpg,jpeg,png,gif,bmp,mkv,aac,flac,txt']
        ];
    }
}
