@extends('template.base_admin')

@section('title')
<title>{{ env('APP_NAME') }} | Sewa Gedung</title>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('building.rental.index') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <h6>Edit Data Sewa Gedung</h6>
        <hr>
        <form
            action="{{ route('building.rental.update',['id' => $building_rental->id]) }}"
            method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-lg-6">


                    <div class="form-group">
                        <label for="building_code">Kode Gedung</label>
                        <select name="building_code" class="custom-select2 custom-select" id="building_code" disabled>
                            <option value=""></option>
                            @foreach($building as $item)
                                <option value="{{ $item->building_code }}"
                                    {{ ($item->building_code == $building_rental->building_code) ? "selected" : "" }}>
                                    {{ $item->building_code . " | " . $item->building_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('building_code')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="datetime-local" name="start_date" class="form-control"
                            value="{{ $building_rental->start_date }}">
                        @error('start_date')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="end_date">Tanggal Selesai</label>
                        <input type="datetime-local" name="end_date" class="form-control"
                            value="{{ $building_rental->end_date }}">
                        @error('end_date')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rental_reasons">Nama Kegiatan</label>
                        <textarea name="rental_reasons"
                            class="form-control">{{ $building_rental->rental_reasons }}</textarea>
                        @error('rental_reasons')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>






                </div>

                <div class="col-lg-6">

                    <div class="form-group">
                        <label for="number_of_people">Jumlah Orang</label>
                        <input type="number" name="number_of_people" class="form-control"
                            value="{{ $building_rental->number_of_people }}">
                        @error('number_of_people')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="person_responsible">Penanggung Jawab</label>
                        <input type="text" name="person_responsible" class="form-control"
                            value="{{ $building_rental->person_responsible }}">
                        @error('person_responsible')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telp">Nomor HP</label>
                        <input type="tel" name="telp" class="form-control" value="{{ $building_rental->telp }}">
                        @error('telp')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @if (session()->has('executive_id'))
                        
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="custom-select" id="status">

                            @foreach($rental_status as $index => $retus)
                                
                                <option value="{{ $index }}"
                                    {{ ($index == $building_rental->status) ? "selected" : "" }}>
                                    {{ $retus }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @endif

                </div>
            </div>


            <div class="d-flex justify-content-end">

                <button type="submit" class="btn btn-info btn-lg">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
@endsection
@section('script')
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.custom-select2').select2();
    });

</script>
@endsection
