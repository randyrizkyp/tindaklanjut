@extends('admin.templates.main')
@section('content')
<!--app-content open-->
<div class="main-content app-content mt-5">
   <div class="side-app">        
      <div class="main-container container-fluid">                                    
         
         <div class="row">               
                  <div class="card">
                     <div class="card-header">                     
                        
                        {{-- <div class="col-lg-4">
                            <button type="button" class="btn btn-green pull-right mt-5" data-bs-toggle="modal" data-bs-target="#input-lhp" data-bs-whatever="@mdo">+ LHP</button>
                        </div>    --}}
                    </div>
                    <div class="modal fade" id="input-lhp">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <form class="form-horizontal" action="/bpkinputlhp" method="POST" enctype="multipart/form-data">
                                @csrf
                                    <div class="modal-header">
                                        <h6 class="modal-title">Tambah LHP</h6>
                                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Nomor LHP :</label>
                                                <input type="text" class="form-control" id="nomorlhp" name="nomorlhp" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="message-text" class="col-form-label">Judul LHP :</label>
                                                <textarea class="form-control" id="judul" name="judullhp" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="message-text" class="col-form-label">Tanggal LHP :</label>
                                                <input class="form-control" type="date" id="judul" name="tanggallhp" required></input>
                                            </div>
                                            <div class="mb-3">
                                                <label for="message-text" class="col-form-label">Alias :</label>
                                                <input class="form-control" type="text" id="aliaslhp" name="aliaslhp" required></input>
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
                              <button type="button" class="px-8 btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-lhp" data-bs-whatever="@mdo">+ Tambah Laporan Hasil Pemeriksaan (LHP)</button>
                              <div class="card-body">
                                 <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="basic-datatable">
                                       <thead>
                                             <tr>
                                                <td width="5%">No</td>                                          
                                                <td width="15%" class="text-center">No LHP</td>
                                                <td width="10%" class="text-center">Tanggal LHP</td>
                                                <td width="20%" class="text-center">Judul LHP</td>
                                                <td width="10%" class="text-center">Alias</td>                                          
                                                <td width="10%" class="text-center">Temuan</td>
                                                <td width="10%" class="text-center">Rekomendasi</td>
                                                <td width="10%" class="text-center">Opsi</td>                                                                                    
                                             </tr>
                                       </thead>
                                       <tbody>                                       
                                             @foreach($lhp as $lh)
                                             <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $lh->nomor }}</td>
                                                <td>{{ \Carbon\Carbon::parse($lh->tanggal)->format('d-m-Y') }}</td>
                                                <td>{{ $lh->judul }}</td>
                                                <td>{{ $lh->alias }}</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center">
                                                   <a href="/bpkdetail/{{$lh->id}}" class="btn btn-sm btn-success">
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