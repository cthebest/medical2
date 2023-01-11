<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PublicArticleController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicServiceController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia('Public/Index');
});

Route::get('/contacts', [ContactController::class, 'create'])->name('contacts');
Route::post('/contacts', [ContactController::class, 'send'])->name('contacts.send');

Route::prefix('articles')->controller(PublicArticleController::class)->group(function () {
    Route::get('/', 'index')->name('articles');
    Route::get('{id}', 'show')->name('articles.id');
    Route::get('/article/{article}', 'getArticle')->name('articles.get');
});


Route::get('menu-items/get-all', [PublicController::class, 'getMenuItems'])
    ->name('menu-items.get-all');

Route::get('available-times', [AgendaController::class, 'getAvailableTimes'])
    ->name('available-times');

Route::get('services/all', [PublicServiceController::class, 'index'])->name('services.getAll');


