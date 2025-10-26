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
                              <div class="card-body">
                                 <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="basic-datatable">
                                       <thead>
                                             <tr>
                                                <td width="5%">No</td>                                          
                                                <td width="85%" class="text-center">Perangkat Daerah</td>                                             
                                                <td width="10%" class="text-center">Opsi</td>                                                                                    
                                             </tr>
                                       </thead>
                                       <tbody>                                       
                                             @foreach($fpd as $pd)
                                             <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>                                               
                                                <td>{{$pd->nama_pd}}</td>
                                                <td class="text-center">
                                                   <a href="/bpkpicpd/{{$pd->kode_pd}}" class="btn btn-sm btn-success">
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