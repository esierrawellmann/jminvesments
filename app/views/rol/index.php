
<?php  include("../header.php");
	   require_once '../../models/Rol.php';	

		$objRol = new Rol();
		$objRol =  $objRol->getRoles();
                $json_rol = json_encode($objRol);

 ?>



 <script>
 var app = angular.module('rol', ['ngRoute']);
 angular.module('rol', ['ui.bootstrap']);
 function controller($scope, $modal, $log , $http)
 {
    $scope.rol = [];
    $scope.initialRoles =[]
    $scope.action = 0; 

    angular.element(document).ready(function () {
    	$http.post('../../controllers/rol/rolFunctions.php', '{"action":"query"}').success(function(data){
            $scope.initialRoles = data ;
         });
    });
    $scope.showUpdateDialog = function (data,size){
    	var modalInstance = $modal.open({
            templateUrl: 'myModalContent.html',
            controller: ModalInstanceCtrl,
            size: size,
            resolve: {
                rol: function () {
              		return data;
          		},
  				action: function(){
					return 1;
  	  	  		}
          	}
          });
    } 
    $scope.open = function (size) {
        var modalInstance = $modal.open({
          templateUrl: 'myModalContent.html',
          controller: ModalInstanceCtrl,
          size: size,
          resolve: { 
          	rol: function () {
            		return [];
        		},
		        action: function(){
					return 0;
			  	}
        	}
        });

        modalInstance.result.then(function (rol,action) {
            alert(action);
            
            if(action == 0){
            	$http.post('../../controllers/rol/rolFunctions.php', '{"action":"insert","rolName":"'+rol.nombre+'"}').success(function(data){
                    $scope.initialRoles.push(data[0]);
                 });
            }else{
            	$http.post('../../controllers/rol/rolFunctions.php', '{"action":"update","rol":'+JSON.stringify(rol)+'}').success(function(data){
                    console.log(data);
                 });
            }
             
        }, function () {
        });
    };
 }
 var ModalInstanceCtrl = function ($scope, $modalInstance,rol,action) {
    $scope.rol = rol;
    $scope.ok = function (rol) {
        $modalInstance.close(rol,action);
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};
 </script>
<div ng-app="rol">
	<div ng-controller="controller">
		<div class="row">
		    <div class="col-lg-12">
		        <h1 class="page-header">Roles</h1>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Roles actuales
                        <button class="btn btn-default pull-right btn-xs"  ng-click="open()">Agregar Rol</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody ng-show="initialRoles.length > 0">
                                    <tr ng-repeat="data in initialRoles" class="odd gradeX"> 
                                        <td>{{data.id_role}}</td>
                                        <td>{{data.nombre}}</td>
                                        <td>
                                        	<div class="btn-group">
											  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
											    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
											  </button>
											  <ul class="dropdown-menu" role="menu">
											    <li><a href="#" ng-click="showUpdateDialog(data)"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
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
        <script type="text/ng-template" id="myModalContent.html">
            <div class="modal-header">
                <h3 class="modal-title">Agregar  nuevo Rol</h3>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" class="form-control" ng-model="rol.nombre" id="exampleInputEmail1" placeholder="Nombre del Rol"/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" ng-click="ok(rol)">OK</button>
                <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
            </div>
        </script>
	</div>
</div>
<?php  include("../footer.php"); ?>
