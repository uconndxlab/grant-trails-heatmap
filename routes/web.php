<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GrantTrailsController;

Route::get('/', [GrantTrailsController::class, 'index'])->name('home');
