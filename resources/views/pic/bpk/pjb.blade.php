@extends('pic.templates.main')
@section('content')
<!--app-content open-->
<div class="main-content app-content mt-5">
   <div class="side-app">        
      <div class="main-container container-fluid">                                    
         <div class="row">               
            <div class="card">                                                                 
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header">
                           <div class="row">
                              <div class="row">
                                 <div class="col-lg-12">
                                    <ol class="breadcrumb1">
                                       <li class="breadcrumb-item1"><a href="/bpkpic">Perangkat Daerah</a></li>
                                       <li class="breadcrumb-item1"><a href="/bpkpicpd/{{$fpd->kode_pd}}">LHP</a></li>
                                       <li class="breadcrumb-item1"><a href="/bpkpictemuan/{{$fpd->kode_pd}}/{{$lhp->id}}">Temuan</a></li>
                                       <li class="breadcrumb-item1"><a href="/bpkpicrekom/{{$fpd->kode_pd}}/{{$lhp->id}}/{{$temuan->id}}">Rekomendasi</a></li>
                                       <li class="breadcrumb-item1"><a href="javascript:void(0)">Penanggungjawab</a></li>
                                    </ol>
                                 </div>
                              </div>
                              <div class="row ms-3">
                                 <label type="text" class="form-control form-control-sm" readonly><b>Temuan : </b>{{$temuan->temuan}}</label>
                              </div>
                              <div class="row ms-3">
                                 <label type="text" class="form-control form-control-sm" readonly><b>Rekomendasi : </b>{{$rekom->rekomendasi}}</label>
                              </div>
                           </div>
                        </div>
                        <div class="card-body">
                           <div class="row">
                              <div class="table-responsive">
                                 <table class="table table-striped table-bordered" id="basic-datatable">
                                    <thead>
                                          <tr>
                                             <td width="5%">No</td>                                          
                                             <td width="55%" class="text-center">Penanggung Jawab</td>                                             
                                             <td width="15%" class="text-center">Nilai Rekomendasi</td>                                             
                                             <td width="15%" class="text-center">Tindak Lanjut</td>                                             
                                             <td width="15%" class="text-center">Status</td>                                             
                                             <td width="10%" class="text-center">Opsi</td>                                                                                    
                                          </tr>
                                    </thead>
                                    <tbody>        
                                       @foreach($pjb as $pj)                               
                                         <tr>
                                             <td class="text-center">{{$loop->iteration}}</td>
                                             <td>
                                                {{$pj->pjb}}
                                                <button class="btn btn-sm btn-outline-default ms-1" data-bs-container="body" data-bs-content="{{$pj->ket}} " data-bs-placement="top" data-bs-popover-color="default" data-bs-toggle="popover" title="{{$pj->pjb}}"><i class="fa fa-info"></i></button>
                                             </td>
                                             <td class="text-end">{{ formatRupiah($pj->nilai_rekom) }}</td>
                                             <td class="text-end">                                              
                                                <div class="btn btn-sm btn-outline-default form-control" data-bs-toggle="modal" data-bs-target="#tl_{{$pj->id}}">
                                                   <h6 class="mb-0 fw-semibold">Detail</h6>
                                                   <p class="mb-0 fw-normal fs-12">
                                                      <span class="text-success text-end">{{ formatRupiah($pj->pengembalian->sum('nilai_pengembalian')) }}</span>
                                                   </p>
                                                </div>
                                                <div class="modal fade" id="tl_{{$pj->id}}" tabindex="-1" role="dialog">
                                                   <div class="modal-dialog modal-xl" role="document">
                                                         <div class="modal-content">
                                                            <div class="modal-header">
                                                               <h5 class="modal-title">{{$pj->pjb}}</h5>
                                                               <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                  <span aria-hidden="true">×</span>
                                                               </button>
                                                            </div>
                                                            <div class="modal-body">
                                                               <table class="table table-striped table-bordered" id="basic-datatable">
                                                                  <thead>
                                                                        <tr>
                                                                           <td width="5%" class="text-center">No</td>  
                                                                           <td width="35%" class="text-center">Keterangan</td>                                                                                                                                 
                                                                           <td width="5%" class="text-center">Bukti</td>                                             
                                                                           <td width="20%" class="text-center">Tanggal STS / Tanggal Penyerahan STS</td> 
                                                                           <td width="25%" class="text-center">Tindak Lanjut</td>                                             
                                                                           <td width="10%" class="text-center">Opsi</td>                                                                                    
                                                                        </tr>
                                                                  </thead>
                                                                  <tbody>    
                                                                     @foreach($pj->pengembalian as $pngm)    
                                                                     <tr>
                                                                        <td class="text-center">{{$loop->iteration}}</td>
                                                                        <td class="text-start">{{$pngm->ket}}</td>
                                                                        <td class="text-center">
                                                                           @if($pngm->bukti)
                                                                              <a href="{{ asset('storage/' . $pngm->bukti) }}" target="_blank" class="btn btn-sm btn-dark">
                                                                              <i class="fe fe-download"></i>
                                                                              </a>
                                                                           @else
                                                                              <span class="text-muted">Tidak ada bukti</span>
                                                                           @endif
                                                                        </td>
                                                                        <td class="text-center">
                                                                           @if($pngm->nilai_pengembalian == 0)
                                                                           -
                                                                           @else
                                                                           {{  \Carbon\Carbon::parse($pngm->tgl_sts)->format('d-m-Y') }} / 
                                                                           {{ \Carbon\Carbon::parse($pngm->tgl_terima_sts)->format('d-m-Y') }}
                                                                           @endif                                                                           
                                                                        </td>
                                                                        <td class="text-end">{{formatRupiah($pngm->nilai_pengembalian)}}</td>
                                                                        <td class="text-center">
                                                                           <button class="btn btn-sm btn-outline-default ms-1" 
                                                                              data-bs-container="#tl_{{$pj->id}}"
                                                                              data-bs-content="Di Input Oleh : {{$pngm->login->nama}} <br> 
                                                                                 Tanggal : {{ \Carbon\Carbon::parse($pngm->created_at)->format('d-m-Y H:i:s') }} <br>
                                                                                 Input SIPTL : {{$pngm->siptl == 1 ? '<i class="icon icon-check"></i>' : '<i class="icon icon-close"></i>'}} " 
                                                                              data-bs-placement="top" 
                                                                              data-bs-toggle="popover" 
                                                                              data-bs-html="true"
                                                                              title="{{$pngm->login->nama}}">
                                                                              <i class="fa fa-info"></i>
                                                                           </button>
                                                                           <a href="/bpkpichapuspjb/{{$pngm->id}}"
                                                                              onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus data ini?')) { 
                                                                                 document.getElementById('delete-form-{{ $pngm->id }}').submit(); 
                                                                              }"
                                                                              class="btn btn-sm btn-danger">
                                                                              <i class="fa fa-trash"></i>
                                                                           </a>
                                                                           <form id="delete-form-{{ $pngm->id }}" 
                                                                                 action="/bpkpichapuspjb/{{$pngm->id}}" 
                                                                                 method="GET" 
                                                                                 style="display: none;">
                                                                              @csrf
                                                                              @method('DELETE')
                                                                           </form>
                                                                        </td>                                                                        
                                                                     </tr>
                                                                     @endforeach
                                                                     <tr>
                                                                        <td colspan="4" class="text-end fw-bold">Jumlah</td>
                                                                        <td class="text-end fw-bold">{{formatRupiah($pj->pengembalian->sum('nilai_pengembalian'))}}</td>
                                                                     </tr>
                                                                  </tbody>
                                                               </table>       
                                                            </div>
                                                            <div class="modal-footer">
                                                               <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                               {{-- <button class="btn btn-primary">Save changes</button> --}}
                                                            </div>
                                                         </div>
                                                   </div>
                                                </div>
                                             </td>
                                            <td class="text-center">
                                                @if($pj->status == 2)
                                                   <span class="tag tag-radius tag-round tag-outline-success" title="Selesai">S</span>
                                                @elseif(count($pj['pengembalian']) === 0)
                                                   <span class="tag tag-radius tag-round tag-outline-danger" title="Belum Tindaklanjut">BT</span>                                                
                                                @else
                                                   <span class="tag tag-radius tag-round tag-outline-info" title="Sedang Ditindaklanjuti">DT</span>
                                                @endif  
                                             </td>
                                             <td >
                                                <button class="btn btn-secondary btn-sm bg-secondary text-center" data-bs-toggle="modal" data-bs-target="#addpengembalian_{{$pj->id}}"><i class="fa fa-plus"></i></button>                                             
                                                <div class="modal fade" id="addpengembalian_{{$pj->id}}">
                                                   <div class="modal-dialog modal-lg" role="document">
                                                      <div class="modal-content modal-content-demo">
                                                         <form class="form-horizontal" action="/bpkpicinputpbj/{{$pj->id}}" method="POST" enctype="multipart/form-data">
                                                         @csrf
                                                            <div class="modal-header">
                                                                  <h6 class="modal-title">{{$pj->pjb}}</h6>
                                                                  <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                                     <span aria-hidden="true">×</span>
                                                                  </button>
                                                            </div>
                                                            <div class="modal-body">
                                                               <div class="mb-3">
                                                                  <label for="recipient-name" class="col-form-label">Keterangan : </label>
                                                                  <textarea class="form-control" type="text" name="ket" required></textarea>
                                                                  <label for="recipient-name" class="col-form-label mt-2">Jumlah Pengembalian :</label>
                                                                  <input class="form-control rupiah" type="text" name="nilai_rekom" placeholder="Rp 0" inputmode="numeric">
                                                                  <label for="recipient-name" class="col-form-label mt-2">Tanggal STS : </label>
                                                                  <input class="form-control" type="date" name="tgl_sts">
                                                                  <label for="recipient-name" class="col-form-label mt-2">Tanggal Terima STS : </label>
                                                                  <input class="form-control" type="date" name="tgl_terima_sts">
                                                                  <label for="recipient-name" class="col-form-label mt-2">Bukti Dikung : </label>
                                                                  <input class="form-control" type="file" name="bukti" required>                                                                 
                                                               </div> 
                                                            </div>
                                                            <div class="modal-footer">
                                                                  <input type="hidden" name="judul_lhp" value="{{$lhp->judul}}">
                                                                  <input type="hidden" name="id_rekom" value="{{$rekom->id}}">
                                                                  <button class="btn ripple btn-success" type="submit">Kirim</button>
                                                                  <button class="btn ripple btn-danger" data-bs-dismiss="modal" type="button">Tutup</button>
                                                            </div>
                                                         </form>
                                                      </div>  
                                                   </div>        
                                                </div>            
                                             </td>
                                         </tr>
                                         @endforeach
                                    </tbody>
                                     <tfoot>
                                          <tr>
                                             <th colspan="2" class="text-end">Jumlah</th>
                                             <th class="text-end">{{formatRupiah($pjb->sum('nilai_rekom'))}}</th>
                                             <th class="text-end">{{formatRupiah($pjb->flatMap->pengembalian->sum('nilai_pengembalian'))}}</th>                                             
                                          </tr>
                                    </tfoot>
                                 </table>                                                        
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>            
      </div>        
   </div>
