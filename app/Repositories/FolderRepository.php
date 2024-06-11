<?php

namespace App\Repositories;

use App\Models\Folder;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\FolderRepositoryInterface;

/**
 * Class FolderRepository
 *
 * @package App\Repositories
 */
class FolderRepository extends BaseRepository implements FolderRepositoryInterface
{
    /**
     * FolderRepository constructor.
     *
     * @param Folder $model
     */
    public function __construct(Folder $model)
    {
        parent::__construct($model);
    }
}
