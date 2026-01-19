<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\DailyReport;
use App\Models\PenilaianHeader;
use App\Models\PenilaianItem;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAnggota = Anggota::count();
        $penilaianSelesai = PenilaianHeader::count();
        $dailyReportBaru = DailyReport::whereDate('created_at', now()->toDateString())->count();

        $latestDaily = DailyReport::latest()->take(5)->get();
        $latestPenilaian = PenilaianHeader::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalAnggota','penilaianSelesai','dailyReportBaru','latestDaily','latestPenilaian'
        ));
    }

    public function daily()
    {
        $daily = DailyReport::with('user')->latest()->paginate(10);
        return view('admin.daily', compact('daily'));
    }

    public function penilaian(Request $request)
    {
        $q = $request->query('q');

        $penilaian = PenilaianHeader::with(['user','items'])
            ->when($q, fn($qq) => $qq->where('pengantin', 'like', "%$q%")->orWhere('tempat', 'like', "%$q%"))
            ->latest()
            ->get();

        return view('admin.penilaian', compact('penilaian'));
    }

    /**
     * Export Daily Report ke Format Microsoft Word (.docx)
     */
    public function exportWord()
    {
        // 1. Ambil data dari database
        $daily = DailyReport::with('user')->latest()->get();

        // 2. Inisialisasi PHPWord
        $phpWord = new PhpWord();
        
        // Atur orientasi kertas ke Landscape agar tabel tidak sempit
        $section = $phpWord->addSection(['orientation' => 'landscape']);

        // 3. Tambah Judul Laporan
        $section->addTitle('LAPORAN DAILY REPORT', 1);
        $section->addText('Tanggal Unduh: ' . Carbon::now()->format('d M Y H:i'));
        $section->addTextBreak(1);

        // 4. Atur Style Tabel
        $styleTable = [
            'borderSize' => 6, 
            'borderColor' => '000000', 
            'cellMargin' => 80
        ];
        $phpWord->addTableStyle('DailyTable', $styleTable);
        $table = $section->addTable('DailyTable');
        
        // 5. Membuat Header Tabel
        $table->addRow();
        $table->addCell(2000)->addText("Waktu", ['bold' => true]);
        $table->addCell(1500)->addText("Nama", ['bold' => true]);
        $table->addCell(1500)->addText("Kegiatan", ['bold' => true]);
        $table->addCell(3000)->addText("Deskripsi", ['bold' => true]);
        $table->addCell(2000)->addText("Foto Lampiran", ['bold' => true]);
        $table->addCell(1500)->addText("User Input", ['bold' => true]);

        // 6. Melakukan Perulangan Data (Foreach)
        foreach ($daily as $d) {
            $table->addRow();
            
            // Kolom Waktu
            $table->addCell(2000)->addText(Carbon::parse($d->tanggal)->format('d M Y') . "\n(" . $d->waktu . ")");
            
            // Kolom Nama & Kegiatan
            $table->addCell(1500)->addText($d->nama);
            $table->addCell(1500)->addText($d->kegiatan);
            
            // Kolom Deskripsi
            $table->addCell(3000)->addText($d->deskripsi ?? '-');

            // Kolom Foto (Logika penempatan gambar)
            $imageCell = $table->addCell(2000);
            $imagePath = public_path('storage/' . $d->file_path);

            if ($d->file_path && file_exists($imagePath)) {
                // Jika file ada di folder storage
                $imageCell->addImage($imagePath, [
                    'width' => 100, // Ukuran gambar dalam pixel
                    'height' => 100, 
                    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
                ]);
            } else {
                // Jika file tidak ditemukan
                $imageCell->addText('Tidak ada foto', ['italic' => true]);
            }

            // Kolom Nama User
            $table->addCell(1500)->addText($d->user->name ?? '-');
        }

        // 7. Proses Penyimpanan ke File Sementara & Download
        $fileName = 'Daily_Report_' . date('Ymd_His') . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    public function exportPenilaian()
    {
        // Ambil semua PenilaianItem dengan header, urutkan berdasarkan posisi, lalu nilai_akhir descending
        $items = PenilaianItem::with('header.user')
            ->orderBy('posisi')
            ->orderBy('nilai_akhir', 'desc')
            ->get();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText('Penilaian Anggota Berdasarkan Posisi', ['bold' => true, 'size' => 16]);
        $section->addText('Tanggal Unduh: ' . Carbon::now()->format('d M Y H:i'));
        $section->addTextBreak(1);

        // Atur style tabel dengan border
        $styleTable = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80
        ];
        $phpWord->addTableStyle('PenilaianTable', $styleTable);
        $table = $section->addTable('PenilaianTable');

        $table->addRow();
        $table->addCell(500)->addText('No', ['bold' => true]);
        $table->addCell(1500)->addText('Posisi', ['bold' => true]);
        $table->addCell(2000)->addText('Nama Anggota', ['bold' => true]);
        $table->addCell(1000)->addText('Nilai Akhir', ['bold' => true]);
        $table->addCell(1500)->addText('User Input', ['bold' => true]);

        $no = 1;
        foreach ($items as $item) {
            $table->addRow();
            $table->addCell(500)->addText($no++);
            $table->addCell(1500)->addText($item->posisi ?? '-');
            $table->addCell(2000)->addText($item->anggota);
            $table->addCell(1000)->addText(number_format($item->nilai_akhir, 2));
            $table->addCell(1500)->addText($item->header->user->name ?? '-');
        }

        $fileName = 'penilaian_per_posisi.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'phpword');
        $phpWord->save($tempFile, 'Word2007');

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}