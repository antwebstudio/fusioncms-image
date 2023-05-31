<?php

namespace Addons\Image\Providers;

use Fusion;
use Fusion\Facades\Menu;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
        $this->registerCachePath();

        if (!File::exists(public_path("file")) && File::isDirectory(storage_path("app/_cache"))) {
            // Create symlink
            File::link(
                storage_path("app/_cache"),
                public_path("file")
            );
        }

        if (!File::exists(public_path("thumbnail")) && File::isDirectory(storage_path("app/_cache/thumbnail"))) {
            // Create symlink
            File::link(
                storage_path("app/_cache/thumbnail"),
                public_path("thumbnail")
            );
        }
    }

    protected function registerFileModel()
    {
        $this->app->bind(\Fusion\Models\File::class, \Addons\Image\Models\File::class);
    }

    protected function registerCachePath()
    {
        $this->app->bind('glide', function($app, $params) {
            
            $request    = app('request');
            $filesystem = Storage::disk($params['disk'])->getDriver();
      
            return \League\Glide\ServerFactory::create([
                'response'          => new \League\Glide\Responses\LaravelResponseFactory($request),
                'source'            => $filesystem,
                'watermarks'        => $filesystem,
                'cache'             => app('filesystem')->disk('local')->getDriver(),
                'cache_path_prefix' => '.cache',
                'cache_path_callable' => function($path, $params) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $extLength = strlen($ext);
                    if (substr($path, - $extLength) == $ext) {
                        $subPath = substr($path, 0, - $extLength - 1);
                    }
                    $subPath = $path;
      
                    $suffix = '';
                    if (isset($params['w'])) {
                        $suffix .= $params['w'];
                    }
                    if (isset($params['h'])) {
                        $suffix .= 'x'.$params['h'];
                    }
                    if (isset($params['fit'])) {
                        $suffix .= '_'.$params['fit'];
                    }
      
                    if (trim($suffix) != '') {
                        $prefix = '_cache/thumbnail';
                        $suffix = '/'.$suffix;
                    } else {
                        $prefix = '_cache';
                    }
      
                    $pattern = '(.*)\/files\/([a-zA-Z0-9u]+)-(.*)\.(?:jpe?g|gif|png)$';
                    $pattern = 'files/([a-zA-Z0-9u]+)-(.*)';
                    preg_match('#'.$pattern.'#', $subPath, $match);
                    $cachePath = $prefix.'/'.$match[1].'/'.$match[2].$suffix;
                    
                    return $cachePath;
                }
            ]);
        });
    }
}