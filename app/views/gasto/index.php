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
    	$http.post('./../../controllers/gasto/gastoFunctions.php', '{"action":"query"}').success(function(data){
            $scope.initialSpends = data;
         });
    });

    $scope.alerts = [];
      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };

    $scope.deleteSpend = function (spend){
        var index = $scope.initialSpends.gastos.indexOf(spend);
         
        $http.post('./../../controllers/gasto/gastoFunctions.php','{"action":"delete","gasto":'+JSON.stringify(spend)+'}').success(function(data){
           $scope.alerts.push({type: 'success', msg: 'Gasto  Exitosamente Eliminado' });
            $scope.initialSpends.gastos.splice(index,1);
        
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
                gasto: function () {
                        
                        return data;
                    },
                users:function(){
                    return $scope.initialSpends.usuarios;
                }
          	}
        });
        modalInstanceUpdate.result.then(function (gasto) {

           gasto.fecha = gasto.fecha.toMysqlFormat();
            $http.post('./../../controllers/gasto/gastoFunctions.php', '{"action":"update","gasto":'+JSON.stringify(gasto)+'}').success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Rol Modificado Exitosamente' });
             });
             
        }, function () {
            data.fecha = toMysqlFormat1(data.fecha);
        });
    } 
    $scope.openGasto = function (size) {
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
           gasto.fecha = gasto.fecha.toMysqlFormat();
            $http.post('./../../controllers/gasto/gastoFunctions.php', '{"action":"insert","gasto":'+JSON.stringify(gasto)+'}').success(function(data){
                  $scope.initialSpends.gastos.push(data);
                  $scope.alerts.push({type: 'success', msg: 'Gasto Agregado Exitosamente' });
                
            });             
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
var ModalInstanceUpdateCtrl = function ($scope, $modalInstance,gasto,users,action) {
    $scope.action = action;
    $scope.new = gasto;
    $scope.users = users;
    $scope.$watch('new.monto',function(val,old){
       $scope.new.monto = parseFloat(val); 
    });

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
            var index = functiontofindIndexByKeyValue(users, "id_usuario", $scope.new.id_usuario);
            $scope.new.user_name = users[index].nombre;
            $modalInstance.close($scope.new);
        }
    };

    $scope.cancel = function () {
        $scope.new.fecha = toMysqlFormat1($scope.new.fecha);
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
function toMysqlFormat1(date) {
    return date.getFullYear() + "-" + twoDigits(1 + date.getMonth()) + "-" + twoDigits(date.getDate());
}
Date.prototype.toMysqlFormat = function() {
    return this.getFullYear() + "-" + twoDigits(1 + this.getMonth()) + "-" + twoDigits(this.getDate());
};
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
                        <button class="btn btn-default pull-right btn-xs"  ng-click="openGasto()">Agregar Gasto</button>
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
                                        <td>{{spend.monto}}</td>
                                        <td>{{spend.user_name}}</td>
                                        
                                        <td>
                                        	<div class="btn-group">
										  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
										    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
										  </button>
										  <ul class="dropdown-menu" role="menu">
										    <li><a href="#" ng-click="showUpdateDialog(spend)"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
										    <li><a href="#" ng-click="deleteSpend(spend)"> <i class="fa fa-minus-square"></i>  Eliminar</a></li>
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