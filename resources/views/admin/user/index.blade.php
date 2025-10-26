@extends('admin.templates.main')
@section('content')
<!--app-content open-->
<div class="main-content app-content mt-5">
   <div class="side-app">        
      <div class="main-container container-fluid">                                    
         
         <div class="row">               
                  <div class="card">
                     <div class="card-header"> 

                     </div>
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="card">
                              <button type="button" class="px-8 btn btn-primary" data-bs-toggle="modal" data-bs-target="#adduser" data-bs-whatever="@mdo"><i class="fa fa-user-circle me-2"></i> + Tambah User </button>
                              <div class="modal fade" id="adduser">
                                 <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content modal-content-demo">
                                       <form class="form-horizontal" action="/inputuser" method="POST" enctype="multipart/form-data">
                                       @csrf
                                          <div class="modal-header">
                                                <h6 class="modal-title">Tambah User</h6>
                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                   <span aria-hidden="true">×</span>
                                                </button>
                                          </div>
                                          <div class="modal-body">
                                             <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Nama :</label>
                                                <input type="text" class="form-control" name="nama"></input>
                                                <label for="recipient-name" class="col-form-label mt-2">NIP :</label>
                                                <input type="text" class="form-control" name="username" required>                                                            
                                                <label for="password" class="col-form-label mt-2">Password :</label>
                                                <div class="input-group">
                                                   <input id="password" class="form-control" type="password" name="password" autocomplete="new-password">
                                                   <button class="btn btn-outline-default" type="button" id="togglePassword" aria-label="Tampilkan password" aria-pressed="false">
                                                      <i class="fa fa-eye"></i>
                                                   </button>
                                                </div>
                                                <label for="role" class="col-form-label mt-2">Role : </label>
                                                <select class="form-control" required name="role">
                                                   @foreach($role as $rl)
                                                      <option value="{{$rl->id}}">
                                                         {{$rl->role}}
                                                      </option>
                                                   @endforeach
                                                </select>
                                                <label for="recipient-name" class="col-form-label mt-2">Perangkat Daerah :</label>
                                                <div class="form-group">
                                                   <select style="width: 100%;" class="form-control select2" name="pd[]"multiple required>
                                                      @foreach($pd as $pds)
                                                      <option value="{{$pds->kode_pd}}">
                                                         {{$pds->nama_pd}}
                                                      </option>
                                                      @endforeach
                                                   </select>
                                                </div>
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
                              <div class="card-body">
                                 <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="basic-datatable">
                                       <thead>
                                             <tr>
                                                <td class="text-center w-1">No</td>                                          
                                                <td class="text-center w-30">Nama / NIP</td>
                                                <td class="text-center w-30">Role</td>
                                                <td class="text-center w-20">Perangkat Daerah</td>
                                                <td class="text-center w-18">Opsi</td>                                                                                    
                                             </tr>
                                       </thead>
                                       <tbody>                                       
                                             @foreach($user as $us)
                                                <tr>
                                                   <td class="text-center">{{$loop->iteration}}</td>
                                                   <td>{{$us->nama}} / {{$us->username}}</td>
                                                   <td class="text-center">
                                                      <?php
                                                         $roles = \App\Models\Role::where('id', $us->role)->pluck('role')->first();
                                                      ?>
                                                      {{$roles}}
                                                   </td>
                                                   <td>
                                                      @php
                                                         $kodePds = explode('|', $us->kode_pd);
                                                         $namaPds = \App\Models\Pd::whereIn('kode_pd', $kodePds)->pluck('nama_lain')->toArray();
                                                      @endphp
                                                      @foreach($namaPds as $nama)
                                                         <span class="badge rounded-pill bg-default badge-sm me-1 mb-1 mt-1">{{$nama}}</span>
                                                      @endforeach
                                                   </td>
                                                   <td class="text-center">
                                                      <button type="button" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#edituser_{{$us->id}}" data-bs-whatever="@mdo"><i class="fa fa-pencil"></i></button>                              
                                                      <a href="/hapususer/{{$us->id}}" class="btn btn-sm btn-danger"    onclick="return confirm('Yakin mau hapus user ini?')" title="Hapus User">
                                                         <i class="fa fa-minus-circle"></i>
                                                      </a>   
                                                   </td>
                                                </tr>
                                                <div class="modal fade" id="edituser_{{ $us->id }}">
                                                   <div class="modal-dialog modal-lg" role="document">
                                                      <div class="modal-content modal-content-demo">
                                                         <form class="form-horizontal" action="/updateuser/{{ $us->id }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-header">
                                                               <h6 class="modal-title">Edit User</h6>
                                                               <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                                  <span aria-hidden="true">×</span>
                                                               </button>
                                                            </div>
                                                            <div class="modal-body">
                                                               <div class="mb-3">
                                                                  <label for="nama" class="col-form-label">Nama :</label>
                                                                  <input type="text" class="form-control" name="nama" value="{{ $us->nama }}">

                                                                  <label for="username" class="col-form-label mt-2">NIP :</label>
                                                                  <input type="text" class="form-control" name="username" value="{{ $us->username }}" required>

                                                                  <label for="password" class="col-form-label mt-2">Password (kosongkan jika tidak diubah) :</label>
                                                                  <div class="input-group">
                                                                     <input id="password{{ $us->id }}" class="form-control" type="password" name="password" autocomplete="new-password">
                                                                     <button class="btn btn-outline-default" type="button" onclick="togglePassword({{ $us->id }})">
                                                                        <i class="fa fa-eye"></i>
                                                                     </button>
                                                                  </div>

                                                                  <label for="role" class="col-form-label mt-2">Role : </label>
                                                                  <select class="form-control" required name="role">
                                                                     @foreach($role as $rl)
                                                                        <option value="{{ $rl->id }}" {{ $us->role == $rl->id ? 'selected' : '' }}>
                                                                           {{ $rl->role }}
                                                                        </option>
                                                                     @endforeach
                                                                  </select>

                                                                  <label for="pd" class="col-form-label mt-2">Perangkat Daerah : </label>
                                                                  <div class="form-group">
                                                                     <select style="width: 100%;" class="form-control select2" name="pd[]" multiple required>
                                                                        @php
                                                                           $selectedPd = explode('|', $us->kode_pd);
                                                                        @endphp
                                                                        @foreach($pd as $pds)
                                                                           <option value="{{$pds->kode_pd}}"
                                                                              {{ in_array($pds->kode_pd, $selectedPd) ? 'selected' : '' }}>
                                                                              {{$pds->nama_pd}}
                                                                           </option>
                                                                        @endforeach
                                                                     </select>
                                                                  </div>
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

                                                <script>
                                                function togglePassword(id) {
                                                   let input = document.getElementById('password' + id);
                                                   if (input.type === 'password') {
                                                      input.type = 'text';
                                                   } else {
                                                      input.type = 'password';
                                                   }
                                                }
                                                </script>
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
document.getElementById('togglePassword').addEventListener('click', function () {
  const input = document.getElementById('password');
  const btn = this;
  const isHidden = input.type === 'password';

  input.type = isHidden ? 'text' : 'password';
  btn.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
  btn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
});
</script>

@endpush