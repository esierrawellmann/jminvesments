
<?php  include("../header.php");
		require_once '../../models/Rol.php';	


		$objRol = new Rol();
		$objRol =  $objRol->getRoles();
                //var_dump($objRol);

 ?>



 <script>
 var app = angular.module('rol', ['ngRoute']);
 function controller($scope)
 {
	$scope.getRoles = function(){
	  	$http({method: 'GET', url: '../../models/Rol.php'}).
	    success(function(data, status, headers, config) {
	      // this callback will be called asynchronously
	      // when the response is available
	    }).
	    error(function(data, status, headers, config) {
	      // called asynchronously if an error occurs
	      // or server returns response with an error status.
	    });
	}
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
                                        <tr class="odd gradeX"> 
                                            <td>1</td>
                                            <td>Administrador</td>    
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
