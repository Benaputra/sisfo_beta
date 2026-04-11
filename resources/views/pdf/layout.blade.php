<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.5; font-size: 12pt; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px double #000; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 10pt; }
        .content { margin-top: 20px; }
        .footer { margin-top: 40px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table td { padding: 5px 0; vertical-align: top; }
        .signature-area { width: 100%; margin-top: 40px; }
        .signature-box { float: right; width: 250px; text-align: center; }
        .signature-space { height: 80px; }
        .signature-img { height: 80px; }
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi</h2>
        <h2>Universitas Gadjah Mada</h2>
        <h3>Fakultas Pertanian</h3>
        <p>Jl. Flora, Bulaksumur, Yogyakarta, 55281 | Telp: (0274) 551234</p>
    </div>
    <div class="content">
        @yield('content')
    </div>
</body>
</html>
