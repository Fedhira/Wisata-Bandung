<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'auth'], function () {

	Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');


	Route::get('/', function () {
		return view('welcome');
	});

	Route::get('index', function () {
		return view('tours/index');
	})->name('index');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

	Route::get('edit', function () {
		return view('edit');
	})->name('edit');

	Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/create', [TourController::class, 'create']);
	Route::post('/create', [TourController::class, 'store']);
	Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});

Route::group(['middleware' => 'guest'], function () {
	Route::get('/register', [RegisterController::class, 'create']);
	Route::post('/register', [RegisterController::class, 'store']);
	Route::get('/login', [SessionsController::class, 'create']);
	Route::post('/session', [SessionsController::class, 'store']);
});

Route::get('/login', function () {
	return view('session/login-session');
})->name('login');

Route::get('/register', function () {
	return view('session/register');
})->name('register');

Route::resource('tours', \App\Http\Controllers\TourController::class)
	->middleware('auth');

Route::get('/index', [\App\Http\Controllers\TourController::class, 'index']);
Route::get('/app', [\App\Http\Controllers\TourController::class, 'app']);

Route::get('/edit/{id}', [TourController::class, 'edit']);
Route::post('/edit', [TourController::class, 'update']);
// Route::get('/edit/{id?}', [\App\Http\Controllers\TourController::class, 'edit']);

// Route::get('/tours/{id}/edit', 'TourController@edit')->name('tours.edit');

Route::get('/edit', [\App\Http\Controllers\TourController::class, 'edit']);

Route::get('/edit/{id}', [\App\Http\Controllers\TourController::class, 'edit'])->name('edit');


Route::get('/', [\App\Http\Controllers\TourController::class, 'welcome']);
