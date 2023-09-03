@extends('template.base_home')
@section('title')
<title>{{ env('APP_NAME') }}</title>
@endsection
@section('content')
<div class="jumbotron jumbotron-full">
    <div class="container text-center box-hello">
      <h1 class="display-4">Selamat Datang di</h1>
      <p class="lead">SISTEM INFORMASI EKSEKUTIF LAPORAN DESA KEBASEN</p>
    </div>
  </div>
@endsection
