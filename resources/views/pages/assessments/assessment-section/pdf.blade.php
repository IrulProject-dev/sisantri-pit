<!DOCTYPE html>
<html>
<head>
    <style>
        /* Tambahkan styling khusus untuk PDF */
        body { font-family: DejaVu Sans, sans-serif; }
        .header-pdf { border-bottom: 2px solid #2563eb; padding-bottom: 20px; }
        .table-pdf th { background: #f3f4f6; }
    </style>
</head>
<body>
    <!-- Reuse komponen yang sama dengan modifikasi styling -->
    @include('pages.assessments.rapots.pdf-raport', ['assessment' => $assessment])
</body>
</html>
