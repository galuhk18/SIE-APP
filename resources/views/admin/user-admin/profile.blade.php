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

                        <i class="fa fa-user-circle" style="font-size: 200px;"></i>
                    </div>
                    <div class="table-responsive mt-2">
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
                                <td>{{ "Admin" }}</td>
                            </tr>
                         </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
