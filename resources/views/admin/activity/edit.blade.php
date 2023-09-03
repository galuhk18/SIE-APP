@extends('template.base_admin')

@section('title')
<title>{{ env('APP_NAME') }} | User Admin</title>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('activity.index') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <h6>Edit Jadwal</h6>
        <hr>
        <form action="{{ route('activity.update', ['id' => $activity->id]) }}" method="post">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name">Nama Kegiatan</label>
                        <input type="text" name="name" class="form-control" value="{{ $activity->name }}">
                        @error('name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_of_activity">Tanggal Kegiatan</label>
                        <input type="date" name="date_of_activity" class="form-control" value="{{ $activity->date_of_activity }}">
                        @error('date_of_activity')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                </div>

                <div class="col-lg-6">

                    <div class="form-group">
                        <label for="address">Tempat</label>
                        <textarea name="address" class="form-control">{{ $activity->address }}</textarea>
                        @error('address')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="information">Keterangan</label>
                        <textarea name="information" class="form-control">{{ $activity->information }}</textarea>
                        @error('information')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    


                </div>
            </div>


            <div class="d-flex justify-content-end">

                <button type="submit" class="btn btn-info btn-lg">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
