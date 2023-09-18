<?php

use Illuminate\Support\Facades\Route;
use Modules\Video\Http\Controllers\VideoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('section/{section}/videos', VideoController::class)->middleware(['auth:teacher', 'Verify:teacher']);
