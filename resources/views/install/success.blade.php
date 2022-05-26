@extends('layouts.install', ['no_header' => 1])
@section('title', '#morofisnet - POS Kurulumu')

@section('content')
<div class="container">
    <div class="row">
        <h1 class="page-header text-center">{{ config('app.name', 'MorPos') }}</h1>

        <div class="col-md-8 col-md-offset-2">
          <h3 class="text-success">Great! <br/>MorPos Kurulumu Başarıyla Tamamlandı..</h3>
          <hr>
		  <hr><center><a target="_blank" href="https://instagram.com/morofisnet">MorOfis Ekibi!</a></center>
         

          <p>İşletmeyi Kaydetmek için <a href="{{route('business.getRegister')}}"> BURADAN</a> devam edin.</p>
        </div>
    </div>
</div>
@endsection
