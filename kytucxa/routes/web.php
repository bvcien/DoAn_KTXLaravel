<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\AdminBankController;
use App\Http\Controllers\AdminNewController;
use App\Http\Controllers\AdminPayController;
use App\Http\Controllers\AdminHoaDonController;
use App\Http\Controllers\AdminBannerController;
use App\Http\Controllers\UserDanhMucController;
use App\Http\Controllers\UserNewController;
use App\Http\Controllers\UserRoomController;
use App\Http\Controllers\UserPayController;
use App\Http\Controllers\UserSettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;

/** Routes người dùng */
Route::get('/', [HomeController::class, 'index'])->name('user.index');

// Đăng nhập - đăng xuất
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('user.handleLogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');

// Đăng ký
Route::get('/register', [AuthController::class, 'register'])->name('user.register');
Route::post('/register', [AuthController::class, 'handleRegister'])->name('user.handleRegister');
Route::get('/verify-code', [AuthController::class, 'verifyCode'])->name('user.verifyCode');
Route::post('/verify-code', [AuthController::class, 'handleVerifyCode'])->name('user.handleVerifyCode');
Route::post('/delete-temp-account', [AuthController::class, 'deleteTempAccount'])->name('user.deleteTempAccount');

// Quên mật khẩu
Route::get('/forgot_pwd', [AuthController::class, 'forgot_pwd'])->name('user.forgot_pwd');
Route::post('/forgot_pwd', [AuthController::class, 'sendResetPassword'])->name('user.sendResetPassword');

// Danh mục
Route::get('/danhmuc/{id}', [UserDanhMucController::class, 'index'])->name('user.indexDanhMuc');

// Tin tức
Route::get('/tintuc/{id}', [UserNewController::class, 'index'])->name('user.indexTinTuc');
Route::post('/news/{id}/like', [UserNewController::class, 'like'])->name('news.like');
Route::post('/news/{id}/dislike', [UserNewController::class, 'dislike'])->name('news.dislike');

/** Routes người dùng - yêu cầu đăng nhập*/
Route::middleware('auth')->group(function () {
    // Thanh toán
    Route::get('/thanhtoan', [UserPayController::class, 'index'])->name('user.indexThanhToan');
    Route::post('/thanhtoan/store', [UserPayController::class, 'store'])->name('user.storeThanhToan');

    // Hóa đơn
    Route::get('/hoadon', [UserPayController::class, 'bill'])->name('user.billHoaDon');
    Route::get('/hoadon/{id}', [UserPayController::class, 'billDetail'])->name('user.billDetail');

    // KTX
    Route::get('/DangKy_KTX', [UserRoomController::class, 'index'])->name('user.indexDangKyKTX');
    Route::post('/DangKy_KTX', [UserRoomController::class, 'register'])->name('user.registerKTX');
    Route::get('/get-rooms/{idCategory}', [UserRoomController::class, 'getRooms']);
    Route::get('/get-room-details/{id}', [UserRoomController::class, 'getRoomDetails']);
    Route::post('/huy-dang-ky-ktx', [UserRoomController::class, 'requestCancelRegistration'])->name('user.requestCancelKTX');

    // Trang setting người dùng         
    Route::get('/setting', [UserSettingController::class, 'index'])->name('user.indexSetting');
    Route::put('/setting/update', [UserSettingController::class, 'update'])->name('user.updateSetting'); 

    // Bình luận
    Route::post('/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');
});

