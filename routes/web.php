<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('users', UserController::class)->except('show');
    Route::resource('employees', EmployeeController::class);
    Route::get('fetch-employees/{id}/', [EmployeeController::class, 'fetchByStatus'])->name('employees.fetch');
    Route::resource('roles', RoleController::class);
    Route::resource('files', FileController::class);
    Route::get('fetch-file/{id}/', [FileController::class, 'fetchFile']);
    Route::post('document/register', [FileController::class, 'store'])->name('document.register');
    Route::delete('destroy-file/{id}', [FileController::class, 'destroy'])->name('file.destroy');
});
