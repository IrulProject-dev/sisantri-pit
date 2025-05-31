<!DOCTYPE html>
<html>

<head>
    <style>
        /* Reset lengkap untuk PDF */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.3;
        }

        .container {
            padding: 15px;
            min-height: 98vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .student-info {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #3498db;
            color: white;
        }

        .status-section {
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }

        .footer {
            margin-top: auto;
            padding: 10px;
            text-align: center;
            color: #666;
            font-size: 0.8em;
            border-top: 1px solid #ddd;
        }

        /* Fix untuk DomPDF */
        @page {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;font-size:20px;">RAPOR PENILAIAN SANTRI</h2>
        </div>

        <div class="student-info">
            <p style="margin:3px 0;"><b>Santri:</b> {{ $assessment->santri->name ?? '-'}}</p>
            <p style="margin:3px 0;"><b>Divisi:</b> {{ $assessment->template->division->name ?? '-'}}</p>
            <p style="margin:3px 0;"><b>Mentor:</b> {{ $assessment->assessor->name ?? '-'}}</p>
            <p style="margin:3px 0;"><b>Periode:</b> {{ $assessment->period->name ?? '-' }}</p>
            <p style="margin:3px 0;"><b>Tanggal:</b> {{ $assessment->date ?? '-' }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width:40%">Komponen</th>
                    <th style="width:25%">Nilai</th>
                    <th style="width:35%">Catatan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($assessment->details as $detail)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 text-sm text-gray-900">
                        {{ $detail->component->name }}
                        @if($detail->component->description)
                        <p class="text-xs text-gray-500 mt-1">{{ $detail->component->description }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-blue-600 font-semibold">
                        {{ $detail->score }}/{{ $detail->component->max_score }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $detail->notes ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="status-section">
            <p style="margin:5px 0;"><b>Status:</b> Aprevvel</p>
            <p style="margin:5px 0;"><b>Catatan Umum:</b> wah agak laen orangnya</p>
        </div>

        <div style="margin-top:20px; text-align:center">
            <p style="margin:8px 0;">Mentor<br>Mentor User</p>
            <p style="margin:8px 0;">Koordinator Divisi</p>
        </div>

        <div class="footer">
            Dicetak pada: 27 May 2025 02:14<br>
            © 2025 SiSantri PIT
        </div>
    </div>
</body>

</html>