/** Routes quản lý */
// auth: kiem tra xem có đang đăng nhập, kiểm tra tài khoản đang đăng nhập từ cột role có bằng 0 và 1
Route::middleware(['auth', 'role:0,1'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');

        // Danh mục - Category
        Route::get('/category', [AdminCategoryController::class, 'index'])->name('admin.indexCategory');
        Route::get('/category/create', [AdminCategoryController::class, 'create'])->name('admin.createCategory');
        Route::post('/category/store', [AdminCategoryController::class, 'store'])->name('admin.storeCategory');
        Route::get('/category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin.editCategory');
        Route::post('/category/update/{id}', [AdminCategoryController::class, 'update'])->name('admin.updateCategory');
        Route::get('/category/search', [AdminCategoryController::class, 'search'])->name('admin.searchCategory');
        Route::delete('/category/delete/{id}', [AdminCategoryController::class, 'delete'])->name('admin.deleteCategory');

        // Tài khoản - Account
        Route::get('/account', [AdminAccountController::class, 'index'])->name('admin.indexAccount');
        Route::get('/account/create', [AdminAccountController::class, 'create'])->name('admin.createAccount');
        Route::post('/account/store', [AdminAccountController::class, 'store'])->name('admin.storeAccount');
        Route::get('/account/edit/{id}', [AdminAccountController::class, 'edit'])->name('admin.editAccount');
        Route::post('/account/update/{id}', [AdminAccountController::class, 'update'])->name('admin.updateAccount');
        Route::get('/account/search', [AdminAccountController::class, 'search'])->name('admin.searchAccount');
        Route::delete('/account/delete/{id}', [AdminAccountController::class, 'delete'])->name('admin.deleteAccount');

        // Phòng - Room
        Route::get('/room', [AdminRoomController::class, 'index'])->name('admin.indexRoom');
        Route::get('/room/create', [AdminRoomController::class, 'create'])->name('admin.createRoom');
        Route::post('/room/store', [AdminRoomController::class, 'store'])->name('admin.storeRoom');
        Route::get('/room/edit/{id}', [AdminRoomController::class, 'edit'])->name('admin.editRoom');
        Route::post('/room/update/{id}', [AdminRoomController::class, 'update'])->name('admin.updateRoom');
        Route::get('/room/search', [AdminRoomController::class, 'search'])->name('admin.searchRoom');
        Route::delete('/room/delete/{id}', [AdminRoomController::class, 'delete'])->name('admin.deleteRoom');

        // Thành viên - Member
        Route::get('/member', [AdminMemberController::class, 'index'])->name('admin.indexMember');
        Route::get('/member/create', [AdminMemberController::class, 'create'])->name('admin.createMember');
        Route::post('/member/store', [AdminMemberController::class, 'store'])->name('admin.storeMember');
        Route::get('/member/edit/{id}', [AdminMemberController::class, 'edit'])->name('admin.editMember');
        Route::post('/member/update/{id}', [AdminMemberController::class, 'update'])->name('admin.updateMember');
        Route::get('/member/search', [AdminMemberController::class, 'search'])->name('admin.searchMember');
        Route::delete('/member/delete/{id}', [AdminMemberController::class, 'delete'])->name('admin.deleteMember');
        Route::get('/member/{member}', [AdminMemberController::class, 'show'])->name('admin.showMember');

        // Thanh toán - Pay
        Route::get('/pay', [AdminPayController::class, 'index'])->name('admin.indexPay');
        // Hiển thị form thêm theo phòng
        Route::get('/pay/create-room', [AdminPayController::class, 'createByRoom'])->name('admin.createPayRoom');
        // Xử lý lưu thanh toán theo phòng
        Route::post('/pay/store-room', [AdminPayController::class, 'storeByRoom'])->name('admin.storePayRoom');
        // Hiển thị form thêm theo thành viên
        Route::get('/pay/create-member', [AdminPayController::class, 'createByMember'])->name('admin.createPayMember');
        // Xử lý lưu thanh toán theo thành viên
        Route::post('/pay/store-member', [AdminPayController::class, 'storeByMember'])->name('admin.storePayMember');
        Route::get('/pay/edit/{id}', [AdminPayController::class, 'edit'])->name('admin.editPay');
        Route::post('/pay/update/{id}', [AdminPayController::class, 'update'])->name('admin.updatePay');
        Route::get('/pay/search', [AdminPayController::class, 'search'])->name('admin.searchPay');
        Route::delete('/pay/delete/{id}', [AdminPayController::class, 'delete'])->name('admin.deletePay');

        // Hóa đơn
        Route::get('/hoadon', [AdminHoaDonController::class, 'index'])->name('admin.indexHoaDon');
        Route::get('/hoadon/edit/{id}', [AdminHoaDonController::class, 'edit'])->name('admin.editHoaDon');
        Route::post('/hoadon/update/{id}', [AdminHoaDonController::class, 'update'])->name('admin.updateHoaDon');
        Route::get('/hoadon/search', [AdminHoaDonController::class, 'search'])->name('admin.searchHoaDon');
        Route::delete('/hoadon/delete/{id}', [AdminHoaDonController::class, 'delete'])->name('admin.deleteHoaDon');
        Route::get('/admin/hoadon/{id}', [AdminHoaDonController::class, 'show'])->name('admin.showHoaDon');
        Route::get('/hoadon/export', [AdminHoaDonController::class, 'exportExcel'])->name('admin.exportHoaDon');

        // Bài viết, tin tức - New
        Route::get('/new', [AdminNewController::class, 'index'])->name('admin.indexNew');
        Route::get('/new/create', [AdminNewController::class, 'create'])->name('admin.createNew');
        Route::post('/new/store', [AdminNewController::class, 'store'])->name('admin.storeNew');
        Route::get('/new/edit/{id}', [AdminNewController::class, 'edit'])->name('admin.editNew');
        Route::post('/new/update/{id}', [AdminNewController::class, 'update'])->name('admin.updateNew');
        Route::get('/new/search', [AdminNewController::class, 'search'])->name('admin.searchNew');
        Route::delete('/new/delete/{id}', [AdminNewController::class, 'delete'])->name('admin.deleteNew');

        // Ảnh chiếu - Banner
        Route::get('/chucnang', [AdminBannerController::class, 'index'])->name('admin.indexBanner');
        Route::get('/chucnang/create', [AdminBannerController::class, 'create'])->name('admin.createBanner');
        Route::post('/chucnang/store', [AdminBannerController::class, 'store'])->name('admin.storeBanner');
        Route::get('/chucnang/search', [AdminBannerController::class, 'search'])->name('admin.searchBanner');
        Route::delete('/chucnang/delete/{id}', [AdminBannerController::class, 'delete'])->name('admin.deleteBanner');

        // bank
        Route::get('/banks', [AdminBankController::class, 'index'])->name('admin.indexBank');
        Route::get('/banks/create', [AdminBankController::class, 'create'])->name('admin.createBank');
        Route::post('/banks/store', [AdminBankController::class, 'store'])->name('admin.storeBank');
        Route::get('/banks/search', [AdminBankController::class, 'search'])->name('admin.searchBank');
        Route::delete('/banks/delete/{id}', [AdminBankController::class, 'delete'])->name('admin.deleteBank');
    });
});

// API
use App\Http\Controllers\Api\BillApiController;

Route::get('/api/hoadon', [BillApiController::class, 'index']);
Route::get('/api/check-bills', [BillApiController::class, 'checkAndUpdateBills']);
Route::get('/admin/banks/{bank}/check-api', [AdminBankController::class, 'checkApi'])->name('admin.checkBankApi');