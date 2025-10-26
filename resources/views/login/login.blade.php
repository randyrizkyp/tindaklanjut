<!doctype html>
<html lang="en">
<head>
  	<title>Login E-Cuti</title>
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
<body style="
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
">
<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 col-lg-10">
				<div class="wrap d-md-flex" style="background-color: rgba(255, 255, 255, 0.8);">					
					<div class="img d-none d-sm-block js-tilt" data-tilt style="background-image: url(assets/login/images/lampura.png); background-size: 200px;">					
				</div>				
				<div class="login-wrap p-4 p-md-5">
				<div class="d-flex">
					<div class="w-100">						
						<h5 class="mb-4">LOGIN</h5>
					</div>
					
				</div>
				<form method="POST" action="/signin" class="signin-form">
					@csrf
					<div class="form-group mb-3">
						<label class="label" for="name">Username</label>
						<input type="text" class="form-control" name="username" placeholder="Masukkan User Anda" required>
					</div>
					<div class="form-group mb-3">
						<label class="label" for="password">Password</label>						
						<div class="input-group">
							<input class="form-control" type="password" id="pass" name="password" placeholder="Masukkan Password Anda" required>
							<a href="javascript:void(0)" id="eyebtn" class="input-group-text bg-white" onclick="showpass()" title="Lihat Password">
								 <i class="zmdi zmdi-eye-off"></i>
							</a>
					  	</div>
					</div>

					<!-- <div class="form-group d-md-flex">						
						<div class="w-50">
							<a href="#" class="label text-dark">Lupa Password</a>
						</div>
					</div> -->
					<div class="form-group text-center">
						<button type="submit" class="form-control btn btn-primary rounded px-3 mb-2">LOGIN</button>
						
					</div>
				</form>
				
			</div>			
					
		</div>		
		
	</div>		  

</section>

<div class="container">
	<div class="row text-center text-white">
		<div class="col-md-12 col-sm-12">
			<div>Sistem Informasi Tindak Lanjut Hasil Pemeriksaan</div>
			© Copyright 2025. <a href="https://inspektorat.lampungutarakab.go.id">Inspektorat Kab. Lampung Utara.</a> All rights reserved.
		</div>
	</div>
</div>


@include('login.notice')

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
    function showpass()
    {
        var x = document.getElementById('pass').type;
        if (x == 'password')
        {
        document.getElementById('pass').type = 'text';
        document.getElementById('eyebtn').innerHTML = '<i class="zmdi zmdi-eye"></i>';
        }
        else
        {
            document.getElementById('pass').type = 'password';
            document.getElementById('eyebtn').innerHTML = '<i class="zmdi zmdi-eye-off"></i>';
        }
    }
</script>

<script src="/assets/login/js/jquery.min.js"></script>
<script src="/assets/login/js/popper.js"></script>
<script src="/assets/login/js/bootstrap.min.js"></script>
<script src="/assets/login/js/main.js"></script>
<script src="/assets/login/tilt/tilt.jquery.min.js"></script>
<script >
$('.js-tilt').tilt({
	scale: 1.1
})
</script>

</body>
</html>

