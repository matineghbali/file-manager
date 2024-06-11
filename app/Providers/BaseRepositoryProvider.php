<?php

namespace App\Providers;

use App\Repositories\FileRepository;
use App\Repositories\FolderRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Repositories\Contracts\FileRepositoryInterface;
use App\Repositories\Contracts\FolderRepositoryInterface;

/**
 * Class BaseRepositoryProvider
 *
 * @package App\Providers
 */
class BaseRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        /**
         * Root Repository
         */
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(FolderRepositoryInterface::class, FolderRepository::class);
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);
    }
}
