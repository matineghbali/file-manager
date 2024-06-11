<?php

namespace App\DTO;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\Contracts\FromRequestDTOInterface;

/**
 * Class MoveFilesDTO
 *
 * @property-read int|null $folder_id
 * @property-read array $file_ids
 *
 * @package App\DTO
 */
class MoveFilesDTO implements FromRequestDTOInterface
{
    /**
     * MoveFilesDTO constructor.
     *
     * @param int|null $folder_id
     * @param array $file_ids
     */
    public function __construct(
        public ?int $folder_id = 0,
        public array $file_ids = [],
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
            file_ids: $request->input('file_ids'),
        );
    }
}