</div>
<!--app-content closed-->





@endsection

@push('script')
<script>
   .popover {
  z-index: 99999 !important;
}
</script>
{{-- <script>
    const rupiahInput = document.getElementById('nilai_rekom');

    rupiahInput.addEventListener('keyup', function(e) {
        rupiahInput.value = formatRupiah(this.value, 'Rp ');
    });

    function formatRupiah(angka, prefix){
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   	 = number_string.split(','),
            sisa     	 = split[0].length % 3,
            rupiah     	 = split[0].substr(0, sisa),
            ribuan     	 = split[0].substr(sisa).match(/\d{3}/gi);

        if(ribuan){
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix === undefined ? rupiah : (rupiah ? prefix + rupiah : '');
    }
</script> --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

  // Format nilai input menjadi "Rp 1.234.567,89"
  function formatRupiahString(value) {
    if (!value) return '';
    // Hanya ambil angka dan koma
    value = value.toString().replace(/[^,\d]/g, '');
    const parts = value.split(',');
    let integer = parts[0];
    const decimal = parts[1];

    let sisa = integer.length % 3;
    let rupiah = integer.substr(0, sisa);
    const ribuan = integer.substr(sisa).match(/\d{3}/g);

    if (ribuan) {
      const separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = decimal !== undefined ? rupiah + ',' + decimal : rupiah;
    return rupiah ? 'Rp ' + rupiah : '';
  }

  // Pasang listener ke semua input dengan kelas .rupiah
  document.querySelectorAll('.rupiah').forEach(function(input) {
    // format awal kalau ada value
    if (input.value) {
      input.value = formatRupiahString(input.value);
    }

    input.addEventListener('input', function(e) {
      const caret = this.selectionStart; // (simple caret handling)
      this.value = formatRupiahString(this.value);
      // note: caret position restore bisa rumit setelah formatting; ini simple approach
      // jika butuh menjaga posisi kursor presisi, bisa ditingkatkan nanti
    });
  });

});
</script>

@endpush