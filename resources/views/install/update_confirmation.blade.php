@extends('layouts.install', ['no_header' => 1])
@section('title', 'POS Installation - Update')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <br/><br/>
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
                      action="{{route('install.update')}}">
                    {{ csrf_field() }}

                    <h4> Lisans Detayları <small class="text-danger">MorOfis'ten doğru bilgileri sağladığınızdan emin olun</small></h4>
                    <hr/>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="morofis_purchase_code">MorOfis Satın Alma Kodu:*</label>
                            <input type="text" name="MOROFIS_PURCHASE_CODE" required class="form-control" id="morofis_purchase_code">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="morofis_username">Morofis Kullanıcı Adı:*</label>
                            <input type="text" name="MOROFIS_USERNAME" required class="form-control" id="morofis_username">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                          <label for="morofis_email">E-Posta Adresiniz:</label>
                          <input type="email" name="MOROFIS_EMAIL" class="form-control" id="morofis_email" placeholder="optional">
                          <p class="help-block">Mesaj ve Destek İçin</p>
                        </div>
                    </div>
                    @include('install.partials.e_license')

                    <div class="col-md-12">
                        <button type="submit" id="install_button" class="btn btn-primary pull-right">Katılıyorum, Güncelle</button>
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
        $('button#install_button').attr('disabled', true).text('Güncelleniyor...');
        $('div.install_msg').removeClass('hide');
        $('.back_button').hide();
      });

    })
  </script>
@endsection