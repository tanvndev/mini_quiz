<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $repositoryBindings = [
        // Base
        'App\Repositories\Interfaces\BaseRepositoryInterface' => 'App\Repositories\BaseRepository',
        // User
        'App\Repositories\Interfaces\User\UserRepositoryInterface' => 'App\Repositories\User\UserRepository',
        // UserCatalogue
        'App\Repositories\Interfaces\User\UserCatalogueRepositoryInterface' => 'App\Repositories\User\UserCatalogueRepository',
        // Permission
        'App\Repositories\Interfaces\Permission\PermissionRepositoryInterface' => 'App\Repositories\Permission\PermissionRepository',
        // Province
        'App\Repositories\Interfaces\Location\ProvinceRepositoryInterface' => 'App\Repositories\Location\ProvinceRepository',
        // District
        'App\Repositories\Interfaces\Location\DistrictRepositoryInterface' => 'App\Repositories\Location\DistrictRepository',
        // Topic
        'App\Repositories\Interfaces\Topic\TopicRepositoryInterface' => 'App\Repositories\Topic\TopicRepository',
        // Question
        'App\Repositories\Interfaces\Question\QuestionRepositoryInterface' => 'App\Repositories\Question\QuestionRepository',
        // Quizz
        'App\Repositories\Interfaces\Quizz\QuizzRepositoryInterface' => 'App\Repositories\Quizz\QuizzRepository',
        // Result
        'App\Repositories\Interfaces\Quizz\ResultRepositoryInterface' => 'App\Repositories\Quizz\ResultRepository',

    ];

    public function register(): void
    {
        foreach ($this->repositoryBindings as $key => $value) {
            $this->app->bind($key, $value);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
