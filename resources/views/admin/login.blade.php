<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ __('staticwords.Admin') }} - {{ __('staticwords.Login') }} | {{ config('app.name') }}</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
  <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet" crossorigin="anonymous">
<!--===============================================================================================-->
  <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ url("admin_lt/fonts/iconic/css/material-design-iconic-font.min.css") }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ url("css/vendor/animate.min.css") }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ url("/admin_lt/css/util.css") }}">
	<link rel="stylesheet" type="text/css" href="{{ url("/admin_lt/css/loginpage.css") }}">
  <link rel="icon" href="{{url('images/genral/'.$fevicon)}}" type="image/png" sizes="16x16">
<!--===============================================================================================-->
<style>
  .authenticate-bg {
      background: url('{{ url('images/authentication-bg.svg') }}'), #157ed2;
      background-size: contain;
      background-position: center;
      min-height: 100vh;
    }
</style>
</head>
<body>
	
	<div class="authenticate-bg limiter">
		<div class="container-login100">

      

			<div class="wrap-login100">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
				<form action="{{ route('admin.login') }}" method="post" class="login100-form validate-form">
          @csrf
					<span class="login100-form-title p-b-26">
						{{__("Welcome to")}}
					</span>
					<span class="login100-form-title p-b-50">
						 {{__("Admin Login")}}
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email example is: info@email.com">
						<input class="@error('email') 'is-invalid' @enderror input100" type="text" name="email">
						<span class="focus-input100" data-placeholder="Email"></span>  
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="password">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button type="submit" class="login100-form-btn">
                {{__("staticwords.Login")}}
							</button>
						</div>

            @if(env("DEMO_LOCK") == 1)
              <table class="mt-3 table table-bordered">
                <tbody>
                  <tr>
                    
                    <td>{{ __("Email") }}</td>
                    <td>{{ __("admin@mediacity.co.in") }}</td>
                    
                  </tr>

                  <tr>
                    <td>{{ __("Password") }}</td>
                    <td>{{ __("12345678") }}</td>
                  </tr>

                  <tr>
                    <td align="center" colspan="2">
                      <button type="button" class="copycred btn btn-sm btn-primary">
                          {{__("Copy")}}
                      </button>
                    </td>
                  </tr>
                </tbody>
            </table>
            @endif

					</div>

          <div class="text-center p-t-15">
					
						<a class="txt2" href="{{ route('password.request') }}">
               <i class="fa fa-question-circle"></i> {{__('staticwords.ForgotYourPassword')}}
						</a>
					</div>

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
  <script src="{{url('js/jquery.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{url('js/bootstrap.bundle.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{ url("admin_lt/js/adminlogin.js") }}"></script>
  @if(env("DEMO_LOCK") == 1)
    <script>

      "use Strict";

      $(".copycred").on("click",function(){

        $(this).text("Copied !");

        $("input[name=email]").val('admin@mediacity.co.in');
        $("input[name=password]").val('12345678');


      });
    </script>
  @endif
</body>
</html>