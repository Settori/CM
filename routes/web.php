<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DutyController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!

'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,


|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [SiteController::class, 'chat_view'])->name('main');
    Route::get('/chat', [SiteController::class, 'chat_view'])->name('chat');
    Route::get('/images', [SiteController::class, 'images_view'])->name('images');
    Route::get('/settings', [SiteController::class, 'settings_view'])->name('settings');
    Route::get('/events', [SiteController::class, 'events_view'])->name('events');



    Route::post('/send', [ChatController::class, 'broadcast'])->name('send.message');
    Route::post('/reload', [ChatController::class, 'reloadPage'])->name('reload.page');
    Route::post('/add/point/{duty}', [DutyController::class, 'addPoint'])->name('add.point');
    Route::post('/remove/point/{id}', [DutyController::class, 'removePoint'])->name('remove.point');
    Route::post('/save/image', [SiteController::class, 'saveImage'])->name('save.image');
    Route::post('/edit/user', [UserController::class, 'editUser'])->name('edit.user');
    Route::post('/add/event', [SiteController::class, 'addEvent'])->name('add.event');
    Route::post('/remove/event/{event}', [SiteController::class, 'removeEvent'])->name('remove.event');
    Route::post('/remove/image/{image}', [SiteController::class, 'removeImage'])->name('remove.image');
});
Route::post('/get/image', [SiteController::class, 'getImage'])->name('get.image');
Route::get('/cm', [SiteController::class, 'cm_view'])->name('cm');
Route::post('/get/weather', [SiteController::class, 'getWeather'])->name('get.weather');
Route::post('/get/event', [SiteController::class, 'getEvent'])->name('get.event');



require __DIR__.'/auth.php';
