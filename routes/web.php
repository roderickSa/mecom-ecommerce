<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

///User Dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, "UserDashboard"])->name("dashboard");
    Route::get('/user/logout', [UserController::class, 'UserDestroy'])->name("user.logout");
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name("user.profile.store");
    Route::post('/user/update/password', [UserController::class, 'UserUpdatePassword'])->name("user.update.password");
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

///Admin Dashboard
Route::middleware(["auth", "role:admin"])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name("admin.dashboard");
    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name("admin.logout");
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name("admin.profile");
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name("admin.profile.store");
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name("admin.change.password");
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name("admin.update.password");

    Route::get('admin/all/vendor', [AdminController::class, 'AllVendor'])->name("all.vendor");
    Route::get('admin/details/vendor/{id}', [AdminController::class, 'DetailsVendor'])->name("details.vendor");
    Route::get('admin/register/vendor', [AdminController::class, 'RegisterVendor'])->name("register.vendor");
    Route::post('admin/store/vendor', [AdminController::class, 'StoreVendor'])->name("store.vendor");
    Route::post('admin/change-status/vendor', [AdminController::class, 'ChangeStatusVendor'])->name("change.status.vendor");
});

///Vendor Dashboard
Route::middleware(["auth", "role:vendor"])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name("vendor.dashboard");
    Route::get('/vendor/logout', [VendorController::class, 'VendorDestroy'])->name("vendor.logout");
    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name("vendor.profile");
    Route::post('/vendor/profile/store', [VendorController::class, 'VendorProfileStore'])->name("vendor.profile.store");
    Route::get('/vendor/change/password', [VendorController::class, 'VendorChangePassword'])->name("vendor.change.password");
    Route::post('/vendor/update/password', [VendorController::class, 'VendorUpdatePassword'])->name("vendor.update.password");
});

Route::middleware('guest')->group(function () {
    Route::get("/admin/login", [AdminController::class, "AdminLogin"])->name("admin.login");
    Route::get("/vendor/login", [VendorController::class, "VendorLogin"])->name("vendor.login");
});


//Backend Admin
Route::middleware(["auth", "role:admin"])->group(function () {
    //BrandController
    Route::controller(BrandController::class)->group(function () {
        Route::get('/all/brand', 'AllBrand')->name("all.brand");
        Route::get('/add/brand', 'AddBrand')->name("add.brand");
        Route::post('/store/brand', 'StoreBrand')->name("brand.store");
        Route::get('/edit/brand/{id}', 'EditBrand')->name("edit.brand");
        Route::post('/update/brand', 'UpdateBrand')->name("update.brand");
        Route::get('/update/brand/{id}', 'DeleteBrand')->name("delete.brand");
    });
    //CategoryController
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/all/category', 'AllCategory')->name("all.category");
        Route::get('/add/category', 'AddCategory')->name("add.category");
        Route::post('/store/category', 'StoreCategory')->name("category.store");
        Route::get('/edit/category/{id}', 'EditCategory')->name("edit.category");
        Route::post('/update/category', 'UpdateCategory')->name("update.category");
        Route::get('/update/category/{id}', 'DeleteCategory')->name("delete.category");
    });
    //SubCategoryController
    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/all/subcategory', 'AllSubCategory')->name("all.subcategory");
        Route::get('/add/subcategory', 'AddSubCategory')->name("add.subcategory");
        Route::post('/store/subcategory', 'StoreSubCategory')->name("subcategory.store");
        Route::get('/edit/subcategory/{id}', 'EditSubCategory')->name("edit.subcategory");
        Route::post('/update/subcategory', 'UpdateSubCategory')->name("update.subcategory");
        Route::get('/update/subcategory/{id}', 'DeleteSubCategory')->name("delete.subcategory");
    });
});

require __DIR__ . '/auth.php';
