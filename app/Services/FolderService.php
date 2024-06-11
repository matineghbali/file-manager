<?php

namespace App\Services;

use Exception;
use App\Models\Folder;
use App\DTO\CreateFolderDTO;
use App\Services\Contracts\BaseService;
use App\Repositories\Contracts\FolderRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class FolderService
 *
 * @package App\Services
 */
class FolderService extends BaseService
{
    /**
     * FolderService constructor.
     *
     * @param FolderRepositoryInterface $repository
     *
     * @throws BindingResolutionException
     */
    public function __construct(FolderRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param CreateFolderDTO $dto
     *
     * @return Folder
     *
     * @throws Exception
     */
    public function createFolder(CreateFolderDTO $dto): Folder
    {
        return $this->repository->create($dto->toArray());
    }
}
