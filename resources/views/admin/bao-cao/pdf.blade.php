<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1f2937; }
        h1 { font-size: 16px; margin-bottom: 2px; }
        p.sub { color: #6b7280; margin-top: 0; margin-bottom: 14px; font-size: 10px; }
        .nhom { font-size: 12px; font-weight: bold; background: #f3f4f6; padding: 6px 8px; margin-top: 14px; }
        .ch { padding: 6px 8px 2px 8px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        th, td { border: 1px solid #e5e7eb; padding: 4px 6px; text-align: left; font-size: 10px; }
        th { background-color: #f9fafb; }
        td.num { text-align: right; }
    </style>
</head>
<body>
    <h1>Bao cao thong ke chi tieu kinh te so</h1>
    <p class="sub">Nam {{ $nam }} - So doanh nghiep da nop: {{ $tongSoDaNop }} - Xuat luc {{ now()->format('H:i d/m/Y') }}</p>

    @foreach ($nhoms as $nhom)
        <div class="nhom">{{ $nhom->ten }}</div>
        @foreach ($nhom->cauHois as $ch)
            <div class="ch">{{ $ch->noi_dung }}</div>
            @if ($ch->loai === 'so')
                <table>
                    <tr><td>Gia tri trung binh</td><td class="num">{{ $ch->trungBinh !== null ? number_format($ch->trungBinh, 2) : 'Chua co du lieu' }}</td></tr>
                </table>
            @else
                <table>
                    <thead>
                        <tr><th>Dap an</th><th>So DN</th><th>Ty le (%)</th></tr>
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
