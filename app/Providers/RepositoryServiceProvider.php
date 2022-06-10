<?php

namespace App\Providers;

use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\ToDoListRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Repositories\ToDoListRepository;
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
	    $this->app->bind(ToDoListRepositoryInterface::class, ToDoListRepository::class);
	    $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
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
}
