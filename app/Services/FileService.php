<?php

namespace App\Services;

use Exception;
use App\Models\File;
use App\Models\Folder;
use App\DTO\MoveFilesDTO;
use App\DTO\CreateFileDTO;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Resources\FileResource;
use Illuminate\Support\Facades\Storage;
use App\Services\Contracts\BaseService;
use App\Repositories\Contracts\FileRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class FileService
 *
 * @package App\Services
 */
class FileService extends BaseService
{
    /**
     * FileService constructor.
     *
     * @param FileRepositoryInterface $repository
     *
     * @throws BindingResolutionException
     */
    public function __construct(FileRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param Folder $folder
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function getList(Folder $folder, Request $request): AnonymousResourceCollection
    {
        $files = $this->repository->getByFolderIdAndQueryParam($folder->id, $request->all());

        return FileResource::collection($files);
    }

    /**
     * @param CreateFileDTO $dto
     *
     * @return File
     *
     * @throws Exception
     */
    public function createFile(CreateFileDTO $dto): File
    {
        $path = $this->storeFile($dto->attachment);
        if (! $path) {
            throw new Exception(trans('messages.can_not_upload_file'));
        }

        return $this->repository->create($this->prepareCreateData($dto, $path));
    }

    /**
     * @param File $file
     *
     * @return void
     */
    public function softDelete(File $file): void
    {
        $this->repository->delete($file);
    }

    /**
     * @param File $file
     *
     * @return void
     */
    public function forceDelete(File $file): void
    {
        Storage::delete($file->path);
        $this->repository->forceDelete($file);
    }

    /**
     * @param MoveFilesDTO $dto
     *
     * @return void
     *
     * @throws Exception
     */
    public function moveFiles(MoveFilesDTO $dto): void
    {
        $result = $this->repository->updateFolderIdByIds($dto->file_ids, $dto->folder_id);
        if (! $result){
            throw new Exception(trans('messages.update_many_files_not_working'), 406);
        }
    }

    /**
     * @param UploadedFile $attachment
     *
     * @return false|string
     */
    private function storeFile(UploadedFile $attachment): false|string
    {
        return $attachment->store('files');
    }

    /**
     * @param CreateFileDTO $dto
     * @param string $path
     *
     * @return array
     *
     * @throws Exception
     */
    private function prepareCreateData(CreateFileDTO $dto, string $path): array
    {
        $name = $dto->attachment->getClientOriginalName();

        return [
            'folder_id' => $dto->folder_id,
            'name' => $name,
            'type' => $this->getFileType($name),
            'size' => $dto->attachment->getSize(),
            'access_token' => $this->generateAccessToken(),
            'path' => $path
        ];
    }

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws Exception
     */
    private function getFileType(string $name): string
    {
        $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        return match ($extension) {
            'jpg', 'jpeg', 'png', 'gif', 'bmp' => File::IMAGE_TYPE,
            'mp4', 'avi', 'mov', 'mkv' => File::VIDEO_TYPE,
            'mp3', 'wav', 'aac', 'flac' => File::AUDIO_TYPE,
            'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt' => File::DOCUMENT_TYPE,
            default => throw new Exception(trans('messages.type_of_file_is_invalid'), 406),
        };
    }

    /**
     * @return string
     */
    private function generateAccessToken(): string
    {
        return time(). Str::random('6');
    }
}
