<?php

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

if (! function_exists('formatRupiah')) {
    /**
     * Format angka jadi Rupiah
     *
     * @param int|float|string $angka
     * @param string $prefix
     * @param bool $withDecimal
     * @return string
     */
    function formatRupiah($angka, $prefix = 'Rp', $withDecimal = true)
    {
        if ($withDecimal) {
            return $prefix . number_format($angka, 2, ',', '.');
        }

        return $prefix . number_format($angka, 2, ',', '.');
    }
}

if (! function_exists('onlyNumbers')) {
    /**
     * Ambil hanya angka dari string
     *
     * @param string $value
     * @return string
     */
    function onlyNumbers($value)
    {
        return preg_replace('/\D/', '', $value);
    }
}

if (! function_exists('currencyToDecimal')) {
    /**
     * Konversi input string format Rupiah (Rp...,71) jadi decimal string
     *
     * @param string $value
     * @return string
     */
    function currencyToDecimal($value)
    {
        $clean = preg_replace('/[^\d.,]/', '', $value); // hapus selain angka . ,
        $clean = str_replace('.', '', $clean);          // hapus ribuan
        $clean = str_replace(',', '.', $clean);         // ubah koma ke titik
        return $clean; // string "171362399.71"
    }
}