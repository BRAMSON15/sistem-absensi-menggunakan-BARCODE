<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Absensi - {{ $siswa->nama_siswa }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .preview-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            padding: 2rem;
            max-width: 1000px;
            border: 2px solid #dee2e6;
        }

        .preview-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
        }

        .preview-header h1 {
            font-size: 1.5rem;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .preview-header p {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* ID Card Container */
        .id-card-wrapper {
            display: flex;
            justify-content: center;
            margin: 2rem 0;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 10px;
            border: 2px dashed #adb5bd;
        }

        /* ID Card - KTP Size: 85.6mm x 53.98mm */
        .id-card {
            width: 85.6mm;
            height: 53.98mm;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            border: 3px solid #2c3e50;
            page-break-inside: avoid;
        }

        /* Card Background Pattern */
        .id-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            transform: rotate(30deg);
            pointer-events: none;
        }

        /* Card Header */
        .card-header-ktp {
            background: #f8f9fa;
            padding: 0.4rem 0.6rem;
            text-align: center;
            position: relative;
            z-index: 1;
            border-bottom: 2px solid #2c3e50;
        }

        .card-header-ktp h2 {
            font-size: 0.75rem;
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 0.1rem;
        }

        .card-header-ktp p {
            font-size: 0.55rem;
            color: #495057;
            font-weight: 600;
        }

        /* Card Body */
        .card-body-ktp {
            display: grid;
            grid-template-columns: 35mm 1fr;
            gap: 0.4rem;
            padding: 0.5rem 0.6rem;
            position: relative;
            z-index: 1;
        }

        /* Photo Section */
        .photo-section-ktp {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .photo-frame-ktp {
            width: 30mm;
            height: 35mm;
            border: 3px solid #ffd700;
            border-radius: 5px;
            overflow: hidden;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.3);
        }

        .photo-frame-ktp img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder-ktp {
            font-size: 2.5rem;
            color: #cbd5e0;
        }

        /* Info Section */
        .info-section-ktp {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
        }

        .info-row-ktp {
            margin-bottom: 0.25rem;
        }

        .info-label-ktp {
            font-size: 0.5rem;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.05rem;
        }

        .info-value-ktp {
            font-size: 0.65rem;
            font-weight: bold;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        .info-value-ktp.large {
            font-size: 0.75rem;
        }

        /* Barcode Section */
        .barcode-section-ktp {
            background: white;
            padding: 0.25rem 0.3rem 0.35rem 0.3rem;
            border-radius: 4px;
            text-align: center;
            margin-top: 0.3rem;
            border: 2px solid #ffd700;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            min-height: 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .barcode-container-ktp {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
            min-height: 20px;
        }

        .barcode-container-ktp svg {
            max-width: 100%;
            height: auto;
            max-height: 20px;
        }

        .barcode-number-ktp {
            font-size: 0.55rem;
            font-weight: bold;
            color: #2c3e50;
            margin-top: 0.1rem;
            letter-spacing: 0.5px;
            line-height: 1;
            padding-top: 0.1rem;
        }

        /* School Logo Watermark */
        .school-logo-watermark {
            position: absolute;
            bottom: 0.3rem;
            right: 0.3rem;
            width: 15mm;
            height: 15mm;
            opacity: 0.15;
            z-index: 0;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e9ecef;
        }

        .btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        /* Print Info */
        .print-info {
            text-align: center;
            margin-top: 1.5rem;
            padding: 1rem;
            background: #fff3cd;
            border-radius: 8px;
            border: 1px solid #ffc107;
        }

        .print-info p {
            color: #856404;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .print-info strong {
            color: #664d03;
        }

        .print-info .important {
            background: #ffc107;
            color: #000;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 0.5rem;
            display: inline-block;
        }

        /* Print Styles */
        @media print {
            @page {
                size: A4 portrait;
                margin: 25mm 15mm 20mm 15mm;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            html, body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                background: white;
            }

            body {
                display: flex;
                justify-content: center;
                align-items: flex-start;
                padding-top: 40mm;
            }

            .preview-container {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
                border: none;
                background: transparent;
                width: 100%;
                display: flex;
                justify-content: center;
            }

            .preview-header,
            .action-buttons,
            .print-info {
                display: none !important;
            }

            .id-card-wrapper {
                margin: 0;
                padding: 0;
                background: transparent;
                border: none;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .id-card {
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                page-break-inside: avoid;
                /* Scale up for better visibility */
                transform: scale(2.2);
                transform-origin: center;
                margin: 20mm 0;
            }

            /* Ensure barcode prints correctly */
            .barcode-container-ktp svg {
                width: 100% !important;
                height: auto !important;
                max-height: 20px !important;
            }

            .barcode-section-ktp {
                padding: 0.25rem 0.3rem 0.4rem 0.3rem !important;
                min-height: 34px !important;
            }

            .barcode-number-ktp {
                font-size: 0.55rem !important;
                margin-top: 0.15rem !important;
                padding-top: 0.1rem !important;
                line-height: 1.1 !important;
            }

            /* Ensure borders print */
            .id-card,
            .card-header-ktp,
            .photo-frame-ktp,
            .barcode-section-ktp {
                border-color: #2c3e50 !important;
            }

            .photo-frame-ktp,
            .barcode-section-ktp {
                border-color: #ffd700 !important;
            }

            /* Ensure card is fully visible */
            .id-card {
                overflow: visible !important;
            }
        }

        /* Alternative: Print multiple cards per page */
        @media print {
            .print-multiple .id-card-wrapper {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 10mm;
                padding: 10mm;
            }

            .print-multiple .id-card {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="preview-container">
        <!-- Header -->
        <div class="preview-header">
            <h1>🎓 KARTU ABSENSI SISWA</h1>
            <p>Preview Kartu - Format KTP (85.6mm x 53.98mm)</p>
        </div>

        <!-- ID Card Preview -->
        <div class="id-card-wrapper">
            <div class="id-card">
                <!-- Card Header -->
                <div class="card-header-ktp">
                    <h2>KARTU ABSENSI SISWA</h2>
                    <p>SISTEM ABSENSI BARCODE - SMA</p>
                </div>

                <!-- Card Body -->
                <div class="card-body-ktp">
                    <!-- Photo Section -->
                    <div class="photo-section-ktp">
                        <div class="photo-frame-ktp">
                            @if($siswa->foto)
                                <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_siswa }}">
                            @else
                                <div class="photo-placeholder-ktp">👤</div>
                            @endif
                        </div>
                    </div>

                    <!-- Info Section -->
                    <div class="info-section-ktp">
                        <div>
                            <div class="info-row-ktp">
                                <div class="info-label-ktp">NIS</div>
                                <div class="info-value-ktp large">{{ $siswa->nis }}</div>
                            </div>
                            <div class="info-row-ktp">
                                <div class="info-label-ktp">Nama Lengkap</div>
                                <div class="info-value-ktp">{{ $siswa->nama_siswa }}</div>
                            </div>
                            <div class="info-row-ktp">
                                <div class="info-label-ktp">Kelas / Angkatan</div>
                                <div class="info-value-ktp">{{ $siswa->kelas }} / {{ $siswa->tahun_angkatan }}</div>
                            </div>
                            <div class="info-row-ktp">
                                <div class="info-label-ktp">Jurusan</div>
                                <div class="info-value-ktp">{{ $siswa->jurusan ?? '-' }}</div>
                            </div>
                        </div>

                        <!-- Barcode Section -->
                        <div class="barcode-section-ktp">
                            <div class="barcode-container-ktp">
                                <svg id="barcode"></svg>
                            </div>
                            <div class="barcode-number-ktp">{{ $siswa->nis }}</div>
                        </div>
                    </div>
                </div>

                <!-- Watermark -->
                <div class="school-logo-watermark">
                    <svg viewBox="0 0 100 100" fill="white">
                        <circle cx="50" cy="50" r="45" stroke="white" stroke-width="2" fill="none"/>
                        <text x="50" y="60" text-anchor="middle" font-size="40" font-weight="bold" fill="white">🎓</text>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Print Info -->
        <div class="print-info">
            <p><strong>📏 Ukuran Kartu:</strong> 85.6mm x 53.98mm (Standar KTP/ID Card)</p>
            <p><strong>💡 Tips Cetak:</strong> Gunakan kertas PVC atau kartu plastik untuk hasil terbaik</p>
            <p class="important">⚠️ PENTING: Pilih "Actual Size" atau "100%" pada pengaturan printer, JANGAN pilih "Fit to Page"</p>
            <p style="margin-top: 1rem; font-size: 0.85rem;">
                <strong>Langkah Print:</strong><br>
                1. Klik tombol "Cetak Kartu" di bawah<br>
                2. Pada dialog print, pastikan Scale = 100% atau Actual Size<br>
                3. Pilih orientasi Portrait (Tegak)<br>
                4. Klik Print
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="window.print()">
                🖨️ Cetak Kartu
            </button>
            <button class="btn btn-secondary" onclick="window.close()">
                ✖️ Tutup
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script>
        // Generate barcode with smaller height to fit better
        JsBarcode("#barcode", "{{ $siswa->barcode }}", {
            format: "CODE128",
            width: 1.3,
            height: 20,
            displayValue: false,
            margin: 1,
            marginTop: 0,
            marginBottom: 0
        });
    </script>
</body>
</html>
