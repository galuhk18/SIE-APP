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
        <h6>Edit Laporan Kegiatan</h6>
        <hr>
        <form action="{{ route('activity.report.update',['id' => $activity_report->id]) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    

                    <div class="form-group">
                        <label for="date_of_activity">Tanggal Kegiatan</label>
                        <input type="date" name="date_of_activity" class="form-control" value="{{ $activity_report->date_of_activity }}">
                        @error('date_of_activity')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="organization_name">Nama Organisasi</label>
                        <input type="text" name="organization_name" class="form-control" value="{{ $activity_report->organization_name }}">
                        @error('organization_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="information">Keterangan</label>
                        <input type="text" name="information" class="form-control" value="{{ $activity_report->information }}">
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
                        <input type="text" name="person_responsible" class="form-control" value="{{ $activity_report->person_responsible }}">
                        @error('person_responsible')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="documentation">Dokumentasi</label>
                        <br>
                        <img id="img-preview" width="200px" src="{{ asset($activity_report->documentation) }}" class="img-thumbnail mb-2" alt="">

                        <input type="file" class="form-control" id="form-file" name="documentation">
                        @error('documentation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                   
                    @if (session()->has('executtive_id'))
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="custom-select">
                            
                            @foreach ($activity_report_status as $index => $item)
                                
                            <option value="{{ $index }}" {{ ($activity_report->status == $index) ? "selected" : "" }}>{{ $item }}</option>
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
