@extends('admin.templates.main')
@section('content')
<!--app-content open-->
<div class="main-content app-content mt-5">
   <div class="side-app">        
      <div class="main-container container-fluid">                                    
         
         <div class="row">       
            <div class="card">
               <ol class="breadcrumb1">
                  <li class="breadcrumb-item1"><a href="/bpkmatix">LHP</a></li>
                  <li class="breadcrumb-item1"><a href="/bpkdetail/{{$temuan[0]->id_lhp}}">Temuan</a></li>
                  <li class="breadcrumb-item1"><a href="javascript:void(0)">Rekomendasi</a></li>
               </ol>
            </div>           
            <div class="card">
               <div class="card-header">     
                   {{-- <div class="row ms-3">
                                 <label type="text" class="form-control form-control-sm" readonly><b>Temuan : </b>{{$temuan[0]->temuan}}</label>
                              </div>  --}}
                  <div class="col-lg-9">
                     <h4 class=""><b>Temuan : </b>{{$temuan[0]->temuan}}</h4>
                  </div>               
                  <div class="col-lg-3">
                           <button type="button" class="btn btn-primary mb-2 pull-right" data-bs-toggle="modal" data-bs-target="#inputrekomendasi" data-bs-whatever="@mdo">+ Rekomendasi</button>
                  </div>               
               </div>                                             
               <div class="modal fade" id="inputrekomendasi">
                  <div class="modal-dialog modal-lg" role="document">
                     <div class="modal-content modal-content-demo">
                        <form class="form-horizontal" action="/bpkinputrekomendasi" method="POST" enctype="multipart/form-data">
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
                                 <input type="text" class="form-control" readonly disabled value="{{$temuan[0]->temuan}}"></input>
                                 <label for="recipient-name" class="col-form-label mt-2">Rekomendasi :</label>
                                 <textarea type="text" class="form-control" name="rekomendasi" rows='5' required></textarea>
                                 <label for="recipient-name" class="col-form-label mt-2">Jenis Rekomendasi :</label>
                                 <select style="width: 100%;" class="form-control select2" name="jenis_rekom" required>
                                    <option value="1">
                                       Administratif
                                    </option>
                                    <option value="2">
                                       Kerugian
                                    </option>
                                 </select>                         
                                 <label for="recipient-name" class="col-form-label mt-2">Nilai Rekomendasi :</label>
                                 <input class="form-control nilai-rekom" type="text" name="nilai_rekom" id="nilai_rekom" placeholder="Rp 0">

                                 <label for="recipient-name" class="col-form-label mt-2">Perangkat Daerah :</label>
                                 <div class="form-group">
                                    <select style="width: 100%;" class="form-control select2" name="pd[]"multiple required>
                                       @foreach($pd as $apd)
                                       <option value="{{$apd->kode_pd}}">
                                          {{$apd->nama_pd}}
                                       </option>
                                       @endforeach
                                    </select>
                                 </div>
                                 <input type="hidden" name="id_lhp" value="{{$temuan[0]->id_lhp}}">
                                 <input type="hidden" name="id_temuan" value="{{$temuan[0]->id}}">
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
                        <div class="card-body">
                           <div class="table-responsive">
                              <table class="table table-striped table-bordered" id="basic-datatable">
                                 <thead>
                                       <tr>
                                          <td class="w-3">No</td>                                          
                                          <td class="w-40 text-center">Rekomendasi</td>
                                          <td class="w-10 text-center">Perangkat Daerah</td>
                                          <td class="w-10 text-center">Nilai Rekomendasi</td>
                                          <td class="w-30 text-center">Keterangan</td>
                                          <td class="w-5 text-center">Opsi</td>                                                                                    
                                       </tr>
                                 </thead>
                                 <tbody>                                       
                                       @foreach($rekomendasi as $rm)
                                       <tr>
                                          <td class="text-center"><p><small>{{ $loop->iteration }}</small></p></td>
                                          <td style="position: relative; width:120px; height:60px;"><p><small>{{$rm->rekomendasi}}</small></p><br> 
                                             <span class="circle"></span>
                                             @switch($rm->status)
                                                @case('1')
                                                      <span class="dot bg-warning" title="Belum Sesuai"></span>
                                                      @break
                                                @case('2')
                                                      <span class="dot bg-success" title="Selesai"></span>
                                                      @break
                                                @case('4')
                                                      <span class="dot bg-tdt" title="Tidak Dapat Ditindaklanjuti"></span>
                                                      @break
                                                @default
                                                      <span class="dot bg-danger" title="Belum Ditindaklanjuti"></span>
                                             @endswitch
                                          </td>
                                          <td><p><small>
                                             @php
                                                $kodePds = explode('|', $rm->id_pd);
                                                $namaPds = \App\Models\Pd::whereIn('kode_pd', $kodePds)->pluck('nama_lain')->toArray();
                                             @endphp
                                             @foreach($namaPds as $nama)
                                                <span class="badge rounded-pill bg-default badge-sm me-1 mb-1 mt-1">{{$nama}}</span>
                                             @endforeach
                                             </small></p>
                                          </td>
                                          <td class="text-end"><p><small>{{ formatRupiah($rm->nilai_rekom) }}</small></p></td>
                                          <td>{{$rm->ket}}</td>
                                          <td class="text-center"> 
                                             <a href="/bpkdetailrekom/{{$rm->id}}" class="btn btn-sm btn-success m-1">
                                                <i class="fa fa-cogs"></i>
                                             </a>
                                             <button type="button" class="btn btn-sm btn-danger m-1" data-bs-toggle="modal" title="Hapus Rekomendasi" data-bs-target="#hapusrekom_{{$rm->id}}" data-bs-whatever="@mdo"><i class="fa fa-times-circle"></i></button>
                                             <button type="button" class="btn btn-sm btn-warning m-1" data-bs-toggle="modal" title="Edit Rekomendasi" data-bs-target="#editrekom_{{$rm->id}}" data-bs-whatever="@mdo"><i class="fa fa-pencil"></i></button>
                                          </td>
                                       </tr>
                                       <div class="modal fade" id="editrekom_{{$rm->id}}">
                                          <div class="modal-dialog modal-lg" role="document">
                                             <div class="modal-content modal-content-demo">
                                                <form class="form-horizontal" action="/bpkeditrekom/{{$rm->id}}" method="POST" enctype="multipart/form-data">
                                                   @csrf
                                                   @method('PUT')
                                                   <div class="modal-header">
                                                      <h6 class="modal-title">Edit Rekomendasi</h6>
                                                      <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                         <span aria-hidden="true">×</span>
                                                      </button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <div class="mb-3">
                                                         <label class="col-form-label">Temuan :</label>
                                                         <label class="form-control" readonly disabled>{{ $temuan[0]->temuan }}</label>

                                                         <label class="col-form-label mt-1">Rekomendasi :</label>
                                                         <textarea class="form-control" name="rekomendasi" rows="4">{{ $rm->rekomendasi }}</textarea>
                                                        
                                                         <label class="col-form-label mt-1">Nilai Rekomendasi :</label>
                                                         <input class="form-control nilai-rekom" type="text" name="nilai_rekom"
                                                            value="{{ formatRupiah($rm->nilai_rekom, 'Rp', false) }}" placeholder="Rp 0">
                                                         <label class="col-form-label mt-1">Perangkat Daerah :</label>
                                                         <select style="width: 100%;" class="form-control select2" name="pd[]" multiple required>
                                                            @php
                                                               $selectedPd = explode('|', $rm->id_pd);
                                                            @endphp
                                                            @foreach($pd as $kode)
                                                               <option value="{{ $kode->kode_pd }}"
                                                                     {{ in_array($kode->kode_pd, $selectedPd) ? 'selected' : '' }}>
                                                                     {{ $kode->nama_pd }}
                                                               </option>
                                                            @endforeach
                                                         </select>

                                                         <label for="recipient-name" class="col-form-label mt-2">Jenis Rekomendasi :</label>
                                                         <select style="width: 100%;" class="form-control select2" name="jenis_rekom" required>
                                                            <option value="1" {{$rm->jenis == '1' ? 'selected' : ''}}>
                                                               Administratif
                                                            </option>
                                                            <option value="2" {{$rm->jenis == '2' ? 'selected' : ''}}>
                                                               Kerugian
                                                            </option>
                                                         </select>       
                                                         
                                                         <label class="col-form-label mt-1">Status Rekomendasi :</label>
                                                         <select style="width: 100%;" class="form-control select2" name="status">
                                                            <option value="0" {{ $rm->status == 0 ? 'selected' : '' }}>Belum Ditindaklanjuti</option>
                                                            <option value="1" {{ $rm->status == 1 ? 'selected' : '' }}>Ditindaklanjuti</option>
                                                            <option value="2" {{ $rm->status == 2 ? 'selected' : '' }}>Selesai</option>
                                                         </select>

                                                         <label class="col-form-label mt-1">Keterangan :</label>
                                                         <textarea class="form-control" name="ket" rows="4">{{ $rm->ket }}</textarea>

                                                         {{-- hidden input --}}
                                                         <input type="hidden" name="id_lhp" value="{{ $temuan[0]->id_lhp }}">
                                                         <input type="hidden" name="id_temuan" value="{{ $temuan[0]->id }}">
                                                         <input type="hidden" name="id_rekom" value="{{ $rm->id }}">                                                         
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
                                       <div class="modal fade" id="hapusrekom_{{$rm->id}}">
                                          <div class="modal-dialog" role="document">
                                             <div class="modal-content modal-content-demo">
                                                <form class="form-horizontal" action="/bpkhapusrekom" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                   <div class="modal-header">
                                                      <h6 class="modal-title">Hapus Temuan</h6>
                                                      <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                         <span aria-hidden="true">×</span>
                                                      </button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label"><b>Apakah Anda Yakin Menghapus Rekomendasi ini ? <br>
                                                                     Dengan Menghapus Temuan ini, Rekomendasi akan ikut terhapus !!</b>
                                                            </label>
                                                            <input type="hidden" name="id_rekom" value="{{$rm->id}}">
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
                                       @endforeach
                                 </tbody>

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
<!--app-content closed-->





@endsection

@push('script')

<script>
$(document).ready(function() {
   $("#select_pegawai").select2({
      dropdownParent: $('#addPegawai .modal-content')
   });
});


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