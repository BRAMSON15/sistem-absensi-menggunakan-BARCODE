<?php

namespace App\Services;

use App\Models\Kelas;

class LaporanService
{
    protected $absensiService;

    public function __construct(AbsensiService $absensiService)
    {
        $this->absensiService = $absensiService;
    }

    /**
     * Generate attendance report
     */
    public function generateReport(Kelas $kelas, string $startDate, string $endDate)
    {
        $absensis = $this->absensiService->getAbsensiByDateRange($kelas, $startDate, $endDate);
        $statistics = $this->absensiService->getStatistics($absensis);
        $reportPerSiswa = $this->absensiService->getReportPerSiswa($kelas, $absensis);

        return [
            'absensis' => $absensis,
            'statistics' => $statistics,
            'report_per_siswa' => $reportPerSiswa,
        ];
    }

    /**
     * Generate CSV data for export
     */
    public function generateCsvData(Kelas $kelas, string $startDate, string $endDate)
    {
        $absensis = $this->absensiService->getAbsensiByDateRange($kelas, $startDate, $endDate);

        $csvData = [];

        // Header information
        $csvData[] = ['Laporan Absensi'];
        $csvData[] = ['Kelas', $kelas->nama_kelas];
        $csvData[] = ['Mata Pelajaran', $kelas->mataPelajaran->nama_mapel];
        $csvData[] = ['Guru', $kelas->guru->nama_guru];
        $csvData[] = ['Periode', $startDate . ' s/d ' . $endDate];
        $csvData[] = [];

        // Table header
        $csvData[] = ['No', 'Tanggal', 'NIS', 'Nama Siswa', 'Waktu Scan', 'Status'];

        // Data rows
        foreach ($absensis as $index => $absensi) {
            $csvData[] = [
                $index + 1,
                $absensi->tanggal->format('d/m/Y'),
                $absensi->siswa->nis,
                $absensi->siswa->nama_siswa,
                $absensi->waktu_scan,
                'Hadir',
            ];
        }

        return $csvData;
    }

