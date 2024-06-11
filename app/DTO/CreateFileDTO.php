<?php

namespace App\DTO;

use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Http\FormRequest;
use App\DTO\Contracts\FromRequestDTOInterface;

/**
 * Class CreateFileDTO
 *
 * @property-read int|null $folder_id
 * @property-read UploadedFile|UploadedFile[]|array|null $attachment
 *
 * @package App\DTO
 */
class CreateFileDTO implements FromRequestDTOInterface
{
    /**
     * CreateFileDTO constructor.
     *
     * @param int|null $folder_id
     * @param array|UploadedFile|UploadedFile[]|null $attachment
     */
    public function __construct(
        public ?int               $folder_id = 0,
        public array|UploadedFile $attachment = [],
    ) {
    }

    /**
     * @param FormRequest $request
     *
     * @return FromRequestDTOInterface
     */
    public function fromRequest(FormRequest $request): FromRequestDTOInterface
    {
        return new self(
            folder_id: $request->input('folder_id'),
            attachment: $request->file('attachment'),
        );
    }
}
