<?php  include("../header.php");
 ?>
<script>
 var app = angular.module('usuario', ['ngRoute']);
 angular.module('usuario', ['ui.bootstrap']);
 function controller($scope, $modal, $log , $http)
 {
    $scope.usuario = [];
    $scope.initialUsers =[]
    angular.element(document).ready(function () {

    	$http.post('../../controllers/usuario/usuarioFunctions.php', '{"action":"query"}').success(function(data){
            $scope.initialUsers = data;
         });
    });

    $scope.alerts = [
      ];
      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };

    $scope.deleteUser = function (rol){
        // var index = $scope.initialRoles.indexOf(rol);
        //  $scope.initialRoles.splice(rol,1);
         
        //  $http.post('../../controllers/rol/rolFunctions.php','{"action":"delete","rol":'+JSON.stringify(rol)+'}').success(function(data){
        //     $scope.alerts.push({type: 'success', msg: 'Rol  Exitosamente Eliminado' });
        //  });
    }
    $scope.showUpdateDialog = function (data,size){
    	var modalInstanceUpdate = $modal.open({
            templateUrl: 'myModalContent.html',
            controller: ModalInstanceUpdateCtrl,
            size: size,
            resolve: {
                action: function(){
                return "Modificar";
            }, 
                rol: function () {
              		return data;
          		}
          	}
        });
        modalInstanceUpdate.result.then(function (rol) {
            $http.post('../../controllers/rol/rolFunctions.php', '{"action":"update","rol":'+JSON.stringify(rol)+'}').success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Rol Modificado Exitosamente' });
             });
             
        }, function () {
        });
    } 
    $scope.open = function (size) {
        var modalInstanceOpen = $modal.open({
          templateUrl: 'myModalContent.html',
          controller: ModalInstanceAddCtrl,
          size: size,
          resolve: {
            action: function(){
                return "Insertar"
            }, 
          	usuario: function () {
            		return [];
        		},
    		rol:function(){
    			$http.post('../../controllers/rol/rolFunctions.php', '{"action":"query"}').success(function(data){
	                return data;
	             });
    			}
        	}
        });

        modalInstanceOpen.result.then(function (rol) {
           $http.post('../../controllers/rol/rolFunctions.php', '{"action":"insert","rolName":"'+rol.nombre+'"}').success(function(data){
                $scope.initialRoles.push(data[0]);
                $scope.alerts.push({type: 'success', msg: 'Rol Agregado Exitosamente' });
             });             
        }, function () {});
    };
        

 }
 var ModalInstanceAddCtrl = function ($scope, $modalInstance,rol,action) {
    $scope.rol = rol;
    $scope.action = action;
    $scope.ok = function (rol) {
        $modalInstance.close(rol);
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};
var ModalInstanceUpdateCtrl = function ($scope, $modalInstance,rol,action) {
    $scope.rol = rol;
    $scope.action = action;
    $scope.ok = function (rol) {
        $modalInstance.close(rol);
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};
 </script>
<div ng-app="usuario">
	<div ng-controller="controller">
		<div class="row">
              <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
		    <div class="col-lg-12">
		        <h1 class="page-header">Usuarios</h1>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Usuarios actuales
                        <button class="btn btn-default pull-right btn-xs"  ng-click="open()">Agregar Usuario</button>
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
                                <tbody ng-show="initialUsers.length > 0">
                                    <tr ng-repeat="user in initialUsers" class="odd gradeX"> 
                                        <td>{{user.id_usuario}}</td>
                                        <td>{{user.nombre}}</td>
                                        <td>{{user.role_name}}</td>
                                        <td>
                                        	<div class="btn-group">
											  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
											    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
											  </button>
											  <ul class="dropdown-menu" role="menu">
											    <li><a href="#" ng-click="showUpdateDialog(data)"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
											    <li><a href="#" ng-click="deleteRol(data)"> <i class="fa fa-minus-square"></i>  Eliminar</a></li>
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
                <h3 class="modal-title"¨>{{action}} Usuario</h3>
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