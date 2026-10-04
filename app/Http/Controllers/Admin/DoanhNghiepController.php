<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoanhNghiepKhaoSat;
use App\Models\User;
use App\Support\NhatKy;
use Illuminate\Http\Request;

class DoanhNghiepController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q'));

        $doanhNghieps = User::with('xaPhuong')
            ->where('role', 'doanh_nghiep')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'ilike', "%{$q}%")
                        ->orWhere('email', 'ilike', "%{$q}%")
                        ->orWhere('ten_doanh_nghiep', 'ilike', "%{$q}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $khaoSats = DoanhNghiepKhaoSat::whereIn('user_id', $doanhNghieps->pluck('id'))
            ->orderBy('nam')
            ->get()
            ->groupBy('user_id');

        return view('admin.doanh-nghiep.index', compact('doanhNghieps', 'khaoSats', 'q'));
    }

    public function destroy(User $user)
    {
        abort_unless($user->role === 'doanh_nghiep', 403, 'Chỉ được xóa tài khoản doanh nghiệp.');

        $ten = $user->ten_doanh_nghiep ?: $user->name;

        NhatKy::ghi('xoa', 'doanh_nghiep', $user->id, "Xóa doanh nghiệp {$ten} ({$user->email})");
        $user->delete();

        return back()->with('success', "Đã xóa doanh nghiệp {$ten} cùng toàn bộ dữ liệu khảo sát.");
    }

    public function moLaiKhaoSat(DoanhNghiepKhaoSat $doanhNghiepKhaoSat)
    {
        $doanhNghiepKhaoSat->update([
            'trang_thai' => 'nhap',
            'ngay_nop' => null,
        ]);

        NhatKy::ghi(
            'sua',
            'doanh_nghiep_khao_sat',
            $doanhNghiepKhaoSat->id,
            "Mở lại khảo sát năm {$doanhNghiepKhaoSat->nam} cho phép doanh nghiệp chỉnh sửa"
        );

        return back()->with('success', "Đã mở lại khảo sát năm {$doanhNghiepKhaoSat->nam}.");
    }
}
