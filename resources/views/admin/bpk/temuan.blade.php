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
                  <li class="breadcrumb-item1"><a href="javascript:void(0)">Temuan</a></li>
               </ol>
            </div>              
            <div class="card">
               <button type="button" class="btn btn-primary mt-6" data-bs-toggle="modal" data-bs-target="#inputtemuan" data-bs-whatever="@mdo">+ Temuan</button>

               <div class="modal fade" id="inputtemuan">
                  <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                           <form class="form-horizontal" action="/bpkinputtemuan" method="POST" enctype="multipart/form-data">
                           @csrf
                              <div class="modal-header">
                                    <h6 class="modal-title">Tambah Temuan</h6>
                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">×</span>
                                    </button>
                              </div>
                              <div class="modal-body">
                                       <div class="mb-3">
                                          <label for="recipient-name" class="col-form-label">Temuan :</label>
                                          <textarea type="text" class="form-control" id="nomorlhp" name="temuan" required></textarea>
                                          <input type="hidden" name="id_lhp" value="{{$lhp->id}}">
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
                                          <td class="w-5">No</td>                                          
                                          <td class="w-65 text-center">Temuan</td>
                                          <td class="w-10 text-center">Jumlah Rekomendasi</td>
                                          <td class="w-10 text-center">Rekomendasi Selesai</td>
                                          <td class="w-20 text-center">Opsi</td>                                                                                    
                                       </tr>
                                 </thead>
                                 <tbody>                                       
                                       @foreach($temuan as $tm)
                                       <tr>
                                          <td class="text-center">{{ $loop->iteration }}</td>
                                          <td>{{$tm->temuan}}</td>                                                
                                          <td class="text-center">{{ $tm->rekomendasi_count }}</td>
                                          <td class="text-center">{{ $tm->rekomendasi_selesai_count }}</td>
                                          <td class="text-center">                    
                                             <a href="/bpkrekomendasi/{{$tm->id}}" class="btn btn-sm btn-success">
                                                <i class="fa fa-search"></i>
                                             </a>                                                         
                                             <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edittemuan_{{$tm->id}}" data-bs-whatever="@mdo"><i class="fa fa-pencil"></i></button>
                                             <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapustemuan_{{$tm->id}}" data-bs-whatever="@mdo"><i class="fa fa-times-circle"></i></button>
                                             
                                             {{-- <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edittemuan_{{$tm->id}}" data-bs-whatever="@mdo"><i class="fa fa-search"></i></button> --}}

                                          </td>
                                       </tr>
                                       <div class="modal fade" id="edittemuan_{{$tm->id}}">
                                          <div class="modal-dialog" role="document">
                                             <div class="modal-content modal-content-demo">
                                                <form class="form-horizontal" action="/bpkedittemuan" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                      <div class="modal-header">
                                                         <h6 class="modal-title">Edit Temuan</h6>
                                                         <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                         </button>
                                                      </div>
                                                      <div class="modal-body">
                                                            <div class="mb-3">
                                                                  <label for="recipient-name" class="col-form-label">Temuan :</label>
                                                                  <textarea type="text" class="form-control" id="nomorlhp" name="temuan" required>{{$tm->temuan}}</textarea>
                                                                  <input type="hidden" name="id_temuan" value="{{$tm->id}}">
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
                                       <div class="modal fade" id="hapustemuan_{{$tm->id}}">
                                          <div class="modal-dialog" role="document">
                                             <div class="modal-content modal-content-demo">
                                                <form class="form-horizontal" action="/bpkhapustemuan" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                      <div class="modal-header">
                                                         <h6 class="modal-title">Hapus Temuan</h6>
                                                         <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                         </button>
                                                      </div>
                                                      <div class="modal-body">
                                                         <div class="mb-3">
                                                               <label for="recipient-name" class="col-form-label"><b>Apakah Anda Yakin Menghapus Temuan ini ? <br>
                                                                        Dengan Menghapus Temuan ini, Rekomendasi akan ikut terhapus !!</b>
                                                               </label>
                                                               <input type="hidden" name="id_temuan" value="{{$tm->id}}">
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

@endpush