<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\RoomMemberController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\TenantContractController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\IssueController;
use App\Http\Controllers\Admin\NotificationController;

// 1. Trang chủ: Tự động phân luồng dựa trên việc đăng nhập
Route::get('/', function () {
    if (Auth::check()) {
        return (Auth::user()->role === 'admin')
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.index');
    }
    return redirect()->route('login');
});

// 2. Nhóm Guest: Chỉ dành cho người CHƯA đăng nhập
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// 3. Nhóm Auth: Yêu cầu ĐÃ đăng nhập mới được vào
Route::middleware('auth')->group(function () {

    // Đăng xuất
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Routes cho User
    Route::prefix('user')->group(function () {
        Route::get('/index', [UserController::class, 'index'])->name('user.index');
        Route::get('/chinh-sua-thong-tin', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/chinh-sua-thong-tin/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('/doi-mat-khau', [UserController::class, 'changePassword'])->name('user.change-password');
        Route::put('/doi-mat-khau/{id}', [UserController::class, 'updatePassword'])->name('user.update-password');

        // Routes cho Room Members
        Route::get('/thanh-vien-o-cung', [RoomMemberController::class, 'index'])->name('room-member.index');
        Route::post('/thanh-vien-o-cung', [RoomMemberController::class, 'store'])->name('room-member.store');
        Route::get('/thanh-vien-o-cung/{id}/edit', [RoomMemberController::class, 'edit'])->name('room-member.edit');
        Route::put('/thanh-vien-o-cung/{id}', [RoomMemberController::class, 'update'])->name('room-member.update');
        Route::delete('/thanh-vien-o-cung/{id}', [RoomMemberController::class, 'destroy'])->name('room-member.destroy');
    });

    // Routes cho Admin
    Route::prefix('admin')->middleware('can:is-admin')->group(function () {
        // Lưu ý: Nên thêm middleware check role admin ở đây
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/danh-sach-tai-khoan', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/cap-moi-tai-khoan', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/cap-moi-tai-khoan', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/chinh-sua-tai-khoan/{id}', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/cap-nhat-tai-khoan/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/xoa-tai-khoan/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Building management
        Route::get('/quan-ly-toa-nha', [BuildingController::class, 'index'])->name('buildings.index');
        Route::get('/them-toa-nha', [BuildingController::class, 'create'])->name('buildings.create');
        Route::post('/them-toa-nha', [BuildingController::class, 'store'])->name('buildings.store');
        Route::get('/chinh-sua-toa-nha/{id}', [BuildingController::class, 'edit'])->name('buildings.edit');
        Route::put('/cap-nhat-toa-nha/{id}', [BuildingController::class, 'update'])->name('buildings.update');
        Route::delete('/xoa-toa-nha/{id}', [BuildingController::class, 'destroy'])->name('buildings.destroy');

        // Room management
        Route::get('/quan-ly-phong', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('/them-phong', [RoomController::class, 'create'])->name('rooms.create');
        Route::post('/them-phong', [RoomController::class, 'store'])->name('rooms.store');
        Route::get('/chinh-sua-phong/{id}', [RoomController::class, 'edit'])->name('rooms.edit');
        Route::put('/cap-nhat-phong/{id}', [RoomController::class, 'update'])->name('rooms.update');
        Route::delete('/xoa-phong/{id}', [RoomController::class, 'destroy'])->name('rooms.destroy');

        // Service management (buildings)
        Route::get('/dich-vu-theo-toa', [ServiceController::class, 'indexBuilding'])->name('services.buildings.index');
        Route::get('/them-dich-vu-toa', [ServiceController::class, 'createBuilding'])->name('services.buildings.create');
        Route::post('/them-dich-vu-toa', [ServiceController::class, 'storeBuilding'])->name('services.buildings.store');
        Route::get('/chinh-sua-dich-vu-toa/{id}', [ServiceController::class, 'editBuilding'])->name('services.buildings.edit');
        Route::put('/cap-nhat-dich-vu-toa/{id}', [ServiceController::class, 'updateBuilding'])->name('services.buildings.update');
        Route::delete('/xoa-dich-vu-toa/{id}', [ServiceController::class, 'destroyBuilding'])->name('services.buildings.destroy');

        // Service management (rooms)
        Route::get('/dich-vu-theo-phong', [ServiceController::class, 'indexRoom'])->name('services.rooms.index');
        Route::get('/them-dich-vu-phong', [ServiceController::class, 'createRoom'])->name('services.rooms.create');
        Route::post('/them-dich-vu-phong', [ServiceController::class, 'storeRoom'])->name('services.rooms.store');
        Route::get('/chinh-sua-dich-vu-phong/{id}', [ServiceController::class, 'editRoom'])->name('services.rooms.edit');
        Route::put('/cap-nhat-dich-vu-phong/{id}', [ServiceController::class, 'updateRoom'])->name('services.rooms.update');
        Route::delete('/xoa-dich-vu-phong/{id}', [ServiceController::class, 'destroyRoom'])->name('services.rooms.destroy');

        // Tenants & Contracts
        Route::get('/nguoi-thue', [TenantContractController::class, 'indexTenants'])->name('tenants.index');
        Route::get('/hop-dong', [TenantContractController::class, 'indexContracts'])->name('contracts.index');
        Route::get('/hop-dong/tao', [TenantContractController::class, 'createContract'])->name('contracts.create');
        Route::post('/hop-dong', [TenantContractController::class, 'storeContract'])->name('contracts.store');

        // Finance (approvals, invoices)
        Route::get('/phe-duyet-chi-so', [FinanceController::class, 'indexReadings'])->name('finance.readings.index');
        Route::post('/phe-duyet-chi-so/{id}/phe-duyet', [FinanceController::class, 'approveReading'])->name('finance.readings.approve');
        Route::post('/phe-duyet-chi-so/{id}/tu-choi', [FinanceController::class, 'rejectReading'])->name('finance.readings.reject');

        Route::get('/danh-sach-dong-tien', [FinanceController::class, 'indexInvoices'])->name('finance.invoices.index');
        Route::get('/danh-sach-dong-tien/{id}', [FinanceController::class, 'showInvoice'])->name('finance.invoices.show');

        // Issues (Feedback)
        Route::get('/danh-sach-phan-hoi', [IssueController::class, 'index'])->name('issues.index');
        Route::get('/danh-sach-phan-hoi/{id}', [IssueController::class, 'show'])->name('issues.show');
        Route::post('/danh-sach-phan-hoi/{id}/phan-hoi', [IssueController::class, 'storeResponse'])->name('issues.storeResponse');
        Route::put('/danh-sach-phan-hoi/{id}/trang-thai', [IssueController::class, 'updateStatus'])->name('issues.updateStatus');

        // Notifications
        Route::get('/danh-sach-thong-bao', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/gui-thong-bao', [NotificationController::class, 'create'])->name('notifications.create');
        Route::post('/gui-thong-bao', [NotificationController::class, 'store'])->name('notifications.store');
    });
});
