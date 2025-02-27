<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GrantTrailsController;

Route::get('/totals', [GrantTrailsController::class, 'totals']);