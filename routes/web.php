<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\IdeaApprovalController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\Master\ApproverController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\LevelController;
use App\Http\Controllers\Master\PermissionController;
use App\Http\Controllers\Master\PositionController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\SectionController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Master\IdeaCountsController;
use App\Http\Controllers\Mpdr\MpdrController;
use App\Http\Controllers\PreMpdr\PreMpdrController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Rs\RequistionSlipController;
use App\Http\Controllers\ItemmasterController;
use App\Http\Controllers\ItemdetailController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\RevisionsController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

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

Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');

Route::get('/create-symlink', function () {
    $target = storage_path('app/public'); // path ke folder storage/app/public
    $link = public_path('storage'); // path ke folder public/storage

    // Cek apakah symlink sudah ada
    if (!File::exists($link)) {
        // Buat symlink
        symlink($target, $link);
        return 'Symlink has been created.';
    }

    return 'Symlink already exists.';
});




Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile', [UserController::class, 'updateProfile'])->name('profile.updates');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('levels', LevelController::class);
    Route::resource('sections', SectionController::class);

    Route::post('/notifications/mark-as-read', [PermissionController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/markAllAsRead', [PermissionController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/notifications/count', function () {
        return response()->json(['count' => auth()->user()->unreadNotifications->count()]);
    })->name('notifications.count');
    Route::delete('/notifications/clear', [PermissionController::class, 'clearAll'])->name('notifications.clear');


    // // =============================================================PRE MPDR=================================================================
    // Route::prefix('prempdr')->group(function () {
    //     Route::get('/', [PreMpdrController::class, 'index'])->name('prempdr.index');
    //     Route::get('/create', [PreMpdrController::class, 'create'])->name('prempdr.create');
    //     Route::get('/edit/{id}', [PreMpdrController::class, 'edit'])->name('prempdr.edit');
    //     Route::patch('/update/{id}', [PreMpdrController::class, 'update'])->name('prempdr.update');
    //     Route::delete('/destroy/{id}', [PreMpdrController::class, 'destroy'])->name('prempdr.destroy');
    //     Route::get('/report', [PreMpdrController::class, 'report'])->name('prempdr.report');
    //     Route::get('/approval', [PreMpdrController::class, 'approval'])->name('prempdr.approval');
    //     Route::get('/log', [PreMpdrController::class, 'log'])->name('prempdr.log');
    // });



    // // =============================================================MPDR=================================================================
    // Route::prefix('mpdr')->group(function () {
    //     Route::get('/', [MpdrController::class, 'index'])->name('mpdr.index');
    //     Route::get('/create', [MpdrController::class, 'create'])->name('mpdr.create');
    //     Route::get('/edit/{id}', [MpdrController::class, 'edit'])->name('mpdr.edit');
    //     Route::patch('/update/{id}', [MpdrController::class, 'update'])->name('mpdr.update');
    //     Route::delete('/destroy/{id}', [MpdrController::class, 'destroy'])->name('mpdr.destroy');
    //     Route::get('/report', [MpdrController::class, 'report'])->name('mpdr.reports');
    //     Route::get('/approval', [MpdrController::class, 'approval'])->name('mpdr.approval');
    //     Route::get('/log', [MpdrController::class, 'log'])->name('mpdr.log');
    // });


    // =============================================================RS=================================================================

    Route::prefix('rs')->group(function () {

        Route::get('/', [RequistionSlipController::class, 'index'])->name('rs.index');
        Route::get('/create', [RequistionSlipController::class, 'create'])->name('rs.create');
        Route::get('getnoReg', [RequistionSlipController::class, 'noReg'])->name('rs.noReg');
        Route::get('/edit/{id}', [RequistionSlipController::class, 'edit'])->name('rs.edit');
        Route::patch('/update/{id}', [RequistionSlipController::class, 'update'])->name('rs.update');
        Route::delete('/destroy/{id}', [RequistionSlipController::class, 'destroy'])->name('rs.destroy');
        Route::get('/report', [RequistionSlipController::class, 'report'])->name('rs.report');
        Route::get('/approval', [RequistionSlipController::class, 'approval'])->name('rs.approval');
        Route::get('/log', [RequistionSlipController::class, 'log'])->name('rs.log');
        Route::get('/list/{id}', [RequistionSlipController::class, 'list'])->name('rs.list');
        // Route::get('/listrs/{id}', [RequisitionController::class, 'show']);
        Route::get('/status', [RequistionSlipController::class, 'statusform'])->name('rs.status');
        Route::get('/submit', [RequistionSlipController::class, 'create'])->name('rs.submit');
        Route::post('/store', [RequistionSlipController::class, 'store'])->name('requisition.store');
        

        Route::get('/product/{id}', [RequistionSlipController::class, 'getproductdata'])->name('requisition.getproductdata');
        
        Route::get('/itemmaster', [ItemmasterController::class, 'index'])->name('item-master.index');
        Route::POST('/itemmasterdestroy/{id}', [ItemmasterController::class, 'destroy'])->name('item-master.destroy');
        Route::get('/itemmastercreate/{id}', [ItemmasterController::class, 'create'])->name('item-master.create');
        Route::post('/itemmasterstore', [ItemmasterController::class, 'store'])->name('item-master.store');
        Route::get('/itemmasteredit/update/{id}', [ItemmasterController::class, 'edit'])->name('item-master.edit');
        Route::patch('/itemmasterupdate/update/{id}', [ItemmasterController::class, 'update'])->name('item-master.update');
        Route::get('/itemdetail', [ItemdetailController::class, 'index'])->name('item-detail.index');
        Route::POST('/itemdetaildestroy/{id}', [ItemdetailController::class, 'destroy'])->name('item-detail.destroy');
        Route::post('/itemdetailstore', [ItemdetailController::class, 'store'])->name('item-details.store');
        Route::put('/itemmasterupdate/update/{id}', [ItemdetailController::class, 'update'])->name('item-details.update');
        Route::post('/itemdetailstore', [ItemdetailController::class, 'store'])->name('item-detail.store');
        Route::get('/customer', [CustomersController::class, 'index'])->name('customers.index');
        Route::get('/customercreate/{id}', [CustomersController::class, 'create'])->name('customers.create');
        Route::post('/customerstore', [CustomersController::class, 'store'])->name('customers.store');
        Route::get('/customeredit/update/{id}', [CustomersController::class, 'edit'])->name('customers.edit');
        Route::put('/customerupdate/update/{id}', [CustomersController::class, 'update'])->name('customers.update');
        Route::delete('/customerdestroy/{id}', [CustomersController::class, 'destroy'])->name('customers.destroy');
        Route::get('/revision', [RevisionsController::class, 'index'])->name('revisions.index');
        Route::get('/revisioncreate/{id}', [RevisionsController::class, 'create'])->name('revisions.create');
        Route::post('/revisionstore', [RevisionsController::class, 'store'])->name('revisions.store');
        Route::get('/revisionedit/update/{id}', [RevisionsController::class, 'edit'])->name('revisions.edit');
        Route::put('/revisionupdate/update/{id}', [RevisionsController::class, 'update'])->name('revisions.update');
    });


});


Route::group(['middleware' => ['role:super-admin|admin']], function() {

    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);

    Route::resource('roles', RoleController::class);
    Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole'])->name('roles.give-permissions');
    Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);

    Route::resource('users', UserController::class);
    Route::get('users/{userId}/delete', [UserController::class, 'destroy']);

});



require __DIR__.'/auth.php';
