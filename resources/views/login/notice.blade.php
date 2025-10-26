@if(session()->has('registered'))
<script>
    Swal.fire({
        title: "Sukses Registrasi",
        text: '{{ session("registered") }}',
        timer: 3500,
        showConfirmButton: true,
        type: "success",        
        icon: 'success'         
    })
</script>
@endif

@if(session()->has('success'))
<script>
    Swal.fire({
        title: "Sukses",
        text: '{{ session("success") }}',
        timer: 1500,
        showConfirmButton: true,
        type: "success",        
        icon: 'success'         
    })
</script>
@endif

@if(session()->has('ubah'))
<script>
    Swal.fire({
        title: "Sukses",
        text: '{{ session("ubah") }}',
        timer: 1500,
        showConfirmButton: true,
        type: "success",        
        icon: 'success'         
    })
</script>
@endif

@if(session()->has('delete'))
<script>
    swal.fire({
        text: '{{ session("delete") }}',
        timer: 1500,
        showConfirmButton: true,
    });
</script>
@endif

@if(session()->has('error'))
<script>   
    Swal.fire({
        title: "Error",
        text: '{{ session("error") }}',
        timer: 1500,
        showConfirmButton: false,
        type: "error",        
        icon: 'error'         
    })
</script>
@endif


<script>
$(document).on('click', '.btn-delete', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    var url = id;

    Swal.fire({
        title: 'Hapus Data',
        text: "Yakin Ingin Menghapus Data ?",        
        showCancelButton: true,
        confirmButtonColor: '#d9534f',        
        confirmButtonText: 'Hapus',
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,                
                type: 'get',
                success: function (data) {
                    Swal.fire(
                        'Dihapus!',
                        'Data Berhasil Dihapus.',                        
                        'success'
                    );
                    location.reload();
                },
                error: function (data) {
                    Swal.fire(
                        'Gagal!',
                        'Data Gagal Dihapus.',
                        'error'
                    );
                }
            });
        }
    })
});
</script>

