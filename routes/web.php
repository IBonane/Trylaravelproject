<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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

Route::get('/', [Controller::class, 'home'])
        ->name('home');

Route::get('/login', [Controller::class, 'showLogin'])
        ->name('showlogin');

Route::post('/login', [Controller::class, 'login'])
        ->name('login');

Route::post('/logout', [Controller::class, 'logout'])
        ->name('logout');

Route::get('/dashboard/{id_user}', [Controller::class, 'dashboardUser'])->name('dashboard');

Route::get('/search', [Controller::class, 'search'])
        ->name('search.page');

Route::get('/article/{id}', [Controller::class, 'detailArticle']);

Route::get('/create', [Controller::class, 'createview'])->name('Showcreate');

Route::post('/create', [Controller::class, 'create'])->name('create');

Route::get('/update/{id}', [Controller::class, 'showUpdate']);

Route::post('/update/{id}', [Controller::class, 'update']);

Route::get('/delete/{id}', [Controller::class, 'remove']);