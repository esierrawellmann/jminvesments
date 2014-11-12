<?php
    $pt = "";
    $pp = "/backend/app/views";
    session_start();
    if(!isset($_SESSION["user"])){
        if($_SESSION["user"]===NULL){
            header('Location: /index.php?error');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> JM Inversiones</title>

    <!-- Bootstrap Core CSS -->
    <link href="/backend/public/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/backend/public/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="/backend/public/css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/backend/public/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="/backend/public/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/backend/public/css/calendar.css">
    <link rel="stylesheet" href="/backend/public/css/datepicker.css">
    
    <!-- Morris Charts CSS -->
    <link href="/backend/public/css/plugins/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="/backend/public/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- jQuery Version 1.11.0 -->
    <script src="/backend/public/js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/backend/public/js/bootstrap.min.js"></script>
    <script src="/backend/public/js/funcionPagineo.js"></script>
    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="/backend/public/js/plugins/metisMenu/metisMenu.min.js"></script>

    <script src="/backend/public/js/angular.min.js" type="text/javascript"></script>
    <script src="/backend/public/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- Morris Charts JavaScript -->
    <script src="/backend/public/js/angular-route.min.js" type="text/javascript"></script>
    <script src="/backend/public/js/moment.js"></script>
    <script src="/backend/public/js/plugins/morris/raphael.min.js"></script>

    <script src="/backend/public/js/plugins/morris/morris.min.js"></script>
    <script src="/backend/public/js/ui-bootstrap-tpls-0.11.0.min.js" type="text/javascript"></script>
    <!--<script src="./../../backend/public/js/plugins/morris/morris-data.js"></script> -->
    <link href="/backend/public/css/plugins/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Custom Theme JavaScript -->
    <script src="/backend/public/js/sb-admin-2.js"></script>
    <script type="text/javascript" src="/backend/public/js/underscore-min.js"></script>
    <script type="text/javascript" src="/backend/public/js/jstz.min.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/nl-NL.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/fr-FR.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/de-DE.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/el-GR.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/it-IT.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/hu-HU.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/pl-PL.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/pt-BR.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/ro-RO.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/es-MX.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/es-ES.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/ru-RU.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/sv-SE.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/zh-TW.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/cs-CZ.js"></script>
    <script type="text/javascript" src="/backend/public/js/language/ko-KR.js"></script>
    <script type="text/javascript" src="/backend/public/js/calendar.js"></script>

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
                    <div style='float:left'><a class="navbar-brand" style="height:80px" href="/backend/app/views/main.php"><img style="max-height: 50px;" src="/backend/logojm.png"></a></div>
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
                        <li><a href="/backend/index.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                  
                    <ul class="nav" id="side-menu">
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/rol/index.php"><i class="fa fa-database fa-fw"></i> Roles</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/usuario/index.php"><i class="fa fa-child fa-fw"></i> Usuarios</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/calendario/index.php"><i class="fa fa fa-calendar fa-fw"></i> Calendario</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/citas/index.php"><i class="fa fa-pencil-square-o fa-fw"></i> Citas</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/propiedad/index.php"><i class="fa fa-building fa-fw"></i> Ingreso Propiedades</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $pp; ?>/cotizador/index.php"><i class="fa fa-book fa-fw"></i> Cotizador</a>
                        </li>
                     </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
        	