    /**
     * Generate Excel data for export
     */
    public function generateExcelData(Kelas $kelas, string $startDate, string $endDate)
    {
        $absensis = $this->absensiService->getAbsensiByDateRange($kelas, $startDate, $endDate);
        $statistics = $this->absensiService->getStatistics($absensis);
        $reportPerSiswa = $this->absensiService->getReportPerSiswa($kelas, $absensis);

        return [
            'kelas' => $kelas,
            'absensis' => $absensis,
            'statistics' => $statistics,
            'report_per_siswa' => $reportPerSiswa,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }

    /**
     * Generate CSV file stream
     */
    public function streamCsv(Kelas $kelas, string $startDate, string $endDate)
    {
        $csvData = $this->generateCsvData($kelas, $startDate, $endDate);
        $filename = 'laporan_absensi_' . $kelas->id . '_' . date('YmdHis') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($csvData) {
            $file = fopen('php://output', 'w');
            
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        };

        return [
            'callback' => $callback,
            'headers' => $headers,
            'filename' => $filename,
        ];
    }

    /**
     * Generate Excel HTML for export
     */
    public function generateExcelHtml(Kelas $kelas, string $startDate, string $endDate)
    {
        $data = $this->generateExcelData($kelas, $startDate, $endDate);
        
        $html = '
        <html xmlns:x="urn:schemas-microsoft-com:office:excel">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <xml>
                <x:ExcelWorkbook>
                    <x:ExcelWorksheets>
                        <x:ExcelWorksheet>
                            <x:Name>Laporan Absensi</x:Name>
                            <x:WorksheetOptions>
                                <x:Print>
                                    <x:ValidPrinterInfo/>
                                </x:Print>
                            </x:WorksheetOptions>
                        </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                </x:ExcelWorkbook>
            </xml>
            <style>
                body { font-family: Arial, sans-serif; }
                table { border-collapse: collapse; width: 100%; }
                th, td { 
                    border: 1px solid #000; 
                    padding: 8px; 
                    text-align: left;
                    mso-number-format: "\@"; /* Force text format */
                }
                th { 
                    background-color: #4CAF50; 
                    color: white; 
                    font-weight: bold;
                    text-align: center;
                }
                .header-info { margin-bottom: 20px; }
                .header-info td { border: none; padding: 4px 8px; }
                .title { 
                    font-size: 18px; 
                    font-weight: bold; 
                    text-align: center;
                    padding: 10px;
                }
                .section-title {
                    font-size: 14px;
                    font-weight: bold;
                    padding: 10px 0;
                    background-color: #f0f0f0;
                }
                .success { background-color: #d4edda; text-align: center; }
                .warning { background-color: #fff3cd; text-align: center; }
                .center { text-align: center; }
                .number { text-align: center; }
            </style>
        </head>
        <body>
            <table>
                <tr>
                    <td colspan="7" class="title">LAPORAN ABSENSI</td>
                </tr>
            </table>
            
            <table class="header-info">
                <tr>
                    <td width="150"><strong>Kelas</strong></td>
                    <td>: ' . htmlspecialchars($data['kelas']->nama_kelas) . '</td>
                </tr>
                <tr>
                    <td><strong>Mata Pelajaran</strong></td>
                    <td>: ' . htmlspecialchars($data['kelas']->mataPelajaran->nama_mapel) . '</td>
                </tr>
                <tr>
                    <td><strong>Guru</strong></td>
                    <td>: ' . htmlspecialchars($data['kelas']->guru->nama_guru) . '</td>
                </tr>
                <tr>
                    <td><strong>Periode</strong></td>
                    <td>: ' . date('d/m/Y', strtotime($data['start_date'])) . ' - ' . date('d/m/Y', strtotime($data['end_date'])) . '</td>
                </tr>
            </table>
            
            <br>
            
            <table>
                <tr>
                    <td colspan="7" class="section-title">STATISTIK KESELURUHAN</td>
                </tr>
                <tr>
                    <th width="300">Total Hadir</th>
                    <th width="300">Total Absensi</th>
                </tr>
                <tr>
                    <td class="center success"><strong>' . $data['statistics']['total_hadir'] . '</strong></td>
                    <td class="center"><strong>' . $data['statistics']['total_absensi'] . '</strong></td>
                </tr>
            </table>
            
            <br>
            
            <table>
                <tr>
                    <td colspan="7" class="section-title">LAPORAN PER SISWA</td>
                </tr>
                <tr>
                    <th width="50">No</th>
                    <th width="100">NIS</th>
                    <th width="250">Nama Siswa</th>
                    <th width="100">Total Hadir</th>
                    <th width="120">Persentase Hadir</th>
                </tr>';
        
        foreach ($data['report_per_siswa'] as $index => $row) {
            $persentase = $row['total_absensi'] > 0 
                ? number_format(($row['total_hadir'] / $row['total_absensi']) * 100, 1) 
                : 0;
            
            $html .= '<tr>
                <td class="number">' . ($index + 1) . '</td>
                <td>' . htmlspecialchars($row['siswa']->nis) . '</td>
                <td>' . htmlspecialchars($row['siswa']->nama_siswa) . '</td>
                <td class="center success">' . $row['total_hadir'] . '</td>
                <td class="center">' . $persentase . '%</td>
            </tr>';
        }
        
        $html .= '</table>
            
            <br>
            
            <table>
                <tr>
                    <td colspan="6" class="section-title">DETAIL ABSENSI</td>
                </tr>
                <tr>
                    <th width="50">No</th>
                    <th width="120">Tanggal</th>
                    <th width="100">NIS</th>
                    <th width="250">Nama Siswa</th>
                    <th width="100">Waktu Scan</th>
                    <th width="100">Status</th>
                </tr>';
        
        if ($data['absensis']->isEmpty()) {
            $html .= '<tr>
                <td colspan="6" class="center">Tidak ada data absensi pada periode ini</td>
            </tr>';
        } else {
            foreach ($data['absensis'] as $index => $absensi) {
                $statusClass = 'success';
                $statusText = 'Hadir';
                
                $html .= '<tr>
                    <td class="number">' . ($index + 1) . '</td>
                    <td class="center">' . $absensi->tanggal->format('d/m/Y') . '</td>
                    <td>' . htmlspecialchars($absensi->siswa->nis) . '</td>
                    <td>' . htmlspecialchars($absensi->siswa->nama_siswa) . '</td>
                    <td class="center">' . $absensi->waktu_scan . '</td>
                    <td class="center ' . $statusClass . '">' . $statusText . '</td>
                </tr>';
            }
        }
        
        $html .= '</table>
        </body>
        </html>';
        
        return $html;
    }
}
