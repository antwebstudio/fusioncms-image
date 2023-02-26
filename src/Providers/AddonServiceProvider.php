<?php

namespace Addons\Image\Providers;

use Fusion;
use Fusion\Facades\Menu;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends \Fusion\Providers\AddonServiceProvider
{
    /**
     * Register any addon services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Bootstrap any addon services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $addonName = 'Image';
        $basePath = dirname(dirname(dirname(__FILE__)));

        if (!File::isDirectory(public_path("addons"))) {
            File::makeDirectory(public_path("addons"));
        }

        if (!File::exists(public_path("addons/{$addonName}"))) {
            // Create symlink
            File::link(
                "{$basePath}/public",
                public_path("addons/{$addonName}")
            );
        }
        
        Fusion::asset('/addons/Image/js/app.js');
        // fieldtypes()->register(\Addons\Image\Fieldtypes\ImageFieldtype::class);

        $this->registerFileModel();
    }

    protected function registerFileModel()
    {
        $this->app->bind(\Fusion\Models\File::class, \Addons\Image\Models\File::class);
    }
}