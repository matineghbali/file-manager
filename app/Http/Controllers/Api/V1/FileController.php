<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\File;
use App\Models\Folder;
use App\DTO\MoveFilesDTO;
use App\DTO\CreateFileDTO;
use Illuminate\Http\Request;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Http\Requests\MoveFilesRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateFileRequest;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class FileController
 *
 * @package App\Http\Controllers\Api\V1
 */
class FileController extends Controller
{

    /**
     * FileController constructor.
     *
     * @param FileService $fileService
     */
    public function __construct(private FileService $fileService)
    {
    }

    /**
     * @param Folder $folder
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Folder $folder, Request $request): JsonResponse
    {
        return $this->successResponse(
            trans('messages.successfully'),
            $this->fileService->getList($folder, $request)
        );
    }

    /**
     * @param File $file
     *
     * @return JsonResponse
     */
    public function show(File $file): JsonResponse
    {
        return $this->successResponse(
            trans('messages.successfully'),
            $this->fileService->getView($file, FileResource::class)
        );
    }

    /**
     * @param File $file
     *
     * @return BinaryFileResponse
     */
    public function download(File $file): BinaryFileResponse
    {
        return response()->file(Storage::path($file->path));
    }

    /**
     * @param CreateFileRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateFileRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $dto = app()->make(CreateFileDTO::class)->fromRequest($request);
            $file = $this->fileService->createFile($dto);
            DB::commit();

            return $this->successResponse(
                trans('messages.successfully'),
                $this->fileService->getView($file, FileResource::class)
            );
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }

    /**
     * @param File $file
     *
     * @return JsonResponse
     */
    public function destroy(File $file): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->fileService->softDelete($file);
            DB::commit();

            return $this->successResponse(
                trans('messages.successfully')
            );
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }

    /**
     * @param File $file
     *
     * @return JsonResponse
     */
    public function forceDelete(File $file): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->fileService->forceDelete($file);
            DB::commit();

            return $this->successResponse(
                trans('messages.successfully')
            );
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }

    /**
     * @param MoveFilesRequest $request
     *
     * @return JsonResponse
     */
    public function moveFiles(MoveFilesRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $dto = app()->make(MoveFilesDTO::class)->fromRequest($request);
            $this->fileService->moveFiles($dto);
            DB::commit();

            return $this->successResponse(
                trans('messages.successfully')
            );
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }
}
