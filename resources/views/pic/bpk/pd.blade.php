@extends('pic.templates.main')
@section('content')
<!--app-content open-->
<div class="main-content app-content mt-5">
   <div class="side-app">        
      <div class="main-container container-fluid">                                    
         
         <div class="row">               
            <div class="card">  
               <div class="card-header">
                  <div>
                     <ol class="breadcrumb1">
                        <li class="breadcrumb-item1"><a href="/bpkpic">Perangkat Daerah</a></li>
                        <li class="breadcrumb-item1"><a href="javascript:void(0)">LHP</a></li>
                     </ol>
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
                                          <td width="5%">No</td>                                          
                                          <td width="20%" class="text-center">LHP</td>                                             
                                          <td width="65%" class="text-center">Judul</td>                                                                                    
                                          <td width="10%" class="text-center">Opsi</td>                                                                                    
                                       </tr>
                                 </thead>
                                 <tbody>                                       
                                       @foreach($lhp as $lhp)
                                       <tr>
                                          <td class="text-center">{{ $loop->iteration }}</td>                                               
                                          <td>{{$lhp->nomor}}</td>
                                          <td>{{$lhp->judul}}</td>
                                          <td class="text-center">
                                             <a href="/bpkpictemuan/{{$fpd->kode_pd}}/{{$lhp->id}}" class="btn btn-sm btn-success">
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