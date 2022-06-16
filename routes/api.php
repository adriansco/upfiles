<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* return datatables()->eloquent(User::query())->toJson();
return datatables()->query(DB::table('users'))->toJson(); */
Route::get('employees/{ctrlStatus}/', function ($ctrlStatus) {
    return datatables()->query(DB::table('employees')->where('status', $ctrlStatus))
        ->addColumn('btn', 'employees/actions')
        ->rawColumns(['btn'])
        ->toJson();
});
/* Route::middleware('auth')->get('/employees', function () {
    Route::get('employees', function () {
        return datatables()->query(DB::table('employees'))->toJson();
    });
}); */
