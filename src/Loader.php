<?php

namespace Addons\ExampleAddon;

use Fusion\Facades\Menu;
use Illuminate\Http\Request;

class Loader
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function menu()
    {
        $slug = 'example-addon';

        if (!Menu::has("admin.{$slug}")) {
            Menu::set('admin.addons', [
                'title'   => 'Addons',
                'divider' => true,
            ]);
        }

        Menu::set("admin.{$slug}", [
            'title' => 'ExampleAddon',
            'to'    => '/example-addon',
            'icon'  => 'grip-horizontal',
        ]);
    }
}
