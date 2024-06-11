<?php

namespace App\Repositories\Contracts;

use App\Models\File;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface FileRepositoryInterface
 *
 * @package App\Repositories\Contracts
 */
interface FileRepositoryInterface
{
    /**
     * @param array $ids
     * @param int $folderId
     *
     * @return int
     */
    public function updateFolderIdByIds(array $ids, int $folderId): int;

    /**
     * @param File $file
     *
     * @return bool|null
     */
    public function forceDelete(File $file): ?bool;

    /**
     * @param string $folderId
     * @param array $params
     *
     * @return Collection
     */
    public function getByFolderIdAndQueryParam(string $folderId, array $params): Collection;
}
