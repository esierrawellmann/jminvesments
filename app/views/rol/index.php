
<?php  include("../header.php");
		require_once '../../models/Rol.php';	

		$objRol = new Rol();
		$objRol =  $objRol->getRoles();
                $json_rol = json_encode($objRol);

 ?>



 <script>
 var app = angular.module('rol', ['ngRoute']);
 function controller($scope)
 {
        $scope.initialRoles = <?php echo $json_rol; ?>;
       
    angular.element(document).ready(function () {
     
    });
 }
 </script>
<div ng-app="rol">
	<div ng-controller="controller">
		<div class="row">
		    <div class="col-lg-12">
		        <h1 class="page-header">Productos</h1>
		       	{{getMessage()}}
                        
                        
                        <br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Mantenimiento
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="data in initialRoles" class="odd gradeX"> 
                                            <td>{{data.id_role}}</td>
                                            <td>{{data.nombre}}</td>    
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
                        
		    </div>
		</div>
	</div>
</div>
<?php  include("../footer.php"); ?>
