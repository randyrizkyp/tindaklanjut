<!doctype html>
<html lang="en">
<head>
  	<title>Daftar E-Cuti</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="storage/image/lampura.png" type="image/x-icon" />
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/assets/login/css/style.css">
	<script src="/package/dist/sweetalert2.min.js"></script>
	<link href="/assets/css/icons.css" rel="stylesheet">
	<link rel="stylesheet" href="/package/dist/sweetalert2.min.css">

	<style>
		.bottom-corner { 
            float: right; 
            height: 100%; 
            display: flex; 
            align-items: flex-end; 
            shape-outside: inset(calc(80% - 100px) 0 0); 
      }
	</style>

</head>
<body style="background-image: url(storage/image/pemda.jpg); background-repeat: no-repeat; background-size: cover; background-attachment: fixed; background-position: center;">
<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 col-lg-10">						
				<div class="p-4 p-md-5" style="background-color: rgba(255, 255, 255, 0.8);">
				<div class="d-flex">
					<div class="w-100">						
						<h6 class="mb-4">DAFTAR E-CUTI - <b class="text-warning">PEGAWAI SATUAN PENDIDIKAN</b></h6>
					</div>
					<div class="w-100">
						<p class="social-media d-flex justify-content-end">
							<img src="storage/image/yaibettah.png" style="width: 35px;">							
							<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
							<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-instagram"></span></a>
							<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-youtube"></span></a>							
						</p>
					</div>
				</div>
				<form method="POST" action="/signup" class="signin-form">
					@csrf
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="label">NIP</label>
								<input type="text" class="form-control" id="numberInput" name="nip" placeholder="Masukkan NIP Anda" required oninvalid="this.setCustomValidity('Mohon isi NIP Anda')" oninput="setCustomValidity('')">
							</div>               
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="label">Nama</label>
								<input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Anda" required oninvalid="this.setCustomValidity('Mohon isi Nama Anda')" oninput="setCustomValidity('')">
							</div>              
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="label" for="pangkat">Pangkat</label>
								<select class="form-control select2-show-search form-select" style="width: 100%" id="select_pangkat" name="pangkat" required oninvalid="this.setCustomValidity('Mohon pilih Pangkat Anda')" oninput="setCustomValidity('')">                                                                
								<option value="" selected disabled>-- Pilih Pangkat --</option>	
									@foreach ($pangkat as $pa)										
										<option value="{{ $pa->pangkat }}">{{ $pa->pangkat }} {{ $pa->golongan }}</option>
									@endforeach                     
								</select>
							</div>               
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="label">Jabatan</label>
								<input type="text" class="form-control" name="jabatan" placeholder="Masukkan Jabatan Anda" required oninvalid="this.setCustomValidity('Mohon isi Jabatan Anda')" oninput="setCustomValidity('')">
							</div>              
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="label">Unit Kerja</label>
								<input type="text" class="form-control" value="Dinas Pendidikan" readonly>								
							</div>               
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="label">Unit Organisasi</label>
								<input type="text" class="form-control" name="unor" placeholder="Masukkan Unit Organisasi Anda" required oninvalid="this.setCustomValidity('Mohon isi Unit Organisasi Anda')" oninput="setCustomValidity('')">
							</div>              
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="label">Password</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password Anda" required oninvalid="this.setCustomValidity('Mohon isi Password Anda')" oninput="setCustomValidity('')">
							</div>               
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="label">Konfirmasi Password</label>
								<input type="password" class="form-control" id="confirmPassword" name="konfirmpassword" placeholder="Masukkan Konfirmasi Password Anda" required oninvalid="this.setCustomValidity('Mohon isi Konfirmasi Password Anda')" oninput="setCustomValidity('')">
								<span id="message"></span>
							</div>              
						</div>
					</div>					
					
					<div class="form-group text-center pt-4">
						<button id="btndaftar" type="submit" class="form-control btn btn-primary rounded px-3 mb-4">DAFTAR</button>						
					
						<a class="form-control btn btn-default" style="font-weight:bold;" href="/login"><i class="fa fa-arrow-left"></i> KEMBALI LOGIN</a>
					</div>
										
				</form>
				
			</div>			
					
		</div>		
		
	</div>		  

</section>

<div class="container">
	<div class="row text-center text-white">
		<div class="col-md-12 col-sm-12">
			<div>Digitalisasi Layanan Kepegawaian Terpadu</div>
			© Copyright 2024. <a href="https://bkpsdm.lampungutarakab.go.id">CUTI BKPSDM Kab. Lampung Utara.</a> All rights reserved.
		</div>
	</div>
</div>


@if(session()->has('fail'))
<script>
    Swal.fire({
    position: 'center',
    icon: 'error',
    text:  "{{ session('fail') }}",
    showConfirmButton: true,

    });
</script>
@endif

<script>
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('confirmPassword');
const message = document.getElementById('message');
const btndaftar = document.getElementById('btndaftar');

confirmPasswordInput.addEventListener('input', () => {
    if (passwordInput.value === confirmPasswordInput.value) {
			message.innerHTML = '<span class="text-success" style="font-size:12px;">Konfirmasi Password Benar</span>';
		  btndaftar.disabled = false;
    } else {
			message.innerHTML = '<span class="text-danger" style="font-size:12px;">Konfirmasi Password Salah</span>';
		  btndaftar.disabled = true;
    }
});
</script>


<script src="/assets/login/js/jquery.min.js"></script>
<script src="/assets/login/js/popper.js"></script>
<script src="/assets/login/js/bootstrap.min.js"></script>
<script src="/assets/login/js/main.js"></script>

</body>
</html>

