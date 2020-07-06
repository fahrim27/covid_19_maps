<!DOCTYPE html>
<html lang="en">

    
<!-- Mirrored from themesdesign.in/stexo/layouts/vertical-dark/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 22 Apr 2020 19:34:54 GMT -->
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Delta Siaga Covid-19 Polresta Sidoarjo</title>
        <meta content="Admin Kawal Covid-19 Polresta Sidoarjo" name="description" />
        <meta content="Themesdesign" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    
        <link href="{{ asset ('theme/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset ('theme/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset ('theme/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset ('theme/css/style.css') }}" rel="stylesheet" type="text/css">


    </head>

    <body>

        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="home-btn d-none d-sm-block">
                <h3 style="color: black;">Delta Siaga Covid-19 Polresta Sidoarjo</h3>
            </div>
        <div class="wrapper-page">
                <div class="card card-pages shadow-none">
    
                    <div class="card-body">
                        <div class="text-center m-t-0 m-b-15">
                                <a href="#" class="logo logo-admin"></a>
                        </div>
                        <h5 class="font-18 text-center">Silahkan Login Untuk Melanjutkan.</h5>
    
                        <form method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
    
                            <div class="form-group">
                                <div class="col-12">
                                        <label>Username :</label>
                                    <input id="nrp" type="text" class="form-control @error('nrp') is-invalid @enderror" name="nrp" required>

                                    @error('nrp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="col-12">
                                    <label>Password :</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="col-12">
                                    <div class="checkbox checkbox-primary">
                                            <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1"> Remember me</label>
                                                  </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Log In</button>
                                </div>
                            </div>
    
                        </form>
                    </div>
    
                </div>
            </div>
        <!-- END wrapper -->

        <!-- jQuery  -->
        <script src="{{ asset ('theme/js/jquery.min.js') }}"></script>
        <script src="{{ asset ('theme/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset ('theme/js/metismenu.min.js') }}"></script>
        <script src="{{ asset ('theme/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset ('theme/js/waves.min.js') }}"></script>

        
    </body>


<!-- Mirrored from themesdesign.in/stexo/layouts/vertical-dark/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 22 Apr 2020 19:34:54 GMT -->
</html>