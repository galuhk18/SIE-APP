@extends('template.base_admin')

@section('title')
<title>{{ env('APP_NAME') }} | Data Penduduk</title>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Laporan Penduduk
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $population_amount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(session()->has('executive_id'))
<div class="row mt-2">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">

                <canvas id="chart-gender"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">

                <canvas id="chart-married"></canvas>
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
    
                    <h6>Population</h6>
                    @if(session()->has('admin_id'))
                        <a href="{{ route('population.create') }}" class="btn btn-primary"> <i
                                class="fa fa-plus"></i> Tambah</a>
                    @endif
                </div>
                <div>
                    <a href="{{ route('population.export') }}" class="btn btn-success"> <i
                            class="fa fa-file-excel"></i> Export</a>
                    @if(session()->has('admin_id'))
    
    
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-success" data-toggle="modal"
                            data-target="#importModal">
                            <i class="fa fa-file-excel"></i> Import
                        </button>
    
                        <!-- Modal -->
                        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h5 class="modal-title text-white" id="exampleModalLabel">Import</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('population.import') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="file">Upload File Form Excel</label>
    
                                                <input type="file" name="file" class="form-control">
                                                <small class="text-danger">*) Format Date of birth : 1997-05-11</small>
                                                @error('file')
                                                    <div class="text-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <a href="{{ route('population.form.export') }}"
                                                class="btn-link text-success mt-5">Download Form</a>
                                        </div>
                                        <div class="modal-footer">
    
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-upload"></i>
                                                Upload</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-center">NIK</th>
                                <th class="text-center">Nomor KK</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jenis Kelamin</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Tanggal Lahir</th>
                                <th class="text-center">Tempat Lahir</th>
                                <th class="text-center">Nomor HP</th>
                                <th class="text-center">Agama</th>
                                <th class="text-center">Kewarganegaraan</th>
                                <th class="text-center">Status Perkawinan</th>
                                <th class="text-center">Pekerjaan</th>
                                <th class="text-center">Nama Ayah</th>
                                <th class="text-center">Nama Ibu</th>
                                <th class="text-center">Created</th>
                                <th class="text-center">Updated</th>
                                <th class="text-center"><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($population as $item)
    
                                <tr>
                                    <td class="text-center">{{ $item->nik }}</td>
                                    <td class="text-center">{{ $item->family_card }}</td>
                                    <td class="text-center">{{ $item->name }}</td>
                                    <td class="text-center">{{ $item->gender }}</td>
                                    <td class="text-center">{{ $item->address }}</td>
                                    <td class="text-center">{{ $item->date_of_birth }}</td>
                                    <td class="text-center">{{ $item->birth_place }}</td>
                                    <td class="text-center">{{ $item->phone_number }}</td>
                                    <td class="text-center">{{ $item->religion }}</td>
                                    <td class="text-center">{{ $item->citizenship }}</td>
                                    <td class="text-center">{{ $item->married }}</td>
                                    <td class="text-center">{{ $item->job }}</td>
                                    <td class="text-center">{{ $item->father_name }}</td>
                                    <td class="text-center">{{ $item->mother_name }}</td>
                                    <td class="text-center">{{ $item->created_at }}</td>
                                    <td class="text-center">{{ $item->updated_at }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
    
                                            <a href="{{ route('population.edit', ['id' => $item->id]) }}"
                                                class="btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('population.destroy',['id' => $item->id]) }}"
                                                class="btn-danger btn-sm delete-confirm"><i class="fa fa-trash"></i></a>
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
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });

</script>
@if(Session::get('error_add'))
    <script>
        $('#importModal').modal('show');

    </script>
@endif

@if(session()->has('executive_id'))
    <script>
        var cData1 = JSON.parse(`<?php echo $chart_gender; ?>`);
        var cData2 = JSON.parse(`<?php echo $chart_married; ?>`);
        var ctx1 = $("#chart-gender");
        var ctx2 = $("#chart-married");
        var data1 = {
            labels: cData1.label,
            datasets: [{
                label: "Statistik Gender",
                data: cData1.data,

                backgroundColor: [

                    '#1D5D9B',
                    '#FF52A2'
                ],
                borderColor: [

                    '#1D5D9B',
                    '#FF52A2'
                ],
                borderWidth: [1, 1, 1, 1, 1, 1, 1]
            }]
        };

        var data2 = {
            labels: cData2.label,
            datasets: [{
                label: "Statistik Gender",
                data: cData2.data,

                backgroundColor: [

                    '#FA9044',
                    '#e74a3b'
                ],
                borderColor: [

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
                text: "Statistik Gender",
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

        var options2 = {
            responsive: true,
            title: {
                display: true,
                position: "top",
                text: "Statistik Pernikahan",
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
            type: "pie",
            data: data1,
            options: options1
        });

        var chart2 = new Chart(ctx2, {
            type: "pie",
            data: data2,
            options: options2
        });

    </script>
@endif

@endsection
