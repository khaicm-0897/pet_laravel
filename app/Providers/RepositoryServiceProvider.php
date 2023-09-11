<?php

namespace App\Providers;

use App\Repositories\Admin\AdminUserEloquentRepository;
use App\Repositories\Admin\AdminBlogEloquentRepository;
use App\Contracts\Admin\AdminUserRepositoryInterface;
use App\Contracts\Admin\AdminBlogRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $class) {
            $this->app->singleton($interface, $class);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * The repository mappings for the application.
     *
     * @var array
     */
    protected $repositories = [
        // Admin
        AdminUserRepositoryInterface::class => AdminUserEloquentRepository::class,
        AdminBlogRepositoryInterface::class => AdminBlogEloquentRepository::class,
    ];
}
