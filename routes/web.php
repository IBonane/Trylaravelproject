<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Mail\ConfirmationMail;
use Illuminate\Support\Facades\Mail;
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
//home
Route::get('/', [Controller::class, 'home'])
        ->name('home');

// //email
// Route::get('/email', function(){

//         Mail::to('bonanedjimba@gmail.com')->send(new ConfirmationMail());
//         return new ConfirmationMail();
// });

//Create User
Route::get('/create/user', [Controller::class, 'showCreateUser'])
        ->name('create_user');

Route::post('/create/user', [Controller::class, 'CreateUser'])
        ->name('user.post');

Route::get('/confirmation_code', [Controller::class, 'showConfirmation'])
        ->name('confirmation');

Route::post('/confirmation_code', [Controller::class, 'confirmationCode'])
        ->name('code.post');

//login user
Route::get('/login', [Controller::class, 'showLogin'])
        ->name('showlogin');

Route::post('/login', [Controller::class, 'login'])
        ->name('login');

//logout user
Route::post('/logout', [Controller::class, 'logout'])
        ->name('logout');

//Dashboard user
Route::get('/dashboard/{id_user}', [Controller::class, 'dashboardUser'])->name('dashboard');

//search articles
Route::get('/search', [Controller::class, 'search'])
        ->name('search.page');

//sow article details
Route::get('/article/{id}', [Controller::class, 'detailArticle']);

//create articles

Route::get('/create', [Controller::class, 'createview'])->name('Showcreate');

Route::post('/create', [Controller::class, 'create'])->name('create');

//updatge articles

Route::get('/update/{id}', [Controller::class, 'showUpdate']);

Route::post('/update/{id}', [Controller::class, 'update']);

//Remove articles or no

Route::get('/showdelete/{id}', [Controller::class, 'showRemove']);

Route::get('/delete/{id}', [Controller::class, 'remove']);

Route::get('/nodelete', [Controller::class, 'noRemove'])->name('nodelete');