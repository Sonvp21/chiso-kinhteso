<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $nam = (int) date('Y');

    if (auth()->user()->isQuanTri()) {
        $soDaNop = \App\Models\DoanhNghiepKhaoSat::where('nam', $nam)->where('trang_thai', 'da_tinh')->count();
        $soNhom = \App\Models\NhomChiTieu::where('kich_hoat', true)->count();
        $soCauHoi = \App\Models\CauHoi::where('kich_hoat', true)->count();
        $phienBanDangApDung = \App\Models\BoChiSoPhienBan::where('dang_ap_dung', true)->first();

        $baoCaoController = new \App\Http\Controllers\Admin\BaoCaoController();
        $xepHang = $baoCaoController->layXepHang($nam);
        $top5 = array_slice($xepHang, 0, 5);
        $diemTheoNhom = $baoCaoController->layDiemTheoNhom($nam);

        return view('dashboard', compact('nam', 'soDaNop', 'soNhom', 'soCauHoi', 'phienBanDangApDung', 'top5', 'diemTheoNhom'));
    }

    $khaoSatNam = \App\Models\DoanhNghiepKhaoSat::where('user_id', auth()->id())->where('nam', $nam)->first();

    return view('dashboard', compact('nam', 'khaoSatNam'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {

    // Admin
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('phien-ban', \App\Http\Controllers\Admin\BoChiSoPhienBanController::class)->except(['create', 'edit', 'show']);
        Route::get('bao-cao', [\App\Http\Controllers\Admin\BaoCaoController::class, 'index'])->name('bao-cao');
        Route::get('bao-cao/xuat-csv', [\App\Http\Controllers\Admin\BaoCaoController::class, 'xuatCsv'])->name('bao-cao.xuat-csv');
        Route::get('bao-cao/xuat-pdf', [\App\Http\Controllers\Admin\BaoCaoController::class, 'xuatPdf'])->name('bao-cao.xuat-pdf');

        Route::resource('nhom-chi-tieu', \App\Http\Controllers\Admin\NhomChiTieuController::class)->except(['create', 'edit', 'show']);
        Route::get('nhom-chi-tieu/{nhomChiTieu}/cau-hoi', [\App\Http\Controllers\Admin\CauHoiController::class, 'index'])->name('cau-hoi.index');
        Route::post('cau-hoi', [\App\Http\Controllers\Admin\CauHoiController::class, 'store'])->name('cau-hoi.store');
        Route::put('cau-hoi/{cauHoi}', [\App\Http\Controllers\Admin\CauHoiController::class, 'update'])->name('cau-hoi.update');
        Route::delete('cau-hoi/{cauHoi}', [\App\Http\Controllers\Admin\CauHoiController::class, 'destroy'])->name('cau-hoi.destroy');

        Route::post('dap-an', [\App\Http\Controllers\Admin\DapAnController::class, 'store'])->name('dap-an.store');
        Route::put('dap-an/{dapAn}', [\App\Http\Controllers\Admin\DapAnController::class, 'update'])->name('dap-an.update');
        Route::delete('dap-an/{dapAn}', [\App\Http\Controllers\Admin\DapAnController::class, 'destroy'])->name('dap-an.destroy');
    });

    // Doanh nghiệp
    Route::get('khao-sat', [\App\Http\Controllers\KhaoSatDoanhNghiepController::class, 'index'])->name('khao-sat.index');
    Route::post('khao-sat', [\App\Http\Controllers\KhaoSatDoanhNghiepController::class, 'store'])->name('khao-sat.store');
    Route::get('khao-sat/{doanhNghiepKhaoSat}', [\App\Http\Controllers\KhaoSatDoanhNghiepController::class, 'edit'])->name('khao-sat.edit');
    Route::post('khao-sat/{doanhNghiepKhaoSat}/luu', [\App\Http\Controllers\KhaoSatDoanhNghiepController::class, 'luu'])->name('khao-sat.luu');
    Route::post('khao-sat/{doanhNghiepKhaoSat}/nop', [\App\Http\Controllers\KhaoSatDoanhNghiepController::class, 'nop'])->name('khao-sat.nop');
});

require __DIR__ . '/auth.php';