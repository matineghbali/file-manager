<?php

namespace App\Repositories;

use App\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\FileRepositoryInterface;

/**
 * Class FileRepository
 *
 * @package App\Repositories
 */
class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    /**
     * FileRepository constructor.
     *
     * @param File $model
     */
    public function __construct(File $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $ids
     * @param int $folderId
     *
     * @return int
     */
    public function updateFolderIdByIds(array $ids, int $folderId): int
    {
        return $this->model->query()
            ->whereIn('id', $ids)
            ->update(['folder_id' => $folderId]);
    }

    /**
     * @param File $file
     *
     * @return bool|null
     */
    public function forceDelete(File $file): ?bool
    {
        return $file->forceDelete();
    }

    /**
     * @param string $folderId
     * @param array $params
     *
     * @return Collection
     */
    public function getByFolderIdAndQueryParam(string $folderId, array $params): Collection
    {
        return $this->model->query()
            ->where('folder_id', $folderId)
            ->when(isset($params['uploaded_date']), function(Builder $builder) use($params){
                return $builder->whereDate('created_at', '=', $params['uploaded_date']);
            })
            ->when(isset($params['name']), function(Builder $builder) use($params){
                return $builder->where('name', 'like', "%" . $params['name'] . "%");
            })
            ->when(isset($params['is_deleted']), function(Builder $builder){
                return $builder->onlyTrashed();
            })
            ->get();
    }
}
