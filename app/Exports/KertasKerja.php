<?php

namespace App\Exports;

use App\Models\Detail_rekomendasi;
use App\Models\Rekomendasi;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class KertasKerja implements FromArray, WithHeadings, WithStyles, WithCustomStartCell, WithColumnWidths
{
    protected $id_rekom;
    protected $temuan;
    protected $rekom;
    protected $no_lhp;

    public function __construct($id_rekom)
    {
        $this->id_rekom = $id_rekom;

        // Ambil data rekomendasi & temuan & Nomor LHP
        $rekom = Rekomendasi::with(['temuan', 'lhp', 'temuan'])->find($id_rekom);

        $this->temuan = $rekom?->temuan?->temuan ?? '-';
        $this->rekom  = $rekom?->rekomendasi ?? '-';
        $this->no_lhp = $rekom?->lhp?->nomor ?? '-';
    }

    public function array(): array
    {
        $data = Detail_rekomendasi::with('pengembalian', 'pd')
            ->where('id_rekom', $this->id_rekom)
            ->get();

        $rows = [];

        foreach ($data as $detail) {
            // Baris utama rekomendasi
            $rows[] = [
                'id' => $detail->pd->nama_lain ?? '-',
                'pjb' => $detail->pjb,
                'ket' => $detail->ket,
                'nilai_rekom' => (float) $detail->nilai_rekom,
                'nilai_pengembalian' => null,
                'tgl_sts' => '',
                'keterangan_pengembalian' => '',
            ];

            // Baris pengembalian
            foreach ($detail->pengembalian as $peng) {
                $rows[] = [
                    'id' => $detail->pd->nama_lain ?? '-',
                    'pjb' => $detail->pjb,
                    'ket' => '',
                    'nilai_rekom' => null,
                    'nilai_pengembalian' => (float) $peng->nilai_pengembalian,
                    'tgl_sts' => $peng->tgl_sts,
                    'keterangan_pengembalian' => $peng->ket,
                ];
            }
        }

        return $rows;
    }

    public function startCell(): string
    {
        return 'A5'; // karena baris 1–3 digunakan untuk info LHP, temuan, rekomendasi
    }

    public function headings(): array
    {
        return [
            'Perangkat Daerah',
            'Pejabat / Nama',
            'Keterangan',
            'Nilai Rekomendasi',
            'Nilai Pengembalian',
            'Tanggal STS',
            'Keterangan Tindak Lanjut',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 25,
            'C' => 45,
            'D' => 20,
            'E' => 20,
            'F' => 15,
            'G' => 40,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // ========== HEADER INFORMASI ==========
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
        $sheet->mergeCells('A3:G3');

        $sheet->setCellValue('A1', 'Nomor LHP: ' . $this->no_lhp);
        $sheet->setCellValue('A2', 'Nama Temuan: ' . $this->temuan);
        $sheet->setCellValue('A3', 'Nama Rekomendasi: ' . $this->rekom);

        $sheet->getStyle('A1:A3')->getAlignment()
            ->setWrapText(true)
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_TOP);

        // ========== HEADING ==========
        $sheet->getStyle('A5:G5')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // ========== BODY ==========
        $sheet->getStyle('A:G')->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_TOP);

        // Format currency kolom D & E
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle("D6:E{$highestRow}")
            ->getNumberFormat()
            ->setFormatCode('"Rp"#,##0.00_-');

        // Tambahkan total di bawah
        $totalRow = $highestRow + 1;
        $sheet->setCellValue("C{$totalRow}", 'TOTAL');
        $sheet->setCellValue("D{$totalRow}", "=SUBTOTAL(9,D6:D{$highestRow})");
        $sheet->setCellValue("E{$totalRow}", "=SUBTOTAL(9,E6:E{$highestRow})");

        // Format total bold + border atas tebal
        $sheet->getStyle("C{$totalRow}:E{$totalRow}")->applyFromArray([
            'font' => ['bold' => true],
            'borders' => [
                'top' => ['borderStyle' => Border::BORDER_THICK],
            ],
        ]);

        $sheet->getStyle("D{$totalRow}:E{$totalRow}")
            ->getNumberFormat()
            ->setFormatCode('"Rp"#,##0.00_-');

        // Border seluruh tabel
        $sheet->getStyle("A5:G{$totalRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Biarkan tinggi baris otomatis (auto height)
        return [];
    }
}