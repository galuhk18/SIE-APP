@extends('template.base_admin')

@section('title')
<title>{{ env('APP_NAME') }} | User Admin</title>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('death.index') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <h6>Tambah Data Kematian</h6>
        <hr>
        <form action="{{ route('death.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6">

                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" name="nik" class="form-control">
                        @error('nik')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="family_card">Nomor KK</label>
                        <input type="text" name="family_card" class="form-control">
                        @error('family_card')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                   

                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control">
                        @error('name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea name="address" class="form-control"></textarea>
                        @error('address')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                   

                    


                </div>

                <div class="col-lg-6">
                    
                    <div class="form-group">
                        <label for="date_of_death">Tanggal Kematian</label>
                        <input type="date" name="date_of_death" class="form-control">
                        @error('date_of_death')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="informer">Pelapor</label>
                        <input type="text" name="informer" class="form-control">
                        @error('informer')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="informer_status">Status Pelapor</label>
                        <input type="text" name="informer_status" class="form-control">
                        @error('informer_status')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
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
