<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Auth\RegisterController;

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


Route::group(['middleware' => 'web'], function() {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/login', [HomeController::class, 'login'])->name('login');
    Route::get('/cadastro', [HomeController::class, 'register'])->name('cadastro');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::post('auth/cadastro', [RegisterController::class, 'register'])->name('register');
});

Route::group(['prefix' => 'usuarios', 'middleware' => 'web'], function() {
    Route::get('/', [UsuariosController::class, 'index'])->name('usuarios.home');
    
    Route::get('/novo', [UsuariosController::class, 'novo'])->name('usuarios.novo');
    Route::post('/add', [UsuariosController::class, 'add'])->name('usuarios.add');

    Route::get('/detalhes/{id}', [UsuariosController::class, 'detalhes'])->name('usuarios.detalhes');
    
    Route::get('/editar/{id}', [UsuariosController::class, 'editar'])->name('usuarios.editar');
    Route::post('/update/{id}', [UsuariosController::class, 'update'])->name('usuarios.update');
    
    Route::delete('/deletar/{id}', [UsuariosController::class, 'delete'])->name('usuarios.deletar');
});

Route::view('/upload', 'upload.form');
Route::post('/upload', [UploadController::class, 'uploadFile'])->name('upload');