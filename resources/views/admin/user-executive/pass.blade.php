@extends('template.base_admin')

@section('title')
<title>{{ env('APP_NAME') }} | User Executive</title>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('user.executive.index') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <h6>Edit Password Executive</h6>
        <hr>
        <form action="{{ route('user.executive.pass',['id' => $executive->id]) }}" method="post">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control">
                        @error('password')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="password_confirm">Password Confirm</label>
                        <input type="password" name="password_confirm" class="form-control">
                        @error('password_confirm')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                
                <button type="submit" class="btn btn-warning btn-lg">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
