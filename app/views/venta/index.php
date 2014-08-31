<?php  include("../header.php");
 ?>
 <div ng-app="moduloVentas">
     <div ng-controller="controller">
		<div class="row">
            <div class="col-lg-12">
		        <h1 class="page-header">Modulo de Ventas</h1>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Usuarios actuales
                        <button class="btn btn-default pull-right btn-xs"  ng-click="">Nueva Venta</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr  class="odd gradeX"> 
                                        <td>val</td>
                                        <td>val</td>
                                        <td>val</td>
                                        <td>
                                        	<div class="btn-group">
											  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
											    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
											  </button>
											  <ul class="dropdown-menu" role="menu">
											    <li><a href="#"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
											    <li><a href="#"> <i class="fa fa-minus-square"></i>  Eliminar</a></li>
											  </ul>
											</div>
                                    	</td>    
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>   
            </div>
             <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Usuarios actuales
                        <button class="btn btn-default pull-right btn-xs"  ng-click="">Productos</button>
                    </div>
	                <div class="panel-body">
	                    <div class="table-responsive">
	                    	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
	                                <thead>
	                                    <tr>
	                                        <th>Id</th>
	                                        <th>Nombre</th>
	                                        <th>Rol</th>
	                                        <th>Acciones</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <tr  class="odd gradeX"> 
	                                        <td>val</td>
	                                        <td>val</td>
	                                        <td>val</td>
	                                        <td>
	                                        	<div class="btn-group">
												  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
												    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
												  </button>
												  <ul class="dropdown-menu" role="menu">
												    <li><a href="#"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
												    <li><a href="#"> <i class="fa fa-minus-square"></i>  Eliminar</a></li>
												  </ul>
												</div>
	                                    	</td>    
	                                    </tr>
	                                </tbody>
	                            </table>
	                    </div>
	                </div>
                </div>
            </div>      
        </div>
<?php  include("../footer.php"); ?>