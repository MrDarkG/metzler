<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here you can register routes for user
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web"  middleware group. 
| "user." name of routes and "user/" prefix are also included in RouteServiceProvider.
*/



/* user  Routes*/
Route::middleware(["auth","verified"])->group(function(){
	Route::get('/',[HomeController::class,"index"])->name("index");
	

	Route::get("/settings",[HomeController::class,"profile"])->name("profile");
	Route::post("/update/password",[HomeController::class,"updateuserpassword"])->name("updatepassword");
	Route::post("/update/info",[HomeController::class,"updateuserinformation"])->name("updateinfo");
	/*
		editor routes. admin and editors can reach routes
	*/

		Route::middleware(["role:writer|admin"])->group(function(){
			Route::get("/create/post",[HomeController::class,"create"])->name("posts.create");
			Route::post("/save/post",[HomeController::class,"store"])->name("posts.save");
			Route::post("/delete/post",[HomeController::class,"delete"])->name("posts.save");
			Route::get("/save/post/{id}",[HomeController::class,"edit"])->name("posts.edit");
			Route::post("/update/post",[HomeController::class,"update"])->name("posts.update");
		});

	/*
		admin routes. Only ussers with admin role can reach those routes
	*/
		Route::middleware(["role:admin"])->prefix("/admin")->name("admin.")->group(function(){
			Route::get("/index",[AdminController::class,"index"])->name("index");
			Route::get("/create",[AdminController::class,"create"])->name("create");
			Route::post("store/user",[AdminController::class,"store"])->name("store");
			Route::get("/edit/{id}",[AdminController::class,"edit"])->name("edit");
			Route::post("/update",[AdminController::class,"update"])->name("update");
			Route::post("/destroy",[AdminController::class,"destroy"])->name("destroy");
		});
});



/* end user Routes*/