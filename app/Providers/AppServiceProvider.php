<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Services\FileSystem\QiniuAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * 注册新的云存储驱动 七牛
         * Storage::disk('qiniu')->write('test/logo.png', storage_path('app/public/images/logo.png'));
         * Storage::disk('qiniu_cdns')->write('test/logo.png', storage_path('app/public/images/logo.png'));
         */
        Storage::extend('qiniu', function ($app, $config) {
            return new Filesystem(new QiniuAdapter('qiniu', ''));
        });
        Storage::extend('qiniu_cdns', function ($app, $config) {
            return new Filesystem(new QiniuAdapter('qiniu_cdns', ''));
        });

        // 用户表 `users` 监听
        User::observe(UserObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
