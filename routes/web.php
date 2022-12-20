<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/stats_journalieres', [HomeController::class, 'stats_journalieres'])->name('stats_journalieres');
Route::get('/stats_journalieres_data', [HomeController::class, 'stats_journalieres_data'])->name('stats_journalieres_data');

Route::get('/declarations', [HomeController::class, 'declarations'])->name('declarations');
Route::get('/paiements', [HomeController::class, 'paiements'])->name('paiements');
