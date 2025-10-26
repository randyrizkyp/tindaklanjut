<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeSheet;

class DataExport implements WithEvents
{
    use Exportable, RegistersEventListeners;

    protected static $data; // ✅ Define static variable

    public function __construct($data)
    {
        self::$data = $data; // ✅ Assign data to static variable
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $spreadsheet = IOFactory::load(storage_path('app/templates/template.xlsx'));
                $sheet = $spreadsheet->getActiveSheet();

                $startRow = 2; // Baris awal untuk data

                foreach (self::$data as $index => $row) {
                    $sheet->setCellValue('A' . ($startRow + $index), $index + 1); // No
                    $sheet->setCellValue('B' . ($startRow + $index), $row['nama']); // Email
                    $sheet->setCellValue('C' . ($startRow + $index), '`' . $row['nip']); // Nama
                    $sheet->setCellValue('D' . ($startRow + $index), $row['tahun']); // Email
                    $sheet->setCellValue('E' . ($startRow + $index), $row['tanggal']); // Email
                    if($row['jeniscuti'] == 1){
                        $sheet->setCellValue('F' . ($startRow + $index), 'Cuti Tahunan');
                    }elseif($row['jeniscuti'] == 2){
                        $sheet->setCellValue('F' . ($startRow + $index), 'Cuti Besar');
                    }elseif($row['jeniscuti'] == 3){
                        $sheet->setCellValue('F' . ($startRow + $index), 'Cuti Sakit');
                    }elseif($row['jeniscuti'] == 4){
                        $sheet->setCellValue('F' . ($startRow + $index), 'Cuti Melahirkan');
                    }else{
                        $sheet->setCellValue('F' . ($startRow + $index), 'Cuti Karena Alasan Penting');
                    }
                       
                     // Tanggal Lahir
                    $sheet->setCellValue('G' . ($startRow + $index), $row['tglmulai']); // Tanggal Lahir
                    $sheet->setCellValue('H' . ($startRow + $index), $row['tglselesai']); // Tanggal Lahir
                    $sheet->setCellValue('I' . ($startRow + $index), $row['status']); // Tanggal Lahir
                    $sheet->setCellValue('J' . ($startRow + $index), $row['alamatcuti']); // Tanggal Lahir
                    $sheet->setCellValue('K' . ($startRow + $index), $row['telepon']); // Tanggal Lahir
                    $sheet->setCellValue('L' . ($startRow + $index), $row['catatan']); // Tanggal Lahir
                }

                // Tambahkan sheet yang telah diisi ke dalam dokumen utama
                $event->sheet->getDelegate()->getParent()->removeSheetByIndex(0);
                $event->sheet->getDelegate()->getParent()->addExternalSheet($sheet);
            }
        ];
    }
}
