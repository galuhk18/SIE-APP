@extends('template.base_admin')

@section('title')
<title>{{ env('APP_NAME') }} | Manajemen Gedung</title>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('building.management.index') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <h6>Edit Data Gedung</h6>
        <hr>
        <form action="{{ route('building.management.update',['id' => $building_management->id]) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    

                    <div class="form-group">
                        <label for="building_code">Kode Gedung</label>
                        <input type="text" name="building_code" class="form-control" value="{{ $building_management->building_code }}">
                        @error('building_code')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="building_name">Nama Gedung</label>
                        <input type="text" name="building_name" class="form-control" value="{{ $building_management->building_name }}">
                        @error('building_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    

                   


                </div>

                <div class="col-lg-6">

                    
                    <div class="form-group">
                        <label for="condition">Kondisi</label>
                        <input type="text" name="condition" class="form-control" value="{{ $building_management->condition }}">
                        @error('condition')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="picture">Dokumentasi</label>
                        <br>
                        <img id="img-preview" src="{{ asset($building_management->picture) }}" width="200px" class="img-thumbnail mb-2" alt="">

                        <input type="file" class="form-control" id="form-file" name="picture">
                        @error('picture')
                            <div class="text-danger">{{ $message }}</div>
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
