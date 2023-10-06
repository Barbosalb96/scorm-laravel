<?php

use App\Http\Controllers\ScormController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// routes/web.php
Route::get('/scorm/import', [ScormController::class, "importForm"])->name('scorm.import');
Route::post('/scorm/import', [ScormController::class, "import"])->name('scorm.import.post');
