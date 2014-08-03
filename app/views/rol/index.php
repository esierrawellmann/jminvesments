
<?php  include("../header.php");
		require_once '../../models/Rol.php';	


		$objRol = new Rol();
		$objRol =  $objRol->getRoles();
		var_dump($objRol);

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

		    </div>
		</div>
	</div>
</div>
<?php  include("../footer.php"); ?>
