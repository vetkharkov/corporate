<?php

namespace Corp\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;

use Corp\Article;
use Corp\Permission;
use Corp\Menu;
use Corp\User;

use Corp\Policies\ArticlePolicy;
use Corp\Policies\PermissionPolicy;
use Corp\Policies\MenusPolicy;
use Corp\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        Пример использования
//        'Corp\Model' => 'Corp\Policies\ModelPolicy',
        Article::class    => ArticlePolicy::class,
        Permission::class => PermissionPolicy::class,
        Menu::class       => MenusPolicy::class,
        User::class       => UserPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('VIEW_ADMIN', function ($user) {
            return $user->canDo('VIEW_ADMIN', false);
        });

        $gate->define('VIEW_ADMIN_ARTICLES', function ($user) {
            return $user->canDo('VIEW_ADMIN_ARTICLES', false);
        });

        $gate->define('EDIT_USERS', function ($user) {
            return $user->canDo('EDIT_USERS', false);
        });

        $gate->define('ADD_USERS', function ($user) {
            return $user->canDo('ADD_USERS', false);
        });

        $gate->define('DELETE_USERS', function ($user) {
            return $user->canDo('DELETE_USERS', false);
        });

        $gate->define('VIEW_ADMIN_MENU', function ($user) {
            return $user->canDo('VIEW_ADMIN_MENU', false);
        });

    }
}
