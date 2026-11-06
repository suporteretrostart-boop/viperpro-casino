<?php


use App\Http\Controllers\Layouts\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', ApplicationController::class);

Route::get('{view}', ApplicationController::class)->where('view', '(.*)');
