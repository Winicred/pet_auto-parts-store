<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get("/search", [SearchController::class, "externalSearch"])->name('api.search');
Route::get("/global-search", [SearchController::class, "globalSearch"])->name('api.global_search');
Route::get("/models/search/{id}", [SearchController::class, "searchModelsByCarId"])->name('api.models.search');
