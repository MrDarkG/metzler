<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here you can register routes for guests
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. 
|
*/



/* Guest Routes*/

Route::get('/',[GuestController::class,"index"])->name("index");
	/* validating all id parametters in "RouteServiceProvider" in "boot" function. "id" must be an integer */
Route::get("/show/{id}",[GuestController::class,"show"])->name("show");

/* end Guest Routes*/