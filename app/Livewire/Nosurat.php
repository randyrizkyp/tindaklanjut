<?php

namespace App\Livewire;

use Livewire\Component;

class Nosurat extends Component
{
     public $nomor_surat = '';

    public function kirim()
    {
        // Logika pengiriman form
        // Misalnya, simpan nomor surat ke database atau kirimkan ke API
        session()->flash('message', 'Nomor surat berhasil dikirim: ' . $this->nomor_surat);
    }

    public function render()
    {
        return view('admin.pengajuancuti.nomor-surat');
    }
}
