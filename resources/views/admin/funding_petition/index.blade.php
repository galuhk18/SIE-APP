@extends('template.base_admin')

@section('title')
    <title>{{ env('APP_NAME') }} | Permohonan Dana</title>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Laporan Permohonan Dana
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $funding_petition_amount }}</div>
                        </div>
                        <div class="col-auto">

                            <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($funding_petition_amount_status as $index => $item)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    {{ $funding_petition_status[$index] }}
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $item }}</div>
                            </div>
                            <div class="col-auto">

                                <i class="fas fa-money-bill fa-2x text-gray-300"></i>
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

                <h6>Permohonan Dana</h6>
                @if (session()->has('admin_id'))
                    <a href="{{ route('funding.petition.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> Tambah</a>
                @endif
            </div>
            <div>
                <a href="{{ route('funding.petition.export') }}" class="btn btn-success"> <i class="fa fa-file-excel"></i>
                    Export</a>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">Tanggal Pengajuan</th>
                            <th class="text-center">Nama Organisasi</th>
                            <th class="text-center">Jumlah Dana</th>
                            <th class="text-center">Nama Kegiatan</th>
                            <th class="text-center">Penanggung Jawab</th>
                            <th class="text-center">Unggah Proposal</th>
                            <th class="text-center">status</th>
                            <th class="text-center">Created</th>
                            <th class="text-center">Updated</th>
                            <th class="text-center"><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($funding_petition as $item)
                            <tr>
                                <td class="text-center">{{ $item->date_of_activity }}</td>
                                <td class="text-center">{{ $item->organization_name }}</td>
                                <td class="text-center">{{ $item->budget_amount }}</td>
                                <td class="text-center">{{ $item->event_name }}</td>
                                <td class="text-center">{{ $item->person_responsible }}</td>
                                <td class="text-center">
                                    <a href="{{ asset($item->proposal) }}" target="_blank">PDF</a>
                                </td>

                                <td class="text-center">{{ $funding_petition_status[$item->status] }}</td>
                                <td class="text-center">{{ $item->created_at }}</td>
                                <td class="text-center">{{ $item->updated_at }}</td>
                                <td class="text-center">
                                    <a href="{{ route('funding.petition.edit', ['id' => $item->id]) }}"
                                        class="btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('funding.petition.destroy', ['id' => $item->id]) }}"
                                        class="btn-danger btn-sm delete-confirm"><i class="fa fa-trash"></i></a>
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
