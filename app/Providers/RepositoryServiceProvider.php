<?php

namespace App\Providers;

use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\ToDoListRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Repositories\ToDoListRepository;
use App\Repositories\UserRepository;
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
	    $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
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
