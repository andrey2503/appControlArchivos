<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema | Panel Control</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ URL::asset('bootstrap/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('bootstrap/css/dataTables.bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('fonts/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('fonts/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/skins/_all-skins.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/iCheck/flat/blue.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/morris/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/datepicker/datepicker3.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="{{ URL::asset('/') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Na</b>Me</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
        
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle glyphicon-align-justify" data-toggle="offcanvas" role="button">

            <span class="sr-only glyphicon">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
             
              <!-- User Account: style can be found in dropdown.less -->


              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" >
                   <div class="div-content-font-control">
                        <div class="div-control div-control-plus">
                          <span class="glyphicon glyphicon-text-size"> </span><span class="glyphicon glyphicon-plus"></span>
                        </div>
                    </div>
                </a>
              </li>

              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" >
                   <div class="div-content-font-control">
                       
                        <div class="div-control div-control-minus">
                          <span class="glyphicon glyphicon-text-size"> </span><span class="glyphicon glyphicon-minus"></span>
                        </div>
                    </div>
                </a>
              </li>


              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                   <li class="user-header" style="height: 75px;">
                    <p>
                     {{ Auth::user()->name }}
                      <small>Administrador</small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{ url('admin/formActualizarContrasena')}}" class="btn btn-default btn-flat">Cambiar contraseña</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{ url('admin/formActualizarDatos')}}" class="btn btn-default btn-flat">Cambiar datos</a>
                    </div>
                  </li>
                  
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          
          
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            
           
            <li>
              <a href="{{ URL::asset('/') }}">
              <i class="fa fa-dashboard"></i> <span>Escritorio</span> <i class="fa fa-angle-left pull-right"></i>
                 <small class="label pull-right bg-blue">
                   <span class="glyphicon glyphicon-home"></span>
                 </small>
              </a>
            </li>
            
             <li>
              <a href="{{ URL::asset('admin/nuevoUsuario') }}">
                <i class="fa fa-plus-circle"></i> <span>Nuevo usuario</span>
                 <small class="label pull-right bg-green">
                   <span class="glyphicon glyphicon-plus"></span>
                 </small>
              </a>
            </li>


            <li>
              <a href="{{ URL::asset('/out') }}">
                <i class="fa fa-times-circle"></i> <span>cerrar sesión</span>
                 <small class="label pull-right bg-red">
                    <span class="glyphicon glyphicon-off"></span>
                 </small>
              </a>
            </li>
          
          
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
         
        </section>

        <!-- Main content -->
        <section class="content" style="padding-left: 40px;">
        @yield('content')
       
  
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
    
     
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="{{ URL::asset('plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script src="{{ URL::asset('js/jquery-1.12.4.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ URL::asset('plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ URL::asset('bootstrap/js/bootstrap.min.js') }}"></script>

    

    <!-- Morris.js charts -->
    <script src="{{ URL::asset('plugins/raphael-min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ URL::asset('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- jvectormap -->
    <script src="{{ URL::asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ URL::asset('plugins/knob/jquery.knob.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ URL::asset('plugins/moment.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ URL::asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ URL::asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ URL::asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('plugins/fastclick/fastclick.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('dist/js/app.min.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

    <script src="{{ URL::asset('bootstrap/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('bootstrap/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/mainJS.js') }}"></script>
    <script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>
  </body>
</html>
