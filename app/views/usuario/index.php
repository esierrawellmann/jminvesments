<?php  include("../header.php");
 ?>
<script>    
 var app = angular.module('usuario', ['ngRoute']);
 angular.module('usuario', ['ui.bootstrap']);
 function controller($scope, $modal, $log , $http)
 {
    $scope.usuario = [];
    $scope.initialUsers =[];
    $scope.roles = [];
    angular.element(document).ready(function () {

    	$http.post('../../controllers/usuario/usuarioFunctions.php', '{"action":"query"}').success(function(data){
            $scope.initialUsers = data;
         });
    });

    $scope.alerts = [];
      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };

    $scope.deleteUser = function (user){
        console.log(user);
        var index = $scope.initialUsers.usuarios.indexOf(user);
         
        $http.post('../../controllers/usuario/usuarioFunctions.php','{"action":"delete","usuario":'+JSON.stringify(user)+'}').success(function(data){
           $scope.alerts.push({type: 'success', msg: 'Rol  Exitosamente Eliminado' });
            $scope.initialUsers.usuarios.splice(index,1);
        
      });
    }
    $scope.showUpdateDialog = function (data,size){
    	var modalInstanceUpdate = $modal.open({
            templateUrl: 'myModalContent.html',
            controller: ModalInstanceUpdateCtrl,
            size: size,
            resolve: {
                action: function(){
                return "Modificar"
                }, 
                user: function () {
                        return data;
                    },
                roles:function(){
                    return $scope.initialUsers.roles;
                }
          	}
        });
        modalInstanceUpdate.result.then(function (user) {
            $http.post('../../controllers/usuario/usuarioFunctions.php', '{"action":"update","usuario":'+JSON.stringify(user)+'}').success(function(data){
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
    		roles:function(){
				return $scope.initialUsers.roles;
    		}
        	}
        });

        modalInstanceOpen.result.then(function (user) {
           $http.post('../../controllers/usuario/usuarioFunctions.php', '{"action":"insert","user":'+JSON.stringify(user)+'}').success(function(data){
                 $scope.initialUsers.usuarios.push(data);
                 $scope.alerts.push({type: 'success', msg: 'Usuario Agregado Exitosamente' });
                
            });             
        }, function () {});
    };
        

 }
 var ModalInstanceAddCtrl = function ($scope,$http, $modalInstance,action,roles) {
    $scope.roles = roles;
    $scope.action = action;
    $scope.new = {};
    $scope.ok = function (valid) {
        if(valid){
            $modalInstance.close($scope.new);
        } 
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};
var ModalInstanceUpdateCtrl = function ($scope, $modalInstance,user,roles,action) {
    $scope.action = action;
    $scope.new = user;
    $scope.roles = roles;
    $scope.ok = function (valid) {
        if(valid){
            var index = functiontofindIndexByKeyValue(roles, "id_role", $scope.new.id_role);
            $scope.new.role_name = roles[index].nombre;
            $modalInstance.close($scope.new);
        }
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};
function functiontofindIndexByKeyValue(arraytosearch, key, valuetosearch) {
  for (var i = 0; i < arraytosearch.length; i++) {
    if (arraytosearch[i][key] == valuetosearch) {
      return i;
    }
  }
  return null;
}

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
                                <tbody ng-show="initialUsers.usuarios.length > 0">
                                    <tr ng-repeat="user in initialUsers.usuarios" class="odd gradeX"> 
                                        <td>{{user.id_usuario}}</td>
                                        <td>{{user.nombre}}</td>
                                        <td>{{user.role_name}}</td>
                                        <td>
                                        	<div class="btn-group">
											  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
											    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
											  </button>
											  <ul class="dropdown-menu" role="menu">
											    <li><a href="#" ng-click="showUpdateDialog(user)"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
											    <li><a href="#" ng-click="deleteUser(user)"> <i class="fa fa-minus-square"></i>  Eliminar</a></li>
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
                <form role="form" name="userForm">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" class="form-control" name="userNameField" ng-model="new.nombre" id="exampleInputEmail1" placeholder="Nombre del Usuario" required="true"/>
                         <div class="alert-danger" role="alert" ng-show="userForm.userNameField.$error.required">Este campo es requerido</div>
                    </div>
                    <div class="form-group">
                        <label for="user-rol-option">Seleccionar Rol</label>
                        <select id="user-rol-option" name="selectRol" required ng-model="new.id_role" class="form-control" ng-options="rol.id_role as rol.nombre for rol in roles"></select>
                        <div class="alert-danger" role="alert" ng-show="userForm.selectRol.$error.required">Este campo es requerido</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" ng-click="ok(userForm.$valid)">OK</button>
                <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
            </div>
        </script>
	</div>
</div>

 <?php  include("../footer.php"); ?>