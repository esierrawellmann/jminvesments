<?php  include("../header.php");
 ?>
<script>    
 var app = angular.module('gasto', ['ngRoute']);
 angular.module('gasto', ['ui.bootstrap']);
 function controller($scope, $modal, $log , $http)
 {

    $scope.gasto = [];
    $scope.initialSpends =[];
    $scope.users = [];
    angular.element(document).ready(function () {
    	$http.post('../../controllers/gasto/gastoFunctions.php', '{"action":"query"}').success(function(data){
            console.log(data);
            $scope.initialSpends = data;
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
    		users:function(){
				return $scope.initialSpends.usuarios;
    		}
        	}
        });

        modalInstanceOpen.result.then(function (gasto) {
            console.log(gasto);
           // $http.post('../../controllers/usuario/usuarioFunctions.php', '{"action":"insert","user":'+JSON.stringify(user)+'}').success(function(data){
           //       $scope.initialUsers.usuarios.push(data);
           //       $scope.alerts.push({type: 'success', msg: 'Usuario Agregado Exitosamente' });
                
           //  });             
        }, function () {});
    };
        

 }
 var ModalInstanceAddCtrl = function ($scope,$http, $modalInstance,action,users) {
    $scope.users = users;
    $scope.action = action;
    $scope.new = {};


    $scope.today = function() {
    $scope.new.fecha = new Date();
  };
  $scope.today();

  $scope.clear = function () {
    $scope.new.fecha = null;
  };

  $scope.open = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.opened = true;
  };

  $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 1
  };

  $scope.initDate = new Date();
  $scope.formats = ['dd MMMM yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
  $scope.format = $scope.formats[0];


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

    $scope.today = function() {
        $scope.new.fecha = new Date();
      };
  $scope.today();

  $scope.clear = function () {
    $scope.new.fecha = null;
  };
  $scope.open = function($event) {

    $event.preventDefault();
    $event.stopPropagation();

    $scope.opened = true;
  };

  $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 1
  };

  $scope.initDate = new Date();
  $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
  $scope.format = $scope.formats[0];

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
 <div ng-app="gasto">
     <div ng-controller="controller">
		<div class="row">
              <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
		    <div class="col-lg-12">
		        <h1 class="page-header">Gastos</h1>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Gastos actuales
                        <button class="btn btn-default pull-right btn-xs"  ng-click="open()">Agregar Gasto</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Asunto</th>
                                        <th>Comentario</th>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                        <th>Usuario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody ng-show="initialSpends.gastos.length > 0">
                                    <tr ng-repeat="spend in initialSpends.gastos" class="odd gradeX"> 
                                        <td>{{spend.id_gasto}}</td>
                                        <td>{{spend.asunto}}</td>
                                        <td>{{spend.comentario}}</td>
                                        <td>{{spend.fecha}}</td>
                                        <td>{{spend.user_name}}</td>
                                        <td>{{spend.monto}}</td>
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
                <h3 class="modal-title"¨>{{action}} Gasto</h3>
            </div>
            <div class="modal-body">
                <form role="form" name="spendForm">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Asunto</label>
                        <input type="text" class="form-control" name="asuntoNameField" ng-model="new.asunto" id="asuntoID" placeholder="Motivo del Gasto"  ng-required="true"/>
                        <div class="alert-danger" role="alert" ng-show="spendForm.asuntoNameField.$error.required">Este campo es requerido</div>
                    </div>
                    <div class="form-group">
                        <label for="user-rol-option">Comentario</label>
                        <input type="text" class="form-control" name="comentNameField" ng-model="new.comentario" id="comentarioID" placeholder="Comentario"/>
                    </div>
                    <div class="form-group">
                        <label for="user-rol-option">Fecha</label>
                        <input type="text" class="form-control" datepicker-popup="{{format}}" ng-model="new.fecha" is-open="opened"  datepicker-options="dateOptions"  ng-required="true" readonly close-text="Close"  ng-click="open($event)" style="cursor:pointer;" />
                        <div class="alert-danger" role="alert" ng-show="spendForm.dateNameField.$error.required">Este campo es requerido</div>
                    </div>
                    <div class="form-group">
                        <label for="user-rol-option">Monto</label>
                        <input type="number" class="form-control" name="montoNameField" ng-model="new.monto" id="montoID" placeholder="Monto del gasto"  ng-required="true"/>
                        <div class="alert-danger" role="alert" ng-show="spendForm.montoNameField.$error.required ||  spendForm.montoNameField.$error.number">Este campo es requerido o invalido</div>

                    </div>
                    <div class="form-group">
                        <label for="user-rol-option">Usuario</label>
                        <select id="user-rol-option" name="selectRol"  ng-required="true" ng-model="new.id_usuario" class="form-control" ng-options="usuario.id_usuario as usuario.nombre for usuario in users"></select>
                        <div class="alert-danger" role="alert" ng-show="spendForm.selectRol.$error.required">Este campo es requerido</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" ng-click="ok(spendForm.$valid)">OK</button>
                <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
            </div>
        </script>
	</div>
</div>

 <?php  include("../footer.php"); ?>