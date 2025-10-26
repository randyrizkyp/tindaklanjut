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
                        <li class="breadcrumb-item1"><a href="/bpkpicpd/{{$fpd->kode_pd}}">LHP</a></li>
                        <li class="breadcrumb-item1"><a href="javascript:void(0)">Temuan</a></li>
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
                                          <td width="50%" class="text-center">Temuan</td>                                             
                                          <td width="15%" class="text-center">Rekomendasi</td>                                             
                                          <td width="15%" class="text-center">Rekomendasi Selesai</td>                                             
                                          <td width="10%" class="text-center">Opsi</td>                                                                                    
                                       </tr>
                                 </thead>
                                 <tbody>                                       
                                       @foreach($temuan as $tm)
                                       <tr>
                                          <td class="text-center">{{ $loop->iteration }}</td>                                               
                                          <td>{{$tm->temuan->temuan}}</td>
                                          <td></td>
                                          <td></td>
                                          <td class="text-center">
                                             <a href="/bpkpicrekom/{{$fpd->kode_pd}}/{{$lhp->id}}/{{$tm->temuan->id}}" class="btn btn-sm btn-success">
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