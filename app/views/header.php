<?php
    $pt = "";
    $pp = "/app/views";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> The Men's Barbershop</title>

    <!-- Bootstrap Core CSS -->
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/public/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="/public/css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/public/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/public/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/public/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- jQuery Version 1.11.0 -->
    <script src="/public/js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/public/js/bootstrap.min.js"></script>
    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="/public/js/plugins/metisMenu/metisMenu.min.js"></script>

    <script src="/public/js/angular.min.js" type="text/javascript"></script>
    <!-- Morris Charts JavaScript -->
    <script src="/public/js/angular-route.min.js" type="text/javascript"></script>
    <script src="/public/js/calendar.js"></script>
    <script src="/public/js/plugins/morris/raphael.min.js"></script>
    <script src="/public/js/plugins/morris/morris.min.js"></script>
    <script src="/public/js/ui-bootstrap-tpls-0.11.0.min.js" type="text/javascript"></script>
    <!--<script src="./../../public/js/plugins/morris/morris-data.js"></script> -->
    <link href="/public/css/plugins/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Custom Theme JavaScript -->
    <script src="/public/js/sb-admin-2.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
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
                    <ul class="nav" id="side-menu">
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/caja/index.php"><i class="fa fa-inbox fa-fw"></i> Caja</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/rol/index.php"><i class="fa fa-database fa-fw"></i> Roles</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/permiso/index.php"><i class="fa  fa-check fa-fw"></i> Permisos</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/usuario/index.php"><i class="fa fa-child fa-fw"></i> Usuarios</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/tipoProducto/index.php"><i class="fa fa-cogs fa-fw"></i> Tipo de Producto</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/producto/index.php"><i class="fa fa-tasks fa-fw"></i> Producto</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/vale/index.php"><i class="fa fa-money fa-fw"></i> Vale</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/calendario/index.php"><i class="fa fa-calendar fa-fw"></i> Calendario</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/gasto/index.php"><i class="fa fa-credit-card fa-fw"></i> Gastos</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/venta/index.php"><i class="fa fa-usd fa-fw"></i> Ventas</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/compra/index.php"><i class="fa fa-clipboard fa-fw"></i> Compras</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
        	
