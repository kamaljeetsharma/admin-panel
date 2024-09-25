api.php
<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Postcontroller;
use App\Http\Controllers\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

 Route::post('/signup',[AuthController::class,'signup']);

        
//  Route::get('/',[Authcontroller::class,'signup']);
 //Route::post('/signin',[Authcontroller::class,'login']);
 /*Route::post('/forgotpassword', [AuthController::class, 'forgotPassword']);
Route::post('/april', [AuthController::class, 'resetPasswordWithOtp']);
Route::post('/may', [AuthController::class, 'otpverification']); 
 Route::get('/logout', [AuthController::class, 'logout']);
 Route::post('/edit',[AdminController::class,'reset']);
// Route::post('/update',[AuthController::class,'updateProfile']);            
 Route::get('/admin-page',[Authcontroller::class,'admin.index']);
 
 Route::post('/change',[AuthController::class,'updatePassword']);

 Route::get('/job',[MenuController::class,'index']);

 
 Route::post('/Store',[MenuController::class,'store']);
 //Route::patch('/changes',[MenuController::class,'update']);
 //Route::get('/data',[MenuController::class,'update']);
 Route::post('/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');

 //Route::get('/Menudisplay', [MenuController::class, 'showMenuItems']);

 */
