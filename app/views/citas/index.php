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
    	$http.post('./../../controllers/agenda/agendaFunctions.php', '{"action":"query"}').success(function(data){
            $scope.initialSpends = data;
         });
    });

    $scope.alerts = [];
      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };

    $scope.deleteSpend = function (spend){
        var index = $scope.initialSpends.gastos.indexOf(spend);
         
        $http.post('./../../controllers/agenda/agendaFunctions.php','{"action":"delete","agenda":'+JSON.stringify(spend)+'}').success(function(data){
           $scope.alerts.push({type: 'success', msg: 'Cita Exitosamente Eliminada' });
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
          gasto.hora_inicio = toMysqlFormatTime(gasto.hora_inicio);
          gasto.hora_fin = toMysqlFormatTime(gasto.hora_fin);
          gasto.fecha_inicio = toMysqlFormat1(gasto.fecha_inicio) +" "+gasto.hora_inicio;
          gasto.fecha_fin = toMysqlFormat1(gasto.fecha_fin) + " " +gasto.hora_fin;


        
          console.log(gasto);
            $http.post('./../../controllers/agenda/agendaFunctions.php', '{"action":"insert","agenda":'+JSON.stringify(gasto)+'}').success(function(data){
                  $scope.initialSpends.citas.unshift(data);
                  $scope.alerts.push({type: 'success', msg: 'Cita Agregada Exitosamente' });
                
            });             
        }, function () {});
    };
        

 }
 var ModalInstanceAddCtrl = function ($scope,$http, $modalInstance,action,users) {
    $scope.users = users;
    $scope.action = action;
    $scope.new = {};


    $scope.today = function() {
    $scope.new.fecha_inicio = new Date();
    $scope.new.fecha_fin = new Date();
    $scope.new.hora_inicio = new Date();
    $scope.new.hora_fin = new Date();
  };
  $scope.today();

  $scope.clear = function () {
    $scope.new.fecha_inicio = null;
    $scope.new.fecha_fin = null;
  };

  $scope.open = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.opened1 = true;
  };
    $scope.open2 = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.opened2 = true;
  };

  $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 1
  };

  $scope.initDate = new Date();
  $scope.formats = ['dd MMMM yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
  $scope.format = $scope.formats[0];


      $scope.mytime = new Date();

      $scope.hstep = 1;
      $scope.mstep = 15;

      $scope.options = {
        hstep: [1, 2, 3],
        mstep: [1, 5, 10, 15, 25, 30]
      };

      $scope.ismeridian = true;
      $scope.toggleMode = function() {
        $scope.ismeridian = ! $scope.ismeridian;
      };

      $scope.update = function() {
        var d = new Date();
        d.setHours( 14 );
        d.setMinutes( 0 );
        $scope.mytime = d;
      };

      $scope.changed = function () {
        console.log('Time changed to: ' + $scope.mytime);
      };

      $scope.clear = function() {
        $scope.mytime = null;
      };


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
        $scope.new.fecha_inicio = new Date();
        $scope.new.fecha_fin = new Date();
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


      $scope.mytime = new Date();

      $scope.hstep = 1;
      $scope.mstep = 15;

      $scope.options = {
        hstep: [1, 2, 3],
        mstep: [1, 5, 10, 15, 25, 30]
      };

      $scope.ismeridian = true;
      $scope.toggleMode = function() {
        $scope.ismeridian = ! $scope.ismeridian;
      };

      $scope.update = function() {
        var d = new Date();
        d.setHours( 14 );
        d.setMinutes( 0 );
        $scope.mytime = d;
      };

      $scope.changed = function () {
        console.log('Time changed to: ' + $scope.mytime);
      };

      $scope.clear = function() {
        $scope.mytime = null;
      };

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
function toMysqlFormatTime(date) {
    return twoDigits(date.getHours()) + ":" + twoDigits(1 + date.getMinutes()) + ":" + twoDigits(date.getSeconds());
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
		        <h1 class="page-header">Citas</h1>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Citas Actuales
                        <button class="btn btn-default pull-right btn-xs"  ng-click="openGasto()">Agregar Cita</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                           <form>
                                <div class="form-group">
                                  <div class="input-group">
                                    <div class="input-group-addon">Filtro</div>
                                    <input class="form-control" type="text" placeholder="Filtrar" ng-model="campo">
                                  </div>
                                </div>
                          </form>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Usuario</th>
                                        <th>Comentario</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody ng-show="initialSpends.citas.length > 0">
                                    <tr ng-repeat="spend in initialSpends.citas | filter: campo" class="odd gradeX"> 
                                        <td>{{spend.id_agenda}}</td>
                                        <td>{{spend.nombre}}</td>
                                        <td>{{spend.comentario}}</td>
                                        <td>{{spend.fecha_inicio}}</td>
                                        <td>{{spend.fecha_fin}}</td>                                        
                                        <td>
                                        	<div class="btn-group">
                      										  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
                      										    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
                      										  </button>
                      										  <ul class="dropdown-menu" role="menu">
                      										    <li><a href="#"  ng-disabled="true" ng-click="showUpdateDialog(spend)"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
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
                <h3 class="modal-title"¨>{{action}} Cita</h3>
            </div>
            <div class="modal-body">
                <form role="form" name="spendForm">
                 	<div class="form-group">
                        <label for="user-rol-option">Usuario</label>
                        <select id="user-rol-option" name="selectRol"  ng-required="true" ng-model="new.id_usuario" class="form-control" ng-options="usuario.id_usuario as usuario.nombre for usuario in users"></select>
                        <div class="alert-danger" role="alert" ng-show="spendForm.selectRol.$error.required">Este campo es requerido</div>
                    </div>
                    <div class="form-group">
                        <label for="user-rol-option">Comentario</label>
                        <input type="text" class="form-control" name="comentNameField" ng-model="new.comentario" id="comentarioID" placeholder="Comentario"/>
                    </div>
                    <div class="row">
                    	<div class="col-md-6">
	                    	<div class="form-group">
		                        <label for="user-rol-option">Fecha Inicio</label>
		                        <input type="text" class="form-control" datepicker-popup="{{format}}" ng-model="new.fecha_inicio" is-open="opened1"  datepicker-options="dateOptions"  ng-required="true" readonly close-text="Close"  ng-click="open($event)" style="cursor:pointer;" />
		                    </div>
                    	</div>
                    	<div class="col-md-6">
	                    	<div class="form-group">
		                        <label for="user-rol-option">Hora Inicio</label>
		                        <timepicker ng-model="new.hora_inicio"  hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></timepicker>
		                    </div>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-6">
	                    	<div class="form-group">
		                        <label for="user-rol-option">Fecha Final</label>
		                        <input type="text" class="form-control" datepicker-popup="{{format}}" ng-model="new.fecha_fin" is-open="opened2"  datepicker-options="dateOptions"  ng-required="true" readonly close-text="Close"  ng-click="open2($event)" style="cursor:pointer;" />
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
                            <label for="user-rol-option">Hora Final</label>
                            <timepicker ng-model="new.hora_fin"  hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></timepicker>
                        </div>
                    	</div>
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