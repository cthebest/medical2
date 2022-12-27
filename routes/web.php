<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia('Public/Index');
});

Route::get('/contacts', [ContactController::class, 'create'])->name('contacts');
Route::post('/contacts', [ContactController::class, 'send'])->name('contacts.send');

Route::prefix('articles')->group(function () {
    Route::get('/', function () {
        dd(request()->all());
        return "Hola artículos";
    })->name('articles');

    Route::get('{id}', function ($id) {
        return "Hola artículo:" . $id;
    })->name('articles.id');
});


Route::get('menu-items/get-all', [PublicController::class, 'getMenuItems'])
    ->name('menu-items.get-all');

Route::get('available-times', [AgendaController::class, 'getAvailableTimes'])
    ->name('available-times');


    