<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi - {{ $kela->nama_kelas }}</title>
    <link href="{{asset('css/laporan.css')}}"rel="stylesheet">
</head>
<body>
    <div class="no-print" style="position: fixed; top: 20px; right: 20px; z-index: 1000; background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <button onclick="window.print()" style="background: #e74c3c; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 5px; cursor: pointer; font-size: 1rem; font-weight: bold;">
            🖨️ Print / Save as PDF
        </button>
        <button onclick="window.close()" style="background: #95a5a6; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 5px; cursor: pointer; font-size: 1rem; margin-left: 0.5rem;">
            ✖️ Close
        </button>
    </div>
    
    {!! $html !!}
    
    <script>
        // Auto print dialog on load
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
