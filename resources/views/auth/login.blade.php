
<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>WEBCENTROEM</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="{{url('')}}/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="{{url('')}}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{url('')}}/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="{{url('')}}/assets/css/animate.min.css" rel="stylesheet" />
    <link href="{{url('')}}/assets/css/style.css" rel="stylesheet" />
    <!--link href="{{url('')}}/assets/css/style-responsive.min.css" rel="stylesheet" /-->
    <link href="{{url('')}}/assets/css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->
    
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="{{url('')}}/assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
    <style>
        body{
            background: url(<?php echo url('');?>/img/fondo.jpeg) top 0 center no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    </style>
</head>
<body class="pace-top">
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <!-- end #page-loader -->
    
    <div class="login-cover">
        <div class="login-cover-image">
            <!--img src="{{url('')}}/img/img-login.jpg" data-id="login-cover-image" alt="" /-->
        </div>
        <div class="login-cover-bg"></div>
    </div>
    <div id="page-container" class="fade">
        
        <!-- begin row -->
        <div class="row" >
            <!-- begin col-6 -->
            <div class="col-xs-12 col-md-offset-4 col-md-4" style="padding: 0 20px 0 20px !important">
                <div class="login login-v2" data-pageload-addclass="animated fadeIn">
                    <!-- begin brand -->
                    <div class="login-header">
                        <div class="brand" style="text-align:center">
                            <span class="logo"></span>Ingreso al sistema
                            <!--small>Ingreso al sistema <i class="fa fa-sign-in"></i></small-->
                        </div>
                    </div>
                    <!-- end brand -->
                    <div class="login-content">
                        <form action="{{ url('/login') }}" method="POST" class="margin-bottom-0">
                            {{ csrf_field() }}
                            
                            @if(session()->has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message')}}
                            </div>
                            @endif
                            <div class="form-group m-b-20 {{ $errors->has('username') ? ' has-error' : '' }}">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-2x fa-user"></i></span>
                                    <input value="{{old('username')}}" name="username" type="text" class="form-control input-lg" placeholder="Usuario" autofocus/>
                                </div>
                                @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group m-b-20 {{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-2x fa-lock"></i></span>
                                    <input value="" type="password" name="password"class="form-control input-lg" placeholder="Clave" autofocus/>
                                </div>
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!--div class="checkbox m-b-20">
                                <label>
                                    <input type="checkbox" /> Recordarme
                                </label>
                            </div-->
                            
                            <div class="text-right" style="margin-right:85px">
                                <button type="submit" class="btn btn-success">Ingresar</button>
                            </div>
                            <div class="text-left" style="">
                                <a href="{{url('registrarme')}}" >Registrarme</a>
                            </div>
                            
                            
                        </form>
                    </div>
                </div>
                <!-- end login -->
            </div>
        </div>
        
    </div>
    <!-- begin #page-container -->
   
    <!-- end page container -->
    
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="{{url('')}}/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="{{url('')}}/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
    <script src="{{url('')}}/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="{{url('')}}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
        <script src="{{url('')}}/assets/crossbrowserjs/html5shiv.js"></script>
        <script src="{{url('')}}/assets/crossbrowserjs/respond.min.js"></script>
        <script src="{{url('')}}/assets/crossbrowserjs/excanvas.min.js"></script>
    <![endif]-->
    <script src="{{url('')}}/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="{{url('')}}/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
    <!-- ================== END BASE JS ================== -->
    
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="{{url('')}}/assets/js/login-v2.demo.min.js"></script>
    <script src="{{url('')}}/assets/js/apps.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
            LoginV2.init();
        });
    </script>
<script>
  

</script>
</body>


</html>
