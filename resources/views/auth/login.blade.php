
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <title>Login </title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
  </head>
  <body>
    <!-- login page start-->
    <div class="p-0 container-fluid">
      <div class="m-0 row">
        <div class="p-0 col-12">    
          <div class="login-card login-dark">
            <div>
              <div><a class="logo" href="index.html"><img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo.png') }}" alt="looginpage"><img class="img-fluid for-dark" src="../assets/images/logo/logo_dark.png" alt="looginpage"></a></div>
              <div class="login-main" > 
             
                      <form class="theme-form" method="POST" action="{{ route('login') }}">
                                @csrf
                  <h4>Sign in to account</h4>
                  <p>Enter your email & password to login</p>
                  <div class="form-group">
                    <label class="col-form-label">Email Address</label>
                    <input class="form-control @error('login') is-invalid @enderror" name="login"
                    type="text" id="login" required="" placeholder="Enter your email">
                @error('login')
                    <span class="text-danger"> {{ $message }} </span>
                @enderror                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Password</label>
                    <div class="form-input position-relative">
                      <input type="password" id="password" name="password"
                      class="form-control @error('password') is-invalid @enderror"
                      placeholder="Enter your password">
                  @error('password')
                      <span class="text-danger"> {{ $message }} </span>
                  @enderror
                      <div class="show-hide"><span class="show"> </span>
                      </div>
                    </div>
                  </div>
                  <div class="mb-0 form-group">
                    <div class="form-check">
                      <input class="checkbox-primary form-check-input" id="checkbox1" type="checkbox">
                      <label class="text-muted form-check-label" for="checkbox1">Remember password</label>
                    </div>
                    <a class="link" href="forgot-password.html">Forgot password?</a>
                    <div class="text-end">
                      <button class="mt-3 btn btn-primary btn-block w-100" type="submit">Sign in</button>
                    </div>
                  </div>
                 
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- latest jquery-->
      <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
      <!-- Bootstrap js-->
      <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
      <!-- feather icon js-->
      <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
      <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
      <!-- scrollbar js-->
      <!-- Sidebar jquery-->
      <script src="{{ asset('assets/js/config.js') }}"></script>
      <!-- Plugins JS start-->
      <!-- Plugins JS Ends-->
      <!-- Theme js-->
      <script src="{{ asset('assets/js/script.js') }}"></script>
      <script src="{{ asset('assets/js/script1.js') }}"></script>
    </div>
  </body>
</html> 