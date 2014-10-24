<<<<<<< HEAD
=======
<?php
    $pt = "";
    $pp = "/app/views";
    session_start();
    if(!isset($_SESSION["user"])){
        if($_SESSION["user"]===NULL){
            header('Location: /index.php?error');
        }
    }
?>
>>>>>>> origin/master
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

<<<<<<< HEAD
    <title>JM Inversiones</title>
=======
    <title> The Men's Barbershop</title>
>>>>>>> origin/master

    <!-- Bootstrap Core CSS -->
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">

<<<<<<< HEAD
    <!-- Custom CSS -->
    <link href="/public/css/half-slider.css" rel="stylesheet">
	<link href="/public/css/stylish-portfolio.css" rel="stylesheet">
=======
    <!-- MetisMenu CSS -->
    <link href="/public/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="/public/css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/public/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/public/css/calendar.css">
    <link rel="stylesheet" href="/public/css/datepicker.css">
    
    <!-- Morris Charts CSS -->
    <link href="/public/css/plugins/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="/public/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- jQuery Version 1.11.0 -->
    <script src="/public/js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/public/js/bootstrap.min.js"></script>
    <script src="/public/js/funcionPagineo.js"></script>
    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="/public/js/plugins/metisMenu/metisMenu.min.js"></script>

    <script src="/public/js/angular.min.js" type="text/javascript"></script>
    <script src="/public/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- Morris Charts JavaScript -->
    <script src="/public/js/angular-route.min.js" type="text/javascript"></script>
    <script src="/public/js/moment.js"></script>
    <script src="/public/js/plugins/morris/raphael.min.js"></script>

    <script src="/public/js/plugins/morris/morris.min.js"></script>
    <script src="/public/js/ui-bootstrap-tpls-0.11.0.min.js" type="text/javascript"></script>
    <!--<script src="./../../public/js/plugins/morris/morris-data.js"></script> -->
    <link href="/public/css/plugins/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Custom Theme JavaScript -->
    <script src="/public/js/sb-admin-2.js"></script>
    <script type="text/javascript" src="/public/js/underscore-min.js"></script>
    <script type="text/javascript" src="/public/js/jstz.min.js"></script>
    <script type="text/javascript" src="/public/js/language/nl-NL.js"></script>
    <script type="text/javascript" src="/public/js/language/fr-FR.js"></script>
    <script type="text/javascript" src="/public/js/language/de-DE.js"></script>
    <script type="text/javascript" src="/public/js/language/el-GR.js"></script>
    <script type="text/javascript" src="/public/js/language/it-IT.js"></script>
    <script type="text/javascript" src="/public/js/language/hu-HU.js"></script>
    <script type="text/javascript" src="/public/js/language/pl-PL.js"></script>
    <script type="text/javascript" src="/public/js/language/pt-BR.js"></script>
    <script type="text/javascript" src="/public/js/language/ro-RO.js"></script>
    <script type="text/javascript" src="/public/js/language/es-MX.js"></script>
    <script type="text/javascript" src="/public/js/language/es-ES.js"></script>
    <script type="text/javascript" src="/public/js/language/ru-RU.js"></script>
    <script type="text/javascript" src="/public/js/language/sv-SE.js"></script>
    <script type="text/javascript" src="/public/js/language/zh-TW.js"></script>
    <script type="text/javascript" src="/public/js/language/cs-CZ.js"></script>
    <script type="text/javascript" src="/public/js/language/ko-KR.js"></script>
    <script type="text/javascript" src="/public/js/calendar.js"></script>
>>>>>>> origin/master

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<<<<<<< HEAD
=======


>>>>>>> origin/master
</head>

<body>

<<<<<<< HEAD
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background:#0C1A26">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header" style="background:#0C1A26">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
=======
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
>>>>>>> origin/master
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
<<<<<<< HEAD
                <img class="navbar-brand jm-logo" src="/public/img/logojm.png">
                
            </div>  
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav nav-ul-items" style="max-width:820px">
                    <li class="li-main" >
                        <a href="/app/views/main.php">Inicio</a>
                    </li>
                    <li>
                        <a href="#">Acerca de Nosotros</a>
                    </li>
                    <li class="dropdown li-advanced-search">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Busqueda Avanzada<span class="caret"></span></a>
                        <ul class="dropdown-menu"  role="menu">
                            <li><a  href="/app/views/busqueda/index.php">Busqueda Avanzada</a></li>
                            <li><a href="#">Cotizacion</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Contacto</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <!-- Half Page Image Background Carousel Header -->
     <!-- jQuery Version 1.11.0 -->
    <script src="/public/js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/public/js/bootstrap.min.js"></script>
	
    

