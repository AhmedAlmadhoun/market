@extends('layouts.install', ['no_header' => 1])
@section('title', '#morofisnet')

@section('content')
<div class="container">
    
    <div class="row">
      <h3 class="text-center">{{ config('app.name', 'MorPos') }} Kurulum <small> Adım 1/3</small></h3>

        <div class="col-md-8 col-md-offset-2">
          <hr/>
          @include('install.partials.nav', ['active' => 'install'])

          <div class="box box-primary active">
            <!-- /.box-header -->
            <div class="box-body">
              <h3 class="text-success">
                MorPOS kurulumuna Hoş Geldiniz!
              </h3>
              <p><strong class="text-danger">[ÖNEMLİ]</strong> Yüklemeye başlamadan önce aşağıdaki bilgileri yanınızda bulundurduğunuzdan emin olun:</p>

              <ol>
                <li>
                  <b>Mor POS</b> - Hızlı & Güvenli - Pratik.
                </li>
                <li>
                  <b>Veritabanı Bilgileri:</b>
                  <ul>
                    <li>Kullanıcı Adı</li>
                    <li>Şifre</li>
                    <li>Veritabanı Adı</li>
                    <li>Veritabanı Hostu</li>
                  </ul>
                </li>
                <li>
                  <b>E-Posta Konfigürasyonu</b> - SMTP Detayları (opsiyonel)
                </li>
                <li>
                  <b>MorOfis satın alma kodu:</b>
                  <ul>
                    <li><b>MorOfis Satın Alma Kodu</b>.</b> (<a href="#" target="_blank">Nasıl Öğrenirim?</a>)</li>
                    <li>
                      <b>MorOfis Kullanıcı Adı</b>
                    </li>
                  </ul>
                </li>
              </ol>

              @include('install.partials.e_license')
              
              <a href="{{route('install.details')}}" class="btn btn-primary pull-right">Katılıyorum, Hadi Başlayalım!</a>
            </div>
          <!-- /.box-body -->
          </div>

        </div>

    </div>
</div>
@endsection
