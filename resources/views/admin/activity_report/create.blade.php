@extends('template.base_admin')

@section('title')
<title>{{ env('APP_NAME') }} | Activity Report</title>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('activity.report.index') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <h6>Tambah</h6>
        <hr>
        <form action="{{ route('activity.report.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    

                    <div class="form-group">
                        <label for="date_of_activity">Tanggal Kegiatan</label>
                        <input type="date" name="date_of_activity" class="form-control">
                        @error('date_of_activity')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="organization_name">Nama Organisasi</label>
                        <input type="text" name="organization_name" class="form-control">
                        @error('organization_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="information">Keterangan</label>
                        <input type="text" name="information" class="form-control">
                        @error('information')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                   


                </div>

                <div class="col-lg-6">

                    
                    <div class="form-group">
                        <label for="person_responsible">Penanggung Jawab</label>
                        <input type="text" name="person_responsible" class="form-control">
                        @error('person_responsible')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="documentation">Dokumentasi</label>
                        <br>
                        <img id="img-preview" width="200px" class="img-thumbnail mb-2" alt="">

                        <input type="file" class="form-control" id="form-file" name="documentation">
                        @error('documentation')
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
