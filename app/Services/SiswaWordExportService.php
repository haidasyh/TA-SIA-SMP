<?php

namespace App\Exports;

use App\Models\Siswa;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class SiswaWordExportService
{
    public function handle($kelasId, $search, $namaFile)
    {
        $query = Siswa::with('kelas');
        if ($kelasId) { $query->where('kelas_id', $kelasId); }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%')
                  ->orWhere('nisn', 'like', '%' . $search . '%');
            });
        }
        $siswas = $query->get();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addText("LAPORAN DATA SISWA", ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        
        if ($kelasId && isset($siswas[0]->kelas)) {
            $section->addText("Kelas: " . $siswas[0]->kelas->nama_kelas, ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        }
        $section->addText("Tanggal Unduh: " . date('d-m-Y'), ['italic' => true], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $styleTable = ['borderSize' => 6, 'borderColor' => '999999', 'cellMargin' => 80];
        $styleCellHeader = ['bgColor' => 'EEEEEE'];
        $phpWord->addTableStyle('SiswaTable', $styleTable);
        $table = $section->addTable('SiswaTable');

        $table->addRow();
        $table->addCell(800, $styleCellHeader)->addText('No', ['bold' => true]);
        $table->addCell(1500, $styleCellHeader)->addText('NIS', ['bold' => true]);
        $table->addCell(4000, $styleCellHeader)->addText('Nama Siswa', ['bold' => true]);
        $table->addCell(1500, $styleCellHeader)->addText('Kelas', ['bold' => true]);
        $table->addCell(1800, $styleCellHeader)->addText('Jenis Kelamin', ['bold' => true]);

        $no = 1;
        foreach ($siswas as $item) {
            $table->addRow();
            $table->addCell(800)->addText($no++);
            $table->addCell(1500)->addText(htmlspecialchars($item->nis));
            $table->addCell(4000)->addText(htmlspecialchars($item->nama));
            $table->addCell(1500)->addText($item->kelas ? htmlspecialchars($item->kelas->nama_kelas) : '-');
            $table->addCell(1800)->addText(htmlspecialchars($item->jenis_kelamin));
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $pathFile = storage_path($namaFile . '.docx');
        $objWriter->save($pathFile);

        return response()->download($pathFile)->deleteFileAfterSend(true);
    }
}