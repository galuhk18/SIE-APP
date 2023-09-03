@extends('template.base_admin')

@section('title')
<title>{{ env('APP_NAME') }} |Manajemen Fasilitas</title>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('facility.management.index') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <h6>Tambah Data Fasilitas</h6>
        <hr>
        <form action="{{ route('facility.management.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    

                    <div class="form-group">
                        <label for="facility_code">Kode Fasilitas</label>
                        <input type="text" name="facility_code" class="form-control">
                        @error('facility_code')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="facility_name">Nama Fasilitas</label>
                        <input type="text" name="facility_name" class="form-control">
                        @error('facility_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="stock">Jumlah</label>
                        <input type="number" name="stock" class="form-control">
                        @error('stock')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6">

                    
                    <div class="form-group">
                        <label for="condition">Kondisi</label>
                        <input type="text" name="condition" class="form-control">
                        @error('condition')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="picture">Dokumentasi</label>
                        <br>
                        <img id="img-preview" width="200px" class="img-thumbnail mb-2" alt="">

                        <input type="file" class="form-control" id="form-file" name="picture">
                        @error('picture')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                   
                    


                </div>
            </div>


            <div class="d-flex justify-content-end">

                <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
