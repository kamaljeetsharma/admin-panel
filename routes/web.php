<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Passwordcontroller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\ValidUser;
use App\Models\Category;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
     


Route::middleware('guest')->group(function () {
Route::view('/kamal','forgotpassword');
Route::post('/forgotpassword', [PasswordController::class, 'forgotPassword']);
Route::view('/Otp','validateotp');
Route::post('/may', [PasswordController::class, 'otpverification']); 
Route::view('/password','resetpassword');
Route::post('/april', [PasswordController::class, 'resetPasswordWithOtp']);
Route::view('/login','login')->name('login');
Route::post('/signin', [AuthController::class, 'login']);
Route::view('/register','register');
Route::post('/signup',[Authcontroller::class,'signup']);

});

Route::group(['middleware'=> 'setLocale'], function(){


//delete this Route::view('/sharma','admin.new');

//Route::middleware('web')->group(function () {
Route::delete('/user/{id}', [AuthController::class, 'destroy'])->name('deleteUser');

//Route::get('/users', [AuthController::class, 'index']);

Route::view('/sahil','admin.display')->name('sahil');
Route::post('/ADD',[Authcontroller::class,'addUser']);

   Route::view('/Menuupdate','admin.menuupdate');
   Route::view('/Menudisplay','admin.menudisplay');
   Route::view('/show','display');
   Route::post('/logout', [AuthController::class, 'logout']);

// Shared access routes (both 'customer' and 'admin' can access)
   Route::middleware('IsUserValid:customer')->group(function () {
   Route::view('/new-page','admin.newpage');
   Route::POST('/update', [AuthController::class, 'updateProfile'])->name('update');


});

   Route::middleware(['IsUserValid:admin'])->group(function () {

    Route::view('/dashboard','Dashboard')->name('dashboard');
    Route::get('/main', [AuthController::class, 'dashboard']);
    Route::get('lang/{locale}', [LanguageController::class, 'switchLang'])->name('set.language');


//Route::view('/edit/{id}', 'admin.edit')->name('edit');
//Route::post('/update', [AuthController::class, 'updateProfile'])->name('update');
     // Route to show the edit form

Route::get('/edit/{id}', [AuthController::class, 'edit'])->name('edit');
Route::get('/showProfile/{id}',[AuthController::class, 'showProfile'])->name('Profileedit');
// Route to handle profile update
Route::post('/admin-users/{id}',[AuthController::class,'updateUser'])->name('admin.user.update');
    Route::get('/details',[AuthController::class,'showProfileForm'])->name('details');
    Route::view('/admin-page','admin.index');
    Route::get('/users',[AuthController::class,'index']);
    Route::post('/change',[AuthController::class,'updatePassword'])->name('change');


// Route to show the form for adding a new menu item
Route::get('/Menu/add', [MenuController::class, 'createnew'])->name('Menu.create');
Route::view('/Menu','admin.menu');//->middleware('red');
Route::post('/Store',[MenuController::class,'store']);
Route::get('/edit-menu-item/{id}', [MenuController::class, 'edit'])->name('menu.edit');
Route::post('/menu-item/{id}', [MenuController::class, 'update'])->name('menu.update');
Route::get('/Menudisplay', [MenuController::class, 'showMenuItems'])->name('Menudisplay');
Route::delete('/menu-item/{id}', [MenuController::class, 'destroy'])->name('deleteMenuItem');
Route::get('/users', [AuthController::class, 'index'])->name('users');


// Route to show the edit form for a category
Route::get('/categories/{id}', [CategoryController::class, 'edit'])->name('editCategory');
// Route to handle the update of the category
Route::post('/categories/{id}', [CategoryController::class, 'update'])->name('updateCategory');
Route::get('/categorydisplay', [CategoryController::class, 'index']);
Route::delete('/category-item/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::view('category','admin.Category');
Route::post('/additem',[CategoryController::class,'store']);
   });
   
   //Route::get('/dashboard', [Authcontroller::class, 'dashboard']);
   

 
 //Route::post('/edit',[AdminController::class,'reset']);
 
 //Route::get('/admin-page',[Authcontroller::class,'admin.index']);
 
 

 //Route::get('/job',[MenuController::class,'index']);
 
//  Route::post('/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
//  Route::get('/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');

//  Route::get('/Menuupdate/{id}', [MenuController::class, 'edit'])->name('menu.edit');
// Route::post('/Menuupdate/{id}', [MenuController::class, 'update'])->name('menu.update');




});


