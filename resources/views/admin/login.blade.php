<!DOCTYPE html>
<html lang="en">
<!--LA IMAGEN DE BACKGROUND DEL LOGIN SE CONFIGURA EN niceAdminStyle -> Css -> style.css -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Login | Idecon</title>

    <!-- Bootstrap CSS -->    
    <link href="niceAdminStyle/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="niceAdminStyle/css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="niceAdminStyle/css/elegant-icons-style.css" rel="stylesheet" />
    <link href="niceAdminStyle/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="niceAdminStyle/css/style.css" rel="stylesheet">
    <link href="niceAdminStyle/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-img3-body" >

    <div class="container">
        <img src="../public/niceAdminStyle/img/logoweb.png" style="width: 16%;position: relative !important;left: 72% !important;top: 70px !important;z-index: 1000 !important;color: #FFFFFF !important;font-weight: bold !important;">
        <div class="row">
            <div class="col-md-7">
            </div>
            <div class="col-md-5" >

                <form class="login-form" action="http://192.168.100.238/ideconNuevo/public/" method="post" style="margin-top:30%;">        
                    <div class="login-wrap" style="background-color: white">
                        <p class="pLogin"> Iniciar Sesión</p>
                        <div class="input-group" style="border-bottom: 1px solid #8b9199;padding: 0;">
                          <span class="input-group-addon"><i class="icon_profile"></i></span>
                          <input type="text" name="email" class="form-control" placeholder="Username" autofocus>
                        </div><br>
                        <div class="input-group" style="border-bottom: 1px solid #8b9199;padding: 0;">
                            <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <br>
                        <br>
                        <div style="margin-left: 28%">
                            <button class="btn btn-lg buttonLogin " style="text-align: center ; border-radius: 8px;" type="submit">Iniciar Sesión</button>                            
                        </div>

                   
                    </div>
                </form>
            </div>
        </div>

      <br>
    <div class="text-right" >
            <div class="credits" style="color: white; background-color: #6b6565b8 ; font-size: medium; text-align: center">
            
                    {{$mensaje}}
                
               <!-- <a href="https://bootstrapmade.com/free-business-bootstrap-themes-website-templates/">Business Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>-->
            </div>
        </div>
    
</body>
</html>
    