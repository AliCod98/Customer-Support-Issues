<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\IssueController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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

Route::get('/home', function () {
    $route = Gate::denies('dashboard_access') ? 'admin.issues.index' : 'admin.home';
    if (session('status')) {
        return redirect()->route($route)->with('status', session('status'));
    }

    return redirect()->route($route);
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {

    // Dashboard
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Permissions
    Route::resource('permissions', Admin\PermissionsController::class);

    // Roles
    Route::resource('roles', Admin\RolesController::class);

    // Users
    Route::resource('users', Admin\UsersController::class);

    // Categories
    Route::resource('categories', Admin\CategoriesController::class);

    // Issues
    Route::post('issues/comment/{issue}', [IssueController::class, 'storeComment'])->name('issues.storeComment');
    Route::resource('issues', Admin\IssueController::class);

    // Comments
    Route::resource('comments', Admin\CommentsController::class);
});