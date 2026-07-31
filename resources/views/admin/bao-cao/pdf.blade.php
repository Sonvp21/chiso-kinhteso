<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        p.sub { color: #6b7280; margin-top: 0; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e5e7eb; padding: 6px 8px; text-align: left; }
        th { background-color: #f9fafb; font-size: 10px; text-transform: uppercase; color: #6b7280; }
        .stats { margin-bottom: 16px; }
        .stats span { display: inline-block; margin-right: 24px; }
        .stats b { display: block; font-size: 16px; }
        .badge { padding: 2px 8px; border-radius: 10px; font-size: 10px; }
        .badge-tot { background-color: #d1fae5; color: #047857; }
        .badge-kha { background-color: #dbeafe; color: #1d4ed8; }
        .badge-tb { background-color: #fef3c7; color: #b45309; }
        .badge-thap { background-color: #fee2e2; color: #b91c1c; }
    </style>
</head>
<body>
    <h1>Báo cáo tổng hợp Chỉ số Kinh tế số</h1>
    <p class="sub">Xuất lúc {{ now()->format('H:i d/m/Y') }}</p>

    <div class="stats">
        <span>Khảo sát đã nộp<b>{{ $khaoSats->count() }}</b></span>
        <span>Điểm trung bình<b>{{ number_format($diemTB, 2) }}</b></span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Doanh nghiệp</th>
                <th>Xã/Phường</th>
                <th>Phiên bản</th>
                <th>Ngày nộp</th>
                <th>Điểm tổng hợp</th>
                <th>Mức đánh giá</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($khaoSats as $ks)
            @php
                $m = $ks->ketQua->muc_danh_gia ?? '';
                $badgeClass = $m === 'Tốt' ? 'badge-tot' : ($m === 'Khá' ? 'badge-kha' : ($m === 'Trung bình' ? 'badge-tb' : 'badge-thap'));
            @endphp
            <tr>
                <td>{{ $ks->user->ten_doanh_nghiep ?: $ks->user->name }}</td>
                <td>{{ $ks->user->xaPhuong->ten_xa ?? '—' }}</td>
                <td>{{ $ks->phienBan->ten_phien_ban ?: $ks->phienBan->nam }}</td>
                <td>{{ $ks->ngay_nop?->format('d/m/Y') }}</td>
                <td>{{ number_format($ks->ketQua->diem_tong_hop ?? 0, 2) }}</td>
                <td><span class="badge {{ $badgeClass }}">{{ $m }}</span></td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; color:#9ca3af;">Chưa có khảo sát nào được nộp.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
