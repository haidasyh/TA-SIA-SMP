<?php

namespace App\Services;

use App\Models\Guru;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class GuruWordExportService
{
    public function handle($jenisKelamin, $search, $namaFile)
    {
        $query = Guru::query();
        
        if ($jenisKelamin) { $query->where('jenis_kelamin', $jenisKelamin); }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nip', 'like', '%' . $search . '%');
            });
        }
        $gurus = $query->get();

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText("LAPORAN DATA GURU", ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        if ($jenisKelamin) {
            $section->addText("Jenis Kelamin: " . htmlspecialchars($jenisKelamin), ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        }
        $section->addText("Tanggal Unduh: " . date('d-m-Y'), ['italic' => true], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $styleTable = ['borderSize' => 6, 'borderColor' => '999999', 'cellMargin' => 80];
        $styleCellHeader = ['bgColor' => 'EEEEEE'];
        $phpWord->addTableStyle('GuruTable', $styleTable);
        
        $table = $section->addTable('GuruTable');

        $table->addRow();
        $table->addCell(800, $styleCellHeader)->addText('No', ['bold' => true]);
        $table->addCell(2000, $styleCellHeader)->addText('NIP', ['bold' => true]);
        $table->addCell(4000, $styleCellHeader)->addText('Nama Guru', ['bold' => true]);
        $table->addCell(2000, $styleCellHeader)->addText('Jenis Kelamin', ['bold' => true]);
        $table->addCell(2000, $styleCellHeader)->addText('No. HP', ['bold' => true]);

        $no = 1;
        foreach ($gurus as $item) {
            $table->addRow();
            $table->addCell(800)->addText($no++);
            $table->addCell(2000)->addText(htmlspecialchars($item->nip));
            $table->addCell(4000)->addText(htmlspecialchars($item->nama));
            $table->addCell(2000)->addText(htmlspecialchars($item->jenis_kelamin));
            $table->addCell(2000)->addText(htmlspecialchars($item->no_hp ?? '-'));
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="' . $namaFile . '.docx"');
        header('Cache-Control: max-age=0');

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
        exit;
    }
}