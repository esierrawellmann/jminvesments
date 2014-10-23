<?php  include("../header.php");?>
<script>    
 var app = angular.module('mobiliario', ['ngRoute']);
 angular.module('mobiliario', ['ui.bootstrap']);
 function controller($scope, $modal, $log , $http)
 {
    $scope.mobiliario = [];
    $scope.initialMobiliarios =[];
    $scope.usuarios = [];
    angular.element(document).ready(function () {

    	$http.post('./../../controllers/mobiliario/mobiliarioFunctions.php', '{"action":"query"}').success(function(data){
            $scope.initialMobiliarios = data;
            console.log(data);
         });
    });

    $scope.alerts = [];
      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };

    $scope.deleteUser = function (user){
        var index = $scope.initialMobiliarios.mobiliarios.indexOf(user);
        console.log(user);
        $http.post('./../../controllers/mobiliario/mobiliarioFunctions.php','{"action":"delete","mobiliario":'+JSON.stringify(user)+'}').success(function(data){
           $scope.alerts.push({type: 'success', msg: 'Mobiliario  Exitosamente Eliminado' });
            $scope.initialMobiliarios.mobiliarios.splice(index,1);
        
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
                    return $scope.initialMobiliarios.usuarios;
                }
          	}
        });
        modalInstanceUpdate.result.then(function (user) {
            $http.post('./../../controllers/mobiliario/mobiliarioFunctions.php', '{"action":"update","mobiliario":'+JSON.stringify(user)+'}').success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Mobiliario Modificado Exitosamente' });
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
                    return $scope.initialMobiliarios.usuarios;
    		}
        	}
        });

        modalInstanceOpen.result.then(function (user) {
           $http.post('./../../controllers/mobiliario/mobiliarioFunctions.php', '{"action":"insert","mobiliario":'+JSON.stringify(user)+'}').success(function(data){
                 $scope.initialMobiliarios.mobiliarios.push(data);
                 $scope.alerts.push({type: 'success', msg: 'Mobiliario Agregado Exitosamente' });
                
            });             
        }, function () {});
    };
        

 }
 var ModalInstanceAddCtrl = function ($scope,$http, $modalInstance,action,roles) {
     $scope.new = {};
    
    
  $scope.open = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.opened = true;
  };
     
    $scope.usuarios = roles;
    $scope.action = action;
    console.log($scope.new);
    
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
    $scope.usuarios = roles;

    $scope.$watch('new.cantidad',function(val,old){
       $scope.new.cantidad = parseFloat(val); 
    });
    
    $scope.ok = function (valid) {
        if(valid){
            var index = functiontofindIndexByKeyValue(roles, "id_usuario", $scope.new.id_usuario);
            $scope.new.usuario_name = roles[index].nombre;
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

function twoDigits(d) {
    if(0 <= d && d < 10) return "0" + d.toString();
    if(-10 < d && d < 0) return "-0" + (-1*d).toString();
    return d.toString();
}

Date.prototype.toMysqlFormat = function() {
    return this.getFullYear() + "-" + twoDigits(1 + this.getMonth()) + "-" + twoDigits(this.getDate());
};

 </script>
 <div ng-app="mobiliario">
     <div ng-controller="controller">
		<div class="row">
              <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
		    <div class="col-lg-12">
		        <h1 class="page-header">Mobiliario</h1>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Mobiliarios actuales
                        <button class="btn btn-default pull-right btn-xs"  ng-click="open()">Agregar Mobiliario</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Usuario</th>
                                        <th>Nombre Mobiliario</th>
                                        <th>Cantidad</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody ng-show="initialMobiliarios.mobiliarios.length > 0">
                                    <tr ng-repeat="user in initialMobiliarios.mobiliarios" class="odd gradeX"> 
                                        <td>{{user.id_mobiliario}}</td>
                                        <td>{{user.usuario_name}}</td>
                                        <td>{{user.nombre}}</td>
                                        <td>{{user.cantidad}}</td>
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
                <h3 class="modal-title"¨>{{action}} Mobiliario</h3>
            </div>
            <div class="modal-body">
            <form role="form" name="userForm">
            <div class="form-group">
                        <label for="user-rol-option">Seleccionar Usuario</label>
                        <select id="user-rol-option" name="selectRol" required ng-model="new.id_usuario" class="form-control" ng-options="rol.id_usuario as rol.nombre for rol in usuarios"></select>
                        <div class="alert-danger" role="alert" ng-show="userForm.selectRol.$error.required">Este campo es requerido</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" class="form-control" name="userNameField" ng-model="new.nombre" id="exampleInputEmail1" placeholder="Motivo" required="true"/>
                         <div class="alert-danger" role="alert" ng-show="userForm.userNameField.$error.required">Este campo es requerido</div>
                    </div>
              <div class="form-group">
                        <label for="exampleInputEmail1">Cantidad</label>
                        <input type="number" class="form-control" name="userNameField2" ng-model="new.cantidad" id="exampleInputEmail1" placeholder="Monto" required="true"/>
                         <div class="alert-danger" role="alert" ng-show="userForm.userNameField2.$error.required || userForm.userNameField2.$error.number">Este campo es requerido</div>
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


