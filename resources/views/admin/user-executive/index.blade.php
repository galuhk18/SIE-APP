@extends('template.base_admin')

@section('title')
    <title>{{ env('APP_NAME')  }} | User Executive</title>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">

                <h6>Data Executive</h6>
                <a href="{{ route('user.executive.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> Add New</a>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Phone Number</th>
                            <th class="text-center">Created</th>
                            <th class="text-center">Updated</th>
                            <th class="text-center"><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($executive as $item)
                            
                        <tr>
                            <td class="text-center">{{ $item->name }}</td>
                            <td class="text-center">{{ $item->username }}</td>
                            <td class="text-center">{{ $item->email }}</td>
                            <td class="text-center">{{ $item->address }}</td>
                            <td class="text-center">{{ $item->phone_number }}</td>
                            <td class="text-center">{{ $item->created_at }}</td>
                            <td class="text-center">{{ $item->updated_at }}</td>
                            <td class="text-center">
                                <a href="{{ route('user.executive.edit', ['id' => $item->id]) }}" class="btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                <a href="{{ route('user.executive.pass', ['id' => $item->id]) }}" class="btn-warning btn-sm"><i class="fa fa-lock"></i></a>
                                <a href="{{ route('user.executive.destroy',['id' => $item->id]) }}" class="btn-danger btn-sm delete-confirm"><i class="fa fa-trash"></i></a>
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