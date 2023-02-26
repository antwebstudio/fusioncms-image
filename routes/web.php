<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your addon. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('thumbnail/{uuid}/{name}/{w}x{h}_{fit}', '\Fusion\Http\Controllers\Web\FileController@index')->middleware(\Addons\Image\Http\Middleware\ImageManipulatorParams::class);
Route::get('thumbnail/{uuid}/{name}/x{h}_{fit}', '\Fusion\Http\Controllers\Web\FileController@index')->middleware(\Addons\Image\Http\Middleware\ImageManipulatorParams::class);
Route::get('thumbnail/{uuid}/{name}/{w}_{fit}', '\Fusion\Http\Controllers\Web\FileController@index')->middleware(\Addons\Image\Http\Middleware\ImageManipulatorParams::class);

Route::get('thumbnail/{uuid}/{name}/{w}x{h}', '\Fusion\Http\Controllers\Web\FileController@index')->middleware(\Addons\Image\Http\Middleware\ImageManipulatorParams::class);
Route::get('thumbnail/{uuid}/{name}/x{h}', '\Fusion\Http\Controllers\Web\FileController@index')->middleware(\Addons\Image\Http\Middleware\ImageManipulatorParams::class);
Route::get('thumbnail/{uuid}/{name}/{w}', '\Fusion\Http\Controllers\Web\FileController@index')->middleware(\Addons\Image\Http\Middleware\ImageManipulatorParams::class);
Route::get('file/{uuid}/{name}', '\Fusion\Http\Controllers\Web\FileController@index');