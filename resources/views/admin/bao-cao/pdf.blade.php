<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1f2937; }
        h1 { font-size: 16px; margin-bottom: 2px; }
        p.sub { color: #6b7280; margin-top: 0; margin-bottom: 14px; font-size: 10px; }
        .tong-hop { font-size: 13px; font-weight: bold; margin-bottom: 10px; }
        .nhom { font-size: 12px; font-weight: bold; background: #f3f4f6; padding: 6px 8px; margin-top: 14px; }
        .ch { padding: 6px 8px 2px 8px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        th, td { border: 1px solid #e5e7eb; padding: 4px 6px; text-align: left; font-size: 10px; }
        th { background-color: #f9fafb; }
        td.num { text-align: right; }
    </style>
</head>
<body>
    <h1>Báo cáo thống kê chỉ tiêu kinh tế số</h1>
    <p class="sub">Năm {{ $nam }} - Số doanh nghiệp đã nộp: {{ $tongSoDaNop }} - Xuất lúc {{ now()->format('H:i d/m/Y') }}</p>
    <p class="tong-hop">Chỉ số kinh tế số tổng hợp: {{ $diemTongHop !== null ? number_format($diemTongHop, 2) . '/100' : 'Chưa có dữ liệu' }}</p>

    @if (count($xepHang) > 0)
    <p class="tong-hop" style="font-size: 12px;">Xếp hạng doanh nghiệp</p>
    <table>
        <thead>
            <tr><th>STT</th><th>Doanh nghiệp</th><th>Điểm</th><th>Mức đánh giá</th></tr>
        </thead>
        <tbody>
            @foreach ($xepHang as $i => $dn)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $dn['ten'] }}</td>
                <td class="num">{{ $dn['diem'] !== null ? number_format($dn['diem'], 2) : '-' }}</td>
                <td>{{ $dn['muc'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @foreach ($nhoms as $nhom)
        <div class="nhom">{{ $nhom->ten }} (điểm: {{ $nhom->diemNhom !== null ? number_format($nhom->diemNhom, 2) : '-' }})</div>
        @foreach ($nhom->cauHois as $ch)
            <div class="ch">{{ $ch->noi_dung }}</div>
            @if ($ch->loai === 'so')
                <table>
                    <tr><td>Giá trị trung bình</td><td class="num">{{ $ch->trungBinh !== null ? number_format($ch->trungBinh, 2) : 'Chưa có dữ liệu' }}</td></tr>
                </table>
            @else
                <table>
                    <thead>
                        <tr><th>Đáp án</th><th>Số DN</th><th>Tỷ lệ (%)</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($ch->dapAns as $da)
                        <tr>
                            <td>{{ $da->noi_dung }}</td>
                            <td class="num">{{ $da->soLuong }}</td>
                            <td class="num">{{ number_format($da->tyLe, 1) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @endforeach
</body>
</html>