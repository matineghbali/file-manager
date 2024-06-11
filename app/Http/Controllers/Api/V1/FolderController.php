<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\Folder;
use App\DTO\CreateFolderDTO;
use App\Services\FolderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\FolderResource;
use App\Http\Requests\CreateFolderRequest;

/**
 * Class FolderController
 *
 * @package App\Http\Controllers\Api\V1
 */
class FolderController extends Controller
{

    /**
     * FolderController constructor.
     *
     * @param FolderService $folderService
     */
    public function __construct(private FolderService $folderService)
    {
    }

    /**
     * @param Folder $folder
     *
     * @return JsonResponse
     */
    public function show(Folder $folder): JsonResponse
    {
        return $this->successResponse(
            trans('messages.successfully'),
            $this->folderService->getView($folder, FolderResource::class)
        );
    }

    /**
     * @param CreateFolderRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateFolderRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $dto = app()->make(CreateFolderDTO::class)->fromRequest($request);
            $folder = $this->folderService->createFolder($dto);
            DB::commit();

            return $this->successResponse(
                trans('messages.successfully'),
                $this->folderService->getView($folder, FolderResource::class)
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
