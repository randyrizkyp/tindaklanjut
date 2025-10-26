@extends('admin.templates.main')
@section('content')
<!--app-content open-->
<div class="main-content app-content mt-5">
   <div class="side-app">        
      <div class="main-container container-fluid">                                    
         
         <div class="row">               
            <div class="card">                                            
               <div class="modal fade" id="inputrekomendasi">
                  <div class="modal-dialog modal-lg" role="document">
                     <div class="modal-content modal-content-demo">
                        <form class="form-horizontal" action="/bpkinputpjbrekom" method="POST" enctype="multipart/form-data">
                        @csrf
                           <div class="modal-header">
                                 <h6 class="modal-title">Tambah Rekomendasi</h6>
                                 <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                 </button>
                           </div>
                           <div class="modal-body">
                              <div class="mb-3">
                                 <label for="recipient-name" class="col-form-label">Temuan :</label>
                                 <label type="text" class="form-control" readonly disabled>{{$temuan->temuan}}</label>
                                 <label for="recipient-name" class="col-form-label mt-1">Rekomendasi :</label>
                                 <label type="text" class="form-control" readonly disabled>{{$rekomendasi->rekomendasi}}</label>
                                 <label for="recipient-name" class="col-form-label mt-1">Penganggung Jawab :</label>
                                 <input type="text" class="form-control" name="pjbrekom" required>
                                 <label for="recipient-name" class="col-form-label mt-1">Keterangan :</label>
                                 <textarea type="text" class="form-control" name="ket" required></textarea>
                                 <label for="recipient-name" class="col-form-label mt-1">Jenis Rekomendasi :</label>
                                 <select style="width: 100%;" class="form-control select2" name="jenis_rekom">
                                    <option value="1">
                                       Administratif
                                    </option>
                                    <option value="2">
                                       Kerugian
                                    </option>
                                 </select>                         
                                 <label for="recipient-name" class="col-form-label mt-2">Nilai Rekomendasi :</label>
                                 <input class="form-control nilai-rekom" type="text" name="nilai_rekom"
                                    placeholder="Rp 0">
                                 <label for="recipient-name" class="col-form-label mt-2">Perangkat Daerah :</label>
                                 <div class="form-group">
                                    <select class="selectpicker form-control" required data-live-search="true" name="pd" title="Pilih Perangkat Daerah">
                                       @foreach($fpd as $pd)
                                          <option value="{{$pd->kode_pd}}">
                                             {{$pd->nama_pd}}
                                          </option>
                                       @endforeach
                                    </select>
                                 </div>
                                 <input type="hidden" name="id_lhp" value="{{$temuan->id_lhp}}">
                                 <input type="hidden" name="id_temuan" value="{{$temuan->id}}">
                                 <input type="hidden" name="id_rekom" value="{{$rekomendasi->id}}">
                              </div> 
                           </div>
                           <div class="modal-footer">
                                 <button class="btn ripple btn-success" type="submit">Save changes</button>
                                 <button class="btn ripple btn-danger" data-bs-dismiss="modal" type="button">Close</button>
                           </div>
                        </form>
                     </div>  
                  </div>        
               </div>                             
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header">
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="row mb-1">
                                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Temuan</label>
                                    <div class="col-sm-10">
                                       <label type="text" class="form-control form-control-sm" readonly>{{$temuan->temuan}}</label>
                                    </div>
                                 </div>               
                                 <div class="row">
                                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Rekomendasi</label>
                                    <div class="col-sm-10">
                                       <label type="text" class="form-control form-control-sm" readonly>{{$rekomendasi->rekomendasi}}</label>
                                    </div>
                                 </div>     
                              </div>                                       
                           </div>
                        </div>
                        <div class="card-body">
                           <div class="row">
                              <div class="col-lg-1">
                                 <a href="/bpkrekomendasi/{{$temuan->id}}" class="btn btn-warning" title="Kembali">
                                    <i class="fa fa-chevron-left"></i>
                                 </a>   
                              </div>
                              <div class="col-lg-8">
                                 <div class="row">
                                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#inputrekomendasi" data-bs-whatever="@mdo">+ <i class="fa fa-user-circle"></i> Penganggung Jawab</button>                              
                                 </div>
                              </div>
                             <div class="col-lg-3">
                                 <a href="/export-temuan/{{$rekomendasi->id}}" class="btn btn-success" title="Unduh Kertas Kerja">
                                    <i class="fa fa-file-excel-o"></i> Kertas Kerja
                                 </a>   
                              </div>
                           </div>
                           <div class="row">
                              <div class="table-responsive">
                                 <table class="table table-striped table-bordered" id="basic-datatable">
                                    <thead>
                                       <tr>
                                          <td class="w-3">No</td>                                          
                                          <td class="w-30 text-center">Penanggung Jawab</td>
                                          <td class="w-15 text-center">Perangkat Daerah</td>
                                          <td class="w-18 text-center">Nilai Rekomendasi</td>
                                          <td class="w-22 text-center">Tindak Lanjut</td>
                                          <td class="w-10 text-center">Status</td>
                                          <td class="w-10 text-center">Opsi</td>                                                                                    
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
                                          <td>{{ \App\Models\Pd::where('kode_pd', $pj->id_pd)->value('nama_lain') }}</td>
                                          <td class="text-end">{{ formatRupiah($pj->nilai_rekom) }}</td>
                                          <td class="text-end">
                                             {{-- <button class="btn btn-success btn-sm text-center" data-bs-toggle="modal" data-bs-target="#pngm_{{$pj->id}}">{{ formatRupiah($pj->pengembalian->sum('nilai_pengembalian')) }}</button> --}}
                                             <div class="btn btn-sm btn-outline-default form-control" data-bs-toggle="modal" data-bs-target="#pngm_{{$pj->id}}">
                                                   <h6 class="mb-0 fw-semibold">Detail</h6>
                                                   <p class="mb-0 fw-normal fs-12">
                                                      <span class="text-success text-end">{{ formatRupiah($pj->pengembalian->sum('nilai_pengembalian')) }}</span>
                                                   </p>
                                                </div>
                                             <div class="modal fade" id="pngm_{{$pj->id}}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-xl" role="document">
                                                      <div class="modal-content">
                                                         <form class="form-horizontal" action="/validasi" method="POST" enctype="multipart/form-data">
                                                         @csrf
                                                            <div class="modal-header">
                                                               <h5 class="modal-title">{{$pj->pjb}}</h5>
                                                               <button class="btn-close" data-bs-dismiss="modal" aria-label="Close" type="button">
                                                                  <span aria-hidden="true">×</span>
                                                               </button>
                                                            </div>
                                                            <div class="modal-body">
                                                               <table class="table table-striped table-bordered" id="basic-datatable">
                                                                  <thead>
                                                                        <tr>
                                                                           <td width="5%" class="text-center">No</td>  
                                                                           <td width="30%" class="text-center">Keterangan</td>                                                                                                                                 
                                                                           <td width="5%" class="text-center">Bukti</td>                                             
                                                                           <td width="15%" class="text-center">Tanggal STS / Tanggal Penyerahan STS</td> 
                                                                           <td width="15%" class="text-center">Jumlah Pengembalian</td>                                             
                                                                           <td width="10%" class="text-center">Validasi</td>                                             
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
                                                                           <span class="tag tag-radius tag-round tag-outline-success mb-1" title="Tanggal STS">{{  \Carbon\Carbon::parse($pngm->tgl_sts)->format('d-m-Y') }}</span><br>
                                                                           <span class="tag tag-radius tag-round tag-outline-info" title="Penyerahan STS">{{ \Carbon\Carbon::parse($pngm->tgl_terima_sts)->format('d-m-Y') }}</span>                                                                                                                                         
                                                                           @endif                                                                           
                                                                        </td>
                                                                        <td class="text-end">{{formatRupiah($pngm->nilai_pengembalian)}}</td>
                                                                        <td>
                                                                           <div class="custom-controls-stacked">
                                                                              <label class="custom-control custom-checkbox">
                                                                                 <input type="checkbox" class="custom-control-input" name="siptl[]" value="{{$pngm->id}}" 
                                                                                 {{$pngm->siptl == 1 ? 'checked' : ''}}>
                                                                                 <span class="custom-control-label">SIPTL</span>
                                                                              </label>
                                                                           </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                           <a class="btn btn-sm btn-outline-default ms-1" 
                                                                              data-bs-container="#pngm_{{$pj->id}}"
                                                                              data-bs-content="Di Input Oleh : {{$pngm->login->nama}} <br> 
                                                                                 Tanggal : {{ \Carbon\Carbon::parse($pngm->created_at)->format('d-m-Y H:i:s') }} <br>
                                                                                 Input SIPTL : {{$pngm->siptl == 1 ? '<i class="icon icon-check"></i>' : '<i class="icon icon-close"></i>'}} " 
                                                                              data-bs-placement="top" 
                                                                              data-bs-toggle="popover" 
                                                                              data-bs-html="true"
                                                                              title="{{$pngm->login->nama}}">
                                                                              <i class="fa fa-info"></i>
                                                                           </a>
                                                                           <a href="/bpkhapuspjb/{{ $pngm->id }}" 
                                                                              onclick="return confirm('Yakin ingin menghapus data ini?')" 
                                                                              class="btn btn-sm btn-danger">
                                                                              <i class="fa fa-trash"></i>
                                                                           </a>
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
                                                            <input type="hidden" name="id_pjb" value="{{$pj->id}}">
                                                            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                                                            <button class="btn btn-primary">Save changes</button>
                                                         </div>
                                                         </form>
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
                                          <td class="text-center">
                                             <button type="button" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editpjbrekom_{{$pj->id}}" data-bs-whatever="@mdo"><i class="fa fa-pencil"></i></button>                              
                                             <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapuspjbrekom_{{$pj->id}}" data-bs-whatever="@mdo"><i class="fa fa-trash"></i></button>                              
                                          </td>
                                       </tr>                                          
                                       <div class="modal fade" id="hapuspjbrekom_{{$pj->id}}">
                                          <div class="modal-dialog" role="document">
                                             <div class="modal-content modal-content-demo">
                                                <form class="form-horizontal" action="/bpkhapuspjbrekom" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                   <div class="modal-header">
                                                      <h6 class="modal-title">Hapus Penanggung Jawab</h6>
                                                      <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                         <span aria-hidden="true">×</span>
                                                      </button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label">
                                                               <b>Apakah Anda Yakin Menghapus Penanggung Jawab ini ? <br>
                                                                  Dengan Menghapus ini, Seluruh Eviden Akan ikut terhapus !!</b>
                                                            </label>
                                                            <input type="hidden" name="id_pjbrekom" value="{{$pj->id}}">
                                                      </div>
                                                   </div>
                                                   <div class="modal-footer">
                                                      <button class="btn ripple btn-danger" type="submit">Hapus</button>
                                                      <button class="btn ripple btn-warning" data-bs-dismiss="modal" type="button">Tidak</button>
                                                   </div>
                                                </form>

                                             </div>  
                                          </div>        
                                       </div>   
                                        <div class="modal fade" id="editpjbrekom_{{$pj->id}}">
                                          <div class="modal-dialog modal-lg" role="document">
                                             <div class="modal-content modal-content-demo">
                                                <form class="form-horizontal" action="/bpkeditpjbrekom" method="POST" enctype="multipart/form-data">
                                                   @csrf
                                                   @method('PUT')
                                                   <div class="modal-header">
                                                      <h6 class="modal-title">Edit Penanggung Jawab Rekomendasi</h6>
                                                      <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                         <span aria-hidden="true">×</span>
                                                      </button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <div class="mb-3">
                                                         <label class="col-form-label">Temuan :</label>
                                                         <label class="form-control" readonly disabled>{{ $temuan->temuan }}</label>

                                                         <label class="col-form-label mt-1">Rekomendasi :</label>
                                                         <label class="form-control" readonly disabled>{{ $pj->rekomendasi->rekomendasi }}</label>

                                                         <label class="col-form-label mt-1">Penanggung Jawab :</label>
                                                         <input type="text" class="form-control" name="pjbrekom" value="{{ $pj->pjb }}" required>

                                                         <label class="col-form-label mt-1">Keterangan</label>
                                                         <textarea type="text" class="form-control" name="ket" required>{{ $pj->ket }}</textarea>

                                                         <label class="col-form-label mt-1">Jenis Rekomendasi :</label>
                                                         <select style="width: 100%;" class="form-control select2" name="jenis_rekom">
                                                            <option value="1" {{ $pj->jenis == 1 ? 'selected' : '' }}>Administratif</option>
                                                            <option value="2" {{ $pj->jenis == 2 ? 'selected' : '' }}>Kerugian</option>
                                                         </select>

                                                         <label class="col-form-label mt-1">Status Rekomendasi :</label>
                                                         <select style="width: 100%;" class="form-control select2" name="status">
                                                            <option value="0" {{ $pj->status == 0 ? 'selected' : '' }}>Belum Ditindaklanjuti</option>
                                                            <option value="1" {{ $pj->status == 1 ? 'selected' : '' }}>Ditindaklanjuti</option>
                                                            <option value="2" {{ $pj->status == 2 ? 'selected' : '' }}>Selesai</option>
                                                         </select>

                                                         <label class="col-form-label mt-1">Nilai Rekomendasi :</label>
                                                        <input class="form-control nilai-rekom" type="text" name="nilai_rekom"
                                                            value="{{ formatRupiah($pj->nilai_rekom, 'Rp', false) }}" placeholder="Rp 0">
                                                         <label class="col-form-label mt-1">Perangkat Daerah :</label>
                                                         <div class="form-group">
                                                            <select class="selectpicker form-control" required data-live-search="true" name="pd" title="Pilih Perangkat Daerah">
                                                               @foreach($fpd as $pd)
                                                                  <option value="{{ $pd->kode_pd }}"
                                                                     {{ $pj->id_pd == $pd->kode_pd ? 'selected' : '' }}>
                                                                     {{ $pd->nama_pd }}
                                                                  </option>
                                                               @endforeach
                                                            </select>
                                                         </div>

                                                         {{-- hidden input --}}
                                                         <input type="hidden" name="id_lhp" value="{{ $temuan->id_lhp }}">
                                                         <input type="hidden" name="id_temuan" value="{{ $temuan->id }}">
                                                         <input type="hidden" name="id_rekom" value="{{ $pj->id_rekom }}">
                                                         <input type="hidden" name="id_pjb" value="{{ $pj->id }}">
                                                      </div> 
                                                   </div>
                                                   <div class="modal-footer">
                                                      <button class="btn ripple btn-success" type="submit">Update</button>
                                                      <button class="btn ripple btn-danger" data-bs-dismiss="modal" type="button">Close</button>
                                                   </div>
                                                </form>
                                             </div>  
                                          </div>        
                                       </div>
                                       @endforeach
                                    </tbody>
                                    <tfoot>
                                          <tr>
                                             <th colspan="3" class="text-end">Jumlah</th>
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
<script>
function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split         = number_string.split(","),
        sisa          = split[0].length % 3,
        rupiah        = split[0].substr(0, sisa),
        ribuan        = split[0].substr(sisa).match(/\d{3}/gi);

    if(ribuan){
        let separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? prefix + " " + rupiah : "");
}

// apply ke semua input dengan class .nilai-rekom
document.querySelectorAll('.nilai-rekom').forEach(function(input){
    input.addEventListener('input', function(){
        this.value = formatRupiah(this.value, 'Rp');
    });
});
</script>
<style>
    .dot {
        position: absolute;
        top: 5px;     /* jarak dari atas */
        right: 5px;   /* jarak dari kanan */
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    .bg-warning { background-color: orange; }
    .bg-success { background-color: green; }
    .bg-danger  { background-color: red; }
    .bg-tdt  { background-color: purple; }
</style>
@endpush