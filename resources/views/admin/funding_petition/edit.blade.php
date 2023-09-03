@extends('template.base_admin')

@section('title')
<title>{{ env('APP_NAME') }} | Funding Petition</title>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('funding.petition.index') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <h6>Edit Permohonan Dana</h6>
        <hr>
        <form action="{{ route('funding.petition.update',['id' => $funding_petition->id]) }}" method="post" enctype="multipart/form-data">
           @method('PUT')
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    

                    <div class="form-group">
                        <label for="date_of_activity">Tanggal Pengajuan</label>
                        <input type="date" name="date_of_activity" class="form-control" value="{{ $funding_petition->date_of_activity }}">
                        @error('date_of_activity')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="organization_name">Nama Organisasi</label>
                        <input type="text" name="organization_name" class="form-control" value="{{ $funding_petition->organization_name }}">
                        @error('organization_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="budget_amount">Jumlah Dana</label>
                        <input type="number" name="budget_amount" class="form-control" value="{{ $funding_petition->budget_amount }}">
                        @error('budget_amount')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="event_name">Nama Kegiatan</label>
                        <input type="text" name="event_name" class="form-control" value="{{ $funding_petition->event_name }}">
                        @error('event_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                </div>

                <div class="col-lg-6">

                    
                    <div class="form-group">
                        <label for="person_responsible">Penanggung Jawab</label>
                        <input type="text" name="person_responsible" class="form-control" value="{{ $funding_petition->person_responsible }}">
                        @error('person_responsible')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proposal">Unggah Proposal</label>
                        <input type="file" name="proposal" class="form-control">
                        <hr>
                        <a href="{{ asset($funding_petition->proposal) }}" target="_blank" class="btn btn-link">File</a>
                        <hr>
                        <small>*) Format .pdf</small>
                        @error('proposal')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @if(session()->has('executive_id'))
                    <div class="form-group">
                        <label for="status">status</label>
                        <select name="status" class="custom-select">
                            
                            @foreach ($funding_petition_status as $index => $item)
                                
                            <option value="{{ $index }}" {{ ($funding_petition->status == $index) ? "selected" : "" }}>{{ $item }}</option>
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