=======
                <div>
                <div style='float:left'><img src="/mustache1.png"></div>  
                <div style='float:right;alignment-adjust:central'><a class="navbar-brand" href="/app/views/main.php">The Men's Barbershop Admin </a></div>
                </div>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/index.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <br>
                <div class="sidebar-nav navbar-collapse">
                    <?php $contador = count($_SESSION['permisos']);
                    $arreglo = $_SESSION['permisos'];
                    if($contador>0){
                    ?>
                    <ul class="nav" id="side-menu">
                        <?php 
                       for($c=0;$c<$contador;$c++){
                            switch($arreglo[$c]['nombre']){
                            case "Caja":
                                ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/caja/index.php"><i class="fa fa-inbox fa-fw"></i> Caja</a>
                        </li>
                               <?php break; 
                           
                            case "Roles":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/rol/index.php"><i class="fa fa-database fa-fw"></i> Roles</a>
                        </li>
                         <?php break; 
                           
                            case "Permisos":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/permiso/index.php"><i class="fa  fa-check fa-fw"></i> Permisos</a>
                        </li>
                        <?php break; 
                           
                            case "Usuarios":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/usuario/index.php"><i class="fa fa-child fa-fw"></i> Usuarios</a>
                        </li>
                        <?php break; 
                           
                            case "TipoProducto":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/tipoProducto/index.php"><i class="fa fa-cogs fa-fw"></i> Tipo de Producto</a>
                        </li>
                        <?php break; 
                           
                            case "Producto":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/producto/index.php"><i class="fa fa-tasks fa-fw"></i> Producto</a>
                        </li>
                        <?php break; 
                           
                            case "Mobiliario":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/mobiliario/index.php"><i class="fa fa-truck fa-fw"></i> Mobiliario</a>
                        </li>
                        <?php break; 
                           
                            case "CajaChica":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/cajaChica/index.php"><i class="fa fa-archive fa-fw"></i> Caja Chica</a>
                        </li>
                        <?php break; 
                           
                            case "Vale":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/vale/index.php"><i class="fa fa-money fa-fw"></i> Vale</a>
                        </li>
                        <?php break; 
                           
                            case "Calendario":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/calendario/index.php"><i class="fa fa-calendar fa-fw"></i> Calendario</a>
                        </li>
                        <?php break; 
                           
                            case "Agenda":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/citas/index.php"><i class="fa fa-calendar-o fa-fw"></i> Citas</a>
                        </li>
                        <?php break; 
                           
                            case "Gastos":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/gasto/index.php"><i class="fa fa-credit-card fa-fw"></i> Gastos</a>
                        </li>
                        <?php break; 
                           
                            case "Ventas":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/venta/index.php"><i class="fa fa-usd fa-fw"></i> Ventas</a>
                        </li>
                        <?php break; 
                           
                            case "CatalogoVentas":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/ventas/index.php"><i class="fa fa-list-alt fa-fw"></i> Catálogo de Ventas</a>
                        </li>
                        <?php break; 
                           
                            case "Compras":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/compra/index.php"><i class="fa fa-clipboard fa-fw"></i> Compras</a>
                        </li>
                        <?php break; 
                           
                            case "CatalogoCompras":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/compras/index.php"><i class="fa fa-list-alt fa-fw"></i> Catálogo de Compras</a>
                        </li>
                        <?php break; 
                           
                            case "RolePermiso":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/rolePermiso/index.php"><i class="fa fa-th-list fa-fw"></i> Role Permiso</a>
                        </li>
                        <?php break; 
                           
                            case "Perfil":
                           ?>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/perfil/index.php"><i class="fa fa-users fa-fw"></i> Perfiles</a>
                        </li>
                   
                        <?php 
                        break;
                            }
                        } ?>
                     </ul>
                        <?php
                        } 
                        ?>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
        	
>>>>>>> origin/master
