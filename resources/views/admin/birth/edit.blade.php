@extends('template.base_admin')

@section('title')
<title>{{ env('APP_NAME') }} | User Admin</title>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('birth.index') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <h6>Edit Birth</h6>
        <hr>
        <form action="{{ route('birth.update', ['id' => $birth->id]) }}" method="post">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-lg-6">

                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" name="nik" class="form-control" value="{{ $birth->nik }}">
                        @error('nik')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="no_akta">No Akta</label>
                        <input type="text" name="no_akta" class="form-control" value="{{ $birth->no_akta }}">
                        @error('no_akta')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    

                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ $birth->name }}">
                        @error('name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender" class="d-block">Jenis Kelamin</label>
                        @foreach($gender as $ge)

                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline{{ $ge }}" name="gender"
                                    class="custom-control-input" value="{{ $ge }}" {{ ($ge == $birth->gender) ? 'checked' : '' }}>
                                <label class="custom-control-label"
                                    for="customRadioInline{{ $ge }}">{{ Str::ucfirst($ge) }}</label>
                            </div>
                        @endforeach
                        @error('gender')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea name="address" class="form-control">{{ $birth->address }}</textarea>
                        @error('address')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" class="form-control" value="{{ $birth->date_of_birth }}">
                        @error('date_of_birth')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    

                </div>

                <div class="col-lg-6">

                    <div class="form-group">
                        
                        @error('date_of_birth')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    
                    <div class="form-group">
                        <label for="father_name">Nama Ayah</label>
                        <input type="text" name="father_name" class="form-control" value="{{ $birth->father_name }}">
                        @error('father_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="mother_name">Nama Ibu</label>
                        <input type="text" name="mother_name" class="form-control" value="{{ $birth->mother_name }}">
                        @error('mother_name')
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
