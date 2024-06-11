<?php

namespace App\DTO;

use Exception;
use App\Models\Folder;
use Illuminate\Database\Eloquent\Model;
use App\DTO\Contracts\ToArrayDTOInterface;
use Illuminate\Foundation\Http\FormRequest;
use App\DTO\Contracts\FromRequestDTOInterface;

/**
 * Class CreateFolderDTO
 *
 * @property-read int|null $parent_id
 * @property-read string|null $name
 *
 * @package App\DTO
 */
class CreateFolderDTO implements FromRequestDTOInterface, ToArrayDTOInterface
{
    /**
     * CreateFolderDTO constructor.
     *
     * @param int|null $parent_id
     * @param string|null $name
     */
    public function __construct(
        public ?int $parent_id = 0,
        public ?string $name = null,
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
            parent_id: $request->input('parent_id'),
            name: $request->input('name'),
        );
    }

    /**
     * @param Folder|Model|null $model
     *
     * @return array
     *
     * @throws Exception
     */
    public function toArray(?Model $model = null): array
    {
        return [
            'parent_id' => $this->parent_id,
            'name' => $this->name,
        ];
    }
}
