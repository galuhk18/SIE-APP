@extends('template.base_admin')

@section('title')
<title>{{ env('APP_NAME') }} | User Admin</title>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('facility.index') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <h6>Add New Facility</h6>
        <hr>
        <form action="{{ route('facility.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control">
                        @error('name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control">
                        @error('amount')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="information">Information</label>
                        <textarea name="information" class="form-control"></textarea>
                        @error('information')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="condition">Condition</label>
                        <input type="text" name="condition" class="form-control">
                        @error('condition')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                </div>
            </div>


            <div class="d-flex justify-content-end">

                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
