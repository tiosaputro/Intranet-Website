<?php

use App\Http\Controllers\Admin\ManagementMenuController;
use App\Http\Controllers\Admin\ManagementPermissionController;
use App\Http\Controllers\Admin\ManagementRoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ManagementUsersController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\LibraryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
// Auth::routes();

//API route for register new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route for login user
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

Route::post('uploads/{modul?}',[NewsController::class, 'upload']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('/user', function(Request $request) {
        if(Auth::check()){
            $user = Auth::user();
            $user->loggedin = 1;
            return json_encode($user);
        }else{
            return json_encode(['loggedin' => 0]);
        }
    });
    Route::get('/cek-login', [App\Http\Controllers\API\AuthController::class, 'cekLogin']);
    //users
    Route::get('users/get-list',[ManagementUsersController::class, 'datatable']);
    Route::post('users',[ManagementUsersController::class, 'store']);
    Route::get('users/get-role',[ManagementUsersController::class, 'getRole']);
    Route::delete('users/{id}',[ManagementUsersController::class, 'hapus']);
    Route::get('users/{id}',[ManagementUsersController::class, 'getRow']);
    Route::get('users/search/{keyword}',[ManagementUsersController::class, 'searchData']);
    //role & setting modul
    Route::get('role/get-list',[ManagementRoleController::class, 'index']);
    Route::post('role',[ManagementRoleController::class, 'store']);
    Route::put('role/{id}',[ManagementRoleController::class, 'update']);
    Route::delete('role/{id}',[ManagementRoleController::class, 'hapus']);
    Route::get('role/{id}',[ManagementRoleController::class, 'getRow']);
    Route::get('role-modul/{idrole}',[ManagementRoleController::class, 'getRoleModul']);
    Route::post('role-modul/{idrole}',[ManagementRoleController::class, 'storeRoleModul']);
    //permission
    Route::get('permission/get-list',[ManagementPermissionController::class, 'index']);
    Route::post('permission',[ManagementPermissionController::class, 'store']);
    Route::put('permission/{id}',[ManagementPermissionController::class, 'update']);
    Route::delete('permission/{id}',[ManagementPermissionController::class, 'hapus']);
    Route::get('permission/{id}',[ManagementPermissionController::class, 'getRow']);
    //menu / modul
    Route::get('menu/get-list',[ManagementMenuController::class, 'index']);
    Route::get('menu/get-all',[ManagementMenuController::class, 'getAll']);
    Route::post('menu',[ManagementMenuController::class, 'store']);
    Route::put('menu/{id}',[ManagementMenuController::class, 'update']);
    Route::delete('menu/{id}',[ManagementMenuController::class, 'hapus']);
    Route::get('menu/{id}',[ManagementMenuController::class, 'getRow']);
    //News
    Route::get('news/get-list',[NewsController::class, 'index']);
    Route::get('news/get-all',[NewsController::class, 'getAll']);
    Route::post('news',[NewsController::class, 'store']);
    Route::put('news/{id}',[NewsController::class, 'update']);
    Route::delete('news/{id}',[NewsController::class, 'hapus']);
    Route::get('news/{id}',[NewsController::class, 'getRow']);

    //data Dashboard
    Route::get('data-news',[HomeController::class, 'dataDashboard']);
    Route::get('detail-news/{id}',[NewsController::class, 'detailNews']);

    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
