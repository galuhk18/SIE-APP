@extends('template.base_admin')

@section('title')
    <title>{{ env('APP_NAME')  }} | Sewa Fasilitas</title>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Laporan Penyewaan Fasilitas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $facility_rental_amount }}</div>
                    </div>
                    <div class="col-auto">

                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    


</div>
<div class="row">
    @foreach ($facility_rental_amount_status as $index => $item)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ $rental_status[$index] }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $item }}</div>
                        </div>
                        <div class="col-auto">

                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@if(session()->has('executive_id'))
    <div class="row mt-2">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="chart-facility-rental"></canvas>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="row mt-2">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
    
                    <h6>Facility Rental</h6>
                    @if (session()->has('admin_id'))
                    <a href="{{ route('facility.rental.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> Tambah</a>
                    @endif
                </div>
                <a href="{{ route('facility.rental.export') }}" class="btn btn-success"> <i
                    class="fa fa-file-excel"></i> Export</a>
                <hr>
                <div class="table-responsive">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-center">Kode Fasilitas</th>
                                <th class="text-center">Nama Fasilitas</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Tanggal Mulai</th>
                                <th class="text-center">Tanggal Selesai</th>
                                <th class="text-center">Penanggung Jawab</th>
                                <th class="text-center">Nomor HP</th>
                                <th class="text-center">status</th>
                                <th class="text-center">Created</th>
                                <th class="text-center">Updated</th>
                                <th class="text-center"><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facility_rental as $item)
                                
                            <tr>
                                <td class="text-center">{{ $item->facility_code }}</td>
                                <td class="text-center">{{ $item->facility_name }}</td>
                                <td class="text-center">{{ $item->amount }}</td>
                                <td class="text-center">{{ $item->start_date }}</td>
                                <td class="text-center">{{ $item->end_date }}</td>
                                <td class="text-center">{{ $item->person_responsible }}</td>
                                <td class="text-center">{{ $item->telp }}</td>
                                <td class="text-center">{{ $rental_status[$item->status] }}</td>
                                <td class="text-center">{{ $item->created_at }}</td>
                                <td class="text-center">{{ $item->updated_at }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
    
                                        <a href="{{ route('facility.rental.edit', ['id' => $item->id]) }}" class="btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('facility.rental.destroy',['id' => $item->id]) }}" class="btn-danger btn-sm delete-confirm"><i class="fa fa-trash"></i></a>
                                    </div>
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
@endsection
@section('script')
<script>
    $(document).ready(function() {
    $('#dataTable').DataTable();
  });
</script>
@if(session()->has('executive_id'))
    <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
    <script>
        var cData1 = JSON.parse(`<?php echo $chart_facility_rental; ?>`);
        var ctx1 = $("#chart-facility-rental");
        var data1 = {
            labels: cData1.label,
            datasets: [{
                label: "Statistik Penyewaan Fasilitas ditahun {{ $year }}",
                data: cData1.data,

                backgroundColor: [
                    '#4e73df',
                    '#6610f2',
                    '#6f42c1',
                    '#e83e8c',
                    '#e74a3b',
                    '#fd7e14',
                    '#f6c23e',
                    '#1cc88a',
                    '#20c9a6',
                    '#36b9cc',
                    '#858796',
                    '#5a5c69',
                    '#091734',
                    '#FA9044',
                    '#e74a3b'
                ],
                borderColor: [
                    '#4e73df',
                    '#6610f2',
                    '#6f42c1',
                    '#e83e8c',
                    '#e74a3b',
                    '#fd7e14',
                    '#f6c23e',
                    '#1cc88a',
                    '#20c9a6',
                    '#36b9cc',
                    '#858796',
                    '#5a5c69',
                    '#091734',
                    '#FA9044',
                    '#e74a3b'
                ],
                borderWidth: [1, 1, 1, 1, 1, 1, 1]
            }]
        };

        var options1 = {
            responsive: true,
            title: {
                display: true,
                position: "top",
                text: "Statistik Penyewaan Fasilitas ditahun {{ $year }}",
                fontSize: 18,
                fontColor: "#111"
            },
            legend: {
                display: true,
                position: "bottom",
                labels: {
                    fontColor: "#333",
                    fontSize: 16
                }
            }
        };

        var chart1 = new Chart(ctx1, {
            type: "bar",
            data: data1,
            options: options1
        });

    </script>
@endif
@endsection