@extends('admin.templates.main')
@section('content')

<!--app-content open-->
<div class="main-content app-content mt-5">
    <div class="side-app">
        <!-- CONTAINER -->
        <div class="main-container container-fluid">                        
            <!-- Row -->
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Statistik Cutis</h3>
                    </div>
                    <div class="card-body">                        
                        <div class="chart-container">
                            <canvas id="myChart" class="h-475"></canvas>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="cutiTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><input type="text" class="form-control" placeholder="Cari Jenis Cuti"></th>
                                    <th><input type="text" class="form-control" placeholder="Cari NIP"></th>
                                    <th><input type="text" class="form-control" placeholder="Cari Tahun"></th>
                                    <th><input type="text" class="form-control" placeholder="Cari Penandatangan"></th>
                                </tr>
                                <tr>
                                    <th>Jenis Cuti</th>
                                    <th>NIP</th>
                                    <th>Tahun</th>
                                    <th>Penandatangan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>                    
        <!-- CONTAINER CLOSED -->
    </div>
</div>
<!--app-content closed-->

@endsection


@push('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#cutiTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/datacuti',
            columns: [
                { data: 'nip', name: 'nip' },
                { data: 'jeniscuti', name: 'jeniscuti' },
                { data: 'tahun', name: 'tahun' },
                { data: 'pejabatnip', name: 'pejabatnip' },
            ]
        });

        // Event listener untuk setiap input pencarian
        $('#cutiTable thead input').on('keyup change', function() {
            let colIndex = $(this).parent().index();
            table.column(colIndex).search(this.value).draw();
        });
    });
</script>
<script>
        // Ambil data dari API Laravel
        fetch('/chart-data')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.days,
                        datasets: [
                            {
                                label: 'Cuti Tahunan',
                                data: data.tahunan,
                                borderColor: 'rgba(32, 125, 28, 0.8)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'Cuti Besar',
                                data: data.besar,
                                borderColor: 'rgba(115, 6, 18, 0.8)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'Cuti Sakit',
                                data: data.sakit,
                                borderColor: 'rgba(219, 192, 2, 0.8)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'Cuti Melahirkan',
                                data: data.melahirkan,
                                borderColor: 'rgba(6, 161, 161, 0.8)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'Cuti Karena Alasan Penting',
                                data: data.penting,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            // {
                            //     label: 'Cuti di Luar Tanggungan Negara',
                            //     data: data.cltn,
                            //     borderColor: 'rgba(0, 255, 80, 0.8)',
                            //     borderWidth: 2,
                            //     fill: false,
                            //     tension: 0.4
                            // },
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    </script>


@endpush