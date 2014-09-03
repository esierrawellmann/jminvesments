<?php  include("../header.php");?>
 <script>
var app = angular.module('moduloCompras', ['ngRoute']);
angular.module('moduloCompras', ['ui.bootstrap']);
function controller($scope, $modal, $log , $http)
 {
    $scope.alerts = [];
    $scope.compra = [];
    $scope.comprasIniciales =[];
    $scope.users = [];
    angular.element(document).ready(function () {
        $http.post('./../../controllers/compra/compraFunctions.php', '{"action":"query"}').success(function(data){
            $scope.comprasIniciales = data;
         });
    });

    $scope.alerts = [];
      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };
    
          $scope.deleteCompra = function (user){
        var index = $scope.comprasIniciales.compras.indexOf(user);
        console.log(user);
        $http.post('./../../controllers/compra/compraFunctions.php','{"action":"delete","compra":'+JSON.stringify(user)+'}').success(function(data){
           $scope.alerts.push({type: 'success', msg: 'Compra  Exitosamente Eliminada' });
            $scope.comprasIniciales.compras.splice(index,1);
        
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
                compras: function () {
                        return data;
                    },
                users:function(){
                    return $scope.comprasIniciales.usuarios;
                }
          	}
        });
        modalInstanceUpdate.result.then(function (user) {
            user.fecha = user.fecha.toMysqlFormat();
            $http.post('./../../controllers/compra/compraFunctions.php', '{"action":"update","compra":'+JSON.stringify(user)+'}').success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Compra Modificada Exitosamente' });
             });
             
        }, function () {
            data.fecha = data.fecha.toMysqlFormat();
        });
    } 
      
    $scope.openVentas = function (size) {
        var modalInstanceOpen = $modal.open({
          templateUrl: 'myModalContent.html',
          controller: ModalInstanceAddCtrl,
          size: size,
          resolve: {
            action: function(){
                return "Insertar"
            },
            users:function(){
                return $scope.comprasIniciales.usuarios;
            }
            }
        });

        modalInstanceOpen.result.then(function (gasto) {
            gasto.fecha = gasto.fecha.toMysqlFormat();
            console.log(gasto);
            $http.post('./../../controllers/compra/compraFunctions.php', '{"action":"insert","compra":'+JSON.stringify(gasto)+'}').success(function(data){
                  $scope.comprasIniciales.compras.push(data);
                  $scope.alerts.push({type: 'success', msg: 'Compra Agregada Exitosamente' });
                
            });             
        }, function () {});
    };
     
 }
 
   var ModalInstanceUpdateCtrl = function ($scope,$http, $modalInstance,action,compras,users) {
    
    $scope.new = compras;
    $scope.users = users;
    $scope.action = action;
    console.log($scope.new.fecha);

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
            var index = functiontofindIndexByKeyValue(users, "id_usuario", $scope.new.id_usuario);
            $scope.new.nombre = users[index].nombre;
            $modalInstance.close($scope.new);
        }
    };

    $scope.cancel = function () {
        $scope.new.fecha= $scope.new.fecha.toMysqlFormat();
        $modalInstance.dismiss('cancel');
    };
};

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
 <div ng-app="moduloCompras">
     <div ng-controller="controller">
		<div class="row">
             <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
            <div class="col-lg-12">
		        <h1 class="page-header">Modulo de Compras</h1>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Compras
                        <button class="btn btn-default pull-right btn-xs"  ng-click="openVentas()">Nueva Compra</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Usuario</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody ng-show="comprasIniciales.compras.length > 0">
                                    <tr  class="odd gradeX" ng-repeat="compras in comprasIniciales.compras"> 
                                        <td>{{compras.id_compra}}</td>
                                        <td>{{compras.nombre}}</td>
                                        <td>{{compras.fecha}}</td>
                                        <td>
                                        	<div class="btn-group">
											  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
											    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
											  </button>
											  <ul class="dropdown-menu" role="menu">
											    <li><a href="#" ng-click="showUpdateDialog(compras)"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
											    <li><a href="#" ng-click="deleteCompra(compras)"> <i class="fa fa-minus-square"></i>  Eliminar</a></li>
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
             <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Detalle Productos
                        <button class="btn btn-default pull-right btn-xs"  ng-click="">Agregar Productos</button>
                    </div>
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
	                                <tbody>
	                                    <tr  class="odd gradeX"> 
	                                        <td>val</td>
	                                        <td>val</td>
	                                        <td>val</td>
	                                        <td>
	                                        	<div class="btn-group">
												  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
												    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
												  </button>
												  <ul class="dropdown-menu" role="menu">
												    <li><a href="#"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
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
                <script type="text/ng-template" id="myModalContent.html">
                    <div class="modal-header">
                        <h3 class="modal-title"¨>{{action}} Compra</h3>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="spendForm">
                            <div class="form-group">
                                <label for="user-rol-option">Fecha</label>
                                <input type="text" class="form-control" name="dateNameField" datepicker-popup="{{format}}" ng-model="new.fecha" is-open="opened"  datepicker-options="dateOptions"  ng-required="true" readonly close-text="Close"  ng-click="open($event)" style="cursor:pointer;" />
                                <div class="alert-danger" role="alert" ng-show="spendForm.dateNameField.$error.required">Este campo es requerido</div>
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