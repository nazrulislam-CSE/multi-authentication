<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RedirectIfAuthenticated;

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
    return view('welcome');
});

/// User Dashboard
Route::middleware(['auth'])->group(function() {

	Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
	Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
	Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
	Route::post('/user/update/password', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');

}); 

/// Admin Dashboard
Route::middleware(['auth','role:admin'])->group(function() {

    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashobard');
    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('update.password');

});

/// Vendor Dashboard
Route::middleware(['auth','role:vendor'])->group(function() {

    Route::get('/vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashobard');
    Route::get('/vendor/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');
    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('/vendor/profile/store', [VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
    Route::get('/vendor/change/password', [VendorController::class, 'VendorChangePassword'])->name('vendor.change.password');
    Route::post('/vendor/update/password', [VendorController::class, 'VendorUpdatePassword'])->name('vendor.update.password');
});


/* =============== Admin & Vendor Login ============== */
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->middleware(RedirectIfAuthenticated::class);

Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);

Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register');



/* =============== Admin All Route ============== */
Route::middleware(['auth','role:admin'])->group(function() {

    // Brand All Route 
    Route::controller(BrandController::class)->group(function(){
        Route::get('/all/brand' , 'AllBrand')->name('all.brand');
        Route::get('/add/brand' , 'AddBrand')->name('add.brand');
        Route::post('/store/brand' , 'StoreBrand')->name('store.brand');
        Route::get('/edit/brand/{id}' , 'EditBrand')->name('edit.brand');
        Route::post('/update/brand' , 'UpdateBrand')->name('update.brand');
        Route::get('/delete/brand/{id}' , 'DeleteBrand')->name('delete.brand');

    });

    // Category All Route 
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/all/category' , 'AllCategory')->name('all.category');
        Route::get('/add/category' , 'AddCategory')->name('add.category');
        Route::post('/store/category' , 'StoreCategory')->name('store.category');
        Route::get('/edit/category/{id}' , 'EditCategory')->name('edit.category');
        Route::post('/update/category' , 'UpdateCategory')->name('update.category');
        Route::get('/delete/category/{id}' , 'DeleteCategory')->name('delete.category');

    });
}); // Admin End Middleware 

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
