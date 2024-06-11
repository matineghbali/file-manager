<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'folder' => new FolderThumbnailResource($this->folder),
            'name' => $this->name,
            'type' => $this->type,
            'size' => $this->size,
            'link' => route('files.download', ['file' => $this->access_token]),
        ];
    }
}
