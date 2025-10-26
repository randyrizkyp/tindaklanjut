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
                                       <li class="breadcrumb-item1"><a href="javascript:void(0)">Rekomendasi</a></li>
                                    </ol>
                                 </div>
                              </div>
                              <div class="row ms-3">
                                 <label type="text" class="form-control form-control-sm" readonly><b>Temuan : </b>{{$temuan->temuan}}</label>
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
                                             <td width="55%" class="text-center">Rekomendasi</td>                                             
                                             <td width="15%" class="text-center">Status</td>                                             
                                             <td width="10%" class="text-center">Opsi</td>                                                                                    
                                          </tr>
                                    </thead>
                                    <tbody>                                       
                                          @foreach($rekom as $rk)
                                          <tr>
                                             <td class="text-center">{{ $loop->iteration }}</td>                                               
                                             <td>{{$rk->rekomendasi->rekomendasi}}</td>
                                             <td class="text-center">
                                                <span class="badge rounded-pill 
                                                   {{ $rk->rekomendasi->status == 0 
                                                      ? 'bg-danger' 
                                                      : ($rk->rekomendasi->status == 1 
                                                            ? 'bg-info' 
                                                            : ($rk->rekomendasi->status == 2 
                                                            ? 'bg-success' 
                                                            : 'bg-primary')) 
                                                   }} badge-sm me-1 mb-1 mt-1">
                                                   {{ $rk->rekomendasi->status == 0 
                                                      ? 'Belum Ditindaklanjuti' 
                                                      : ($rk->rekomendasi->status == 1 
                                                            ? 'Ditindaklanjuti' 
                                                            : ($rk->rekomendasi->status == 2
                                                            ? 'Selesai' 
                                                            : 'Tidak Dapat Ditindaklanjuti')) 
                                                   }}
                                                </span>
                                             </td>
                                             <td class="text-center">
                                                <a href="/bpkpicpjb/{{$fpd->kode_pd}}/{{$lhp->id}}/{{$temuan->id}}/{{$rk->rekomendasi->id}}" class="btn btn-sm btn-success">
                                                   <i class="fa fa-pencil me-2"></i>Detail
                                                </a>                                       
                                             </td>
                                          </tr>
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

@endpush