@extends('layouts.install', ['no_header' => 1])
@section('title', 'POS Installation - Check server')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="text-center">{{ config('app.name', 'MorPos') }} Kurulum <small>Adım 2/3</small></h3>

        <div class="col-md-8 col-md-offset-2">
          <hr/>
          @include('install.partials.nav', ['active' => 'app_details'])

          <div class="box box-primary active">
            <!-- /.box-header -->
            <div class="box-body">

              @if(session('error'))
                <div class="alert alert-danger">
                  {!! session('error') !!}
                </div>
              @endif

              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                  </ul>
                </div>
              @endif

              <form class="form" id="details_form" method="post" 
                      action="{{route('install.postDetails')}}">
                  {{ csrf_field() }}

                  <h4>Uygulama Detayları</h4>
                  <hr/>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="app_name">Uygulama Adı:*</label>
                        <input type="text" class="form-control" name="APP_NAME" id="app_name" placeholder="MorPOS" required>
                    </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="app_title">Uygulama Başlığı:</label>
                        <input type="text" name="APP_TITLE" class="form-control" id="app_title">
                    </div>
                  </div>

                <h4> Lisans Detayları <small class="text-danger">MorOfis'ten doğru bilgileri sağladığınızdan emin olun</small></h4>
                <hr/>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="morofis_purchase_code">MorOfis Satın Alma Kodu:*</label>
                        <input type="password" name="MOROFIS_PURCHASE_CODE" required class="form-control" id="morofis_purchase_code">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="morofis_username">MorOfis Kullanıcı Adınız:*</label>
                        <input type="text" name="MOROFIS_USERNAME" required class="form-control" id="morofis_username">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="morofis_email">E-Posta Adresiniz:</label>
                        <input type="email" name="MOROFIS_EMAIL" class="form-control" id="morofis_email" placeholder="optional">
                        <p class="help-block">Mesaj ve Destek için</p>
                    </div>
                </div>

                  @if($activation_key)
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="morofis_purchase_code">Aktivasyon Lisans Kodu:*</label>
                          <input type="password" name="MAC_LICENCE_CODE" required class="form-control" id="activation_licence_code">
                      </div>
                    </div>
                  @endif
                  
                  <div class="clearfix"></div>
                  
                  <h4> Veritabanı Detayları <small>Doğru bilgileri sağladığınızdan emin olun</small></h4>
                  <hr/>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label for="db_host">Veritabanı Hostu:*</label>
                        <input type="text" class="form-control" id="db_host" name="DB_HOST" required placeholder="localhost / 127.0.0.1">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label for="db_port">Veritabanı Portu:*</label>
                        <input type="text" class="form-control" id="db_port" name="DB_PORT" required value="3306">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label for="db_database">Veritabanı Adı:*</label>
                        <input type="text" class="form-control" id="db_database" name="DB_DATABASE" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="db_username">Veritabanı Kullanıcı Adı:*</label>
                        <input type="text" class="form-control" id="db_username" name="DB_USERNAME" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="db_password">Veritabanı Şifresi:*</label>
                        <input type="password" class="form-control" id="db_password" name="DB_PASSWORD" required>
                    </div>
                  </div>

                  <div class="clearfix"></div>

                  <h4>E-Posta Konfigürasyonu<small> E-Posta Gönderimi için Kullanacaksınız.</small></h4>
                  <hr/>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="MAIL_DRIVER">E-Posta Göndermek için Kullanılacak Sistem:*</label>
                        <select class="form-control" name="MAIL_DRIVER" id="MAIL_DRIVER">
                          <option value="sendmail">PHP Mail</option>
                          <option value="smtp">SMTP</option>
                        </select>
                    </div>
                  </div>
                  <div class="clearfix"></div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="MAIL_FROM_ADDRESS">Gönderici E-Posta:*</label>
                        <input type="email" class="form-control" id="MAIL_FROM_ADDRESS" name="MAIL_FROM_ADDRESS" placeholder="ornek@morofis.net" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="MAIL_FROM_NAME">Varsayılan Gönderici Adı:</label>
                        <input type="text" class="form-control" id="MAIL_FROM_NAME" name="MAIL_FROM_NAME" placeholder="Mor POS(Opsiyonel)">
                    </div>
                  </div>

                  <div class="col-md-4 smtp hide">
                    <div class="form-group">
                        <label for="MAIL_HOST">SMTP Host:*</label>
                        <input type="text" class="form-control smtp_input" id="MAIL_HOST" name="MAIL_HOST" required disabled>
                    </div>
                  </div>

                  <div class="col-md-4  smtp hide">
                    <div class="form-group">
                        <label for="MAIL_PORT">SMTP E-Posta Port:*</label>
                        <input type="text" class="form-control smtp_input" id="MAIL_PORT" name="MAIL_PORT" required disabled>
                    </div>
                  </div>

                  <div class="col-md-4  smtp hide">
                    <div class="form-group">
                        <label for="MAIL_ENCRYPTION">SMTP E-Posta Güvenliği:*</label>
                        <input type="text" class="form-control smtp_input" id="MAIL_ENCRYPTION" name="MAIL_ENCRYPTION" required disabled placeholder="tls or ssl">
                    </div>
                  </div>

                  <div class="col-md-6  smtp hide">
                    <div class="form-group">
                        <label for="MAIL_USERNAME">SMTP Kullanıcı Adı:*</label>
                        <input type="text" class="form-control smtp_input" id="MAIL_USERNAME" name="MAIL_USERNAME" required disabled>
                    </div>
                  </div>

                  <div class="col-md-6  smtp hide">
                    <div class="form-group">
                        <label for="MAIL_PASSWORD">SMTP Şifresi:*</label>
                        <input type="password" class="form-control smtp_input" id="MAIL_PASSWORD" name="MAIL_PASSWORD" required disabled>
                    </div>
                  </div>

                  <hr/>

                  <div class="col-md-12">
                    <a href="{{route('install.index')}}" class="btn btn-default pull-left back_button" tabindex="-1">Geri</a>
                    <button type="submit" id="install_button" class="btn btn-primary pull-right">Kur</button>
                  </div>

                  <div class="col-md-12 text-center text-danger install_msg hide">
                    <strong>Kurulum İşlemlerinde, Lütfen sayfayı yenilemeyin, geri gitmeyin veya tarayıcıyı kapatmayın.</strong>
                  </div>

              </form>
            </div>
          <!-- /.box-body -->
          </div>
        </div>

    </div>
</div>
@endsection

@section('javascript')
  <script type="text/javascript">
    $(document).ready(function(){
      $('select#MAIL_DRIVER').change(function(){
        var driver = $(this).val();

        if(driver == 'smtp'){
          $('div.smtp').removeClass('hide');
          $('input.smtp_input').attr('disabled', false);
        } else {
          $('div.smtp').addClass('hide');
          $('input.smtp_input').attr('disabled', true);
        }
      })

      $('form#details_form').submit(function(){
        $('button#install_button').attr('disabled', true).text('Kuruluyor...');
        $('div.install_msg').removeClass('hide');
        $('.back_button').hide();
      });

    })
  </script>
@endsection