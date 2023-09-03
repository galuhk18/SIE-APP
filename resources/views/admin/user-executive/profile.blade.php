@extends('template.base_admin')

@section('title')
    <title>{{ env('APP_NAME')  }} | User Admin</title>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
           
            <div class="text-center">

                <h4>Profile</h4>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="text-center">
                        @if ($profile->picture)
                            <img src="{{ asset($profile->picture) }}" style="width: 200px; height:200px;" class="img-fluid rounded-circle" alt="">
                        @else
                            
                        <i class="fa fa-user-circle" style="font-size: 200px;"></i>
                        @endif
                    </div>
                    <div class="text-center mt-2">

                        <a href="{{ route('user.executive.edit',['id' => session('executive_id')]) }}" class="btn btn-info"> <i class="fa fa-user-edit"></i> Ubah Profile</a>
                        <a href="{{ route('user.executive.pass',['id' => session('executive_id')]) }}" class="btn btn-warning"> <i class="fa fa-user-lock"></i> Ubah Password</a>
                    </div>
                    <div class="table-responsive mt-5">
                         <table class="table table-hover">
                             <tr>
                                 <th>Nama</th>
                                 <td>:</td>
                                 <td>{{ $profile->name }}</td>
                             </tr>
                             <tr>
                                <th>Email</th>
                                <td>:</td>
                                <td>{{ $profile->email }}</td>
                             </tr>
                            <tr>
                                <th>Username</th>
                                <td>:</td>
                                <td>{{ $profile->username }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>:</td>
                                <td>{{ "Executive" }}</td>
                            </tr>
                         </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
