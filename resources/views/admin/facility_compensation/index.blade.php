@extends('template.base_admin')

@section('title')
    <title>{{ env('APP_NAME')  }} | Informasi Ganti Rugi</title>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Laporan Ganti Rugi Fasilitas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $facility_compensation_amount }}</div>
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
    @foreach ($facility_compensation_amount_status as $index => $item)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ $compensation_status[$index] }}
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
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">

                <h6>Facility Compensation</h6>
                @if (session()->has('admin_id'))
                <a href="{{ route('facility.compensation.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> Tambah</a>
                @endif
            </div>
            <div>
                <a href="{{ route('facility.compensation.export') }}" class="btn btn-success"> <i
                    class="fa fa-file-excel"></i> Export</a>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
    
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Nominal</th>
                            <th class="text-center">Penanggung Jawab</th>
                            <th class="text-center">Dokumentasi</th>
                            <th class="text-center">Nomor HP</th>
                            <th class="text-center">status</th>
                            <th class="text-center">Created</th>
                            <th class="text-center">Updated</th>
                            <th class="text-center"><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($facility_compensation as $item)
                            
                        <tr>

                            <td class="text-center">{{ $item->facility_name }}</td>
                            <td class="text-center">{{ $item->amount }}</td>
                            <td class="text-center">{{ $item->amount_compensation }}</td>
                            <td class="text-center">{{ $item->person_responsible }}</td>
                            <td class="text-center">
                                <img src="{{ asset($item->picture) }}" width="100px" alt="picture">
                            </td>
                            <td class="text-center">{{ $item->telp }}</td>
                            <td class="text-center">{{ $compensation_status[$item->status] }}</td>
                            <td class="text-center">{{ $item->created_at }}</td>
                            <td class="text-center">{{ $item->updated_at }}</td>
                            <td class="text-center">
                                <div class="btn-group">

                                    <a href="{{ route('facility.compensation.edit', ['id' => $item->id]) }}" class="btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('facility.compensation.destroy',['id' => $item->id]) }}" class="btn-danger btn-sm delete-confirm"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
@endsection