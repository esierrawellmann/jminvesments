<?php  include("../header.php");?>
<script>
var app = angular.module('moduloRoles', ['ngRoute']);
angular.module('moduloRoles', ['ui.bootstrap']);
function controller($scope, $modal, $log , $http)
 {
    $scope.alerts = [];
    $scope.compra = [];
    $scope.rolesIniciales =[];
    $scope.detailRoleInit = [];
    $scope.users = [];
    angular.element(document).ready(function () {
        $http.post('./../../controllers/rol/rolFunctions.php', '{"action":"query"}').success(function(data){
            $scope.rolesIniciales = data;
         });
    });
    
    $scope.viewDetail = function (venta){
        $scope.showDetail = true;
        $('#dataTables-example1').on('click', 'tbody tr', function(event) {
                $(this).addClass('success').siblings().removeClass('success');
            });
        $http.post('./../../controllers/rolePermiso/rolePermisoFunctions.php', '{"action":"query" , "role":'+JSON.stringify(venta)+'}').success(function(data){
            $scope.detailRoleInit = data;

         });
    };
    
    $scope.addProductsToDetail = function(size)
    {
        var modalProductsOpen = $modal.open({
            templateUrl:'myProductosModal.html',
            controller: productsModalController,
            size:size,
            resolve:{
                action:function(){
                    return "Insertar"
                },
                products:function(){
                    return $scope.detailRoleInit.permisos;
                }

            }
        });

        modalProductsOpen.result.then(function (detalleCompra) {   
            console.log(detalleCompra);
            $scope.alerts = [];
            $http.post('./../../controllers/rolePermiso/rolePermisoFunctions.php', '{"action":"insert","rolePermiso":'+JSON.stringify(detalleCompra)+',"role":'+JSON.stringify($scope.detailRoleInit.role)+'}').success(function(data){
                    $scope.detailRoleInit.rolePermisos.push(data);
                    $scope.alerts.push({type: 'success', msg: 'Role-Permiso Agregado' });
            });             
        }, function () {});
    }
    
    $scope.alerts = [];
      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };
    
        
            $scope.deleteDetail = function (detalle){
        if(confirm("Esta apunto de eliminar Desea continuar?")){
            $http.post('./../../controllers/rolePermiso/rolePermisoFunctions.php','{"action":"delete","rolePermiso":'+JSON.stringify(detalle)+'}').success(function(data){
                var index = $scope.detailRoleInit.rolePermisos.indexOf(detalle);
                $scope.alerts.push({type: 'success', msg: 'Role-Permiso Exitosamente Eliminado' });
                $scope.detailRoleInit.rolePermisos.splice(index,1);
          });    
        }
    }
    
     $scope.showDetailUpdateDialog = function (data,size){
        var modalInstanceDetailUpdate = $modal.open({
            templateUrl: 'myProductosModal.html',
            controller: ModalInstanceDetailUpdateCtrl,
            size: size,
            resolve: {
                action: function(){
                return "Modificar"
                }, 
                detalleVenta: function () {
                        return data;
                    },
                products:function(){
                    return $scope.detailRoleInit.permisos;
                }
            }
        });
        modalInstanceDetailUpdate.result.then(function (detalle) {
            $http.post('./../../controllers/rolePermiso/rolePermisoFunctions.php', '{"action":"update","rolePermiso":'+JSON.stringify(detalle)+'}').success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Role-Permiso Modificado Exitosamente' });
             });
             
        }, function () {
        });
    };
    
 }
 
   var productsModalController = function ($scope,$http, $modalInstance,action,products) {
    $scope.permisos = products;
    $scope.detail ={};


    $scope.ok = function (valid) {
        if(valid){
            $modalInstance.close($scope.detail);
        } 
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
 } 
 
    
      var ModalInstanceDetailUpdateCtrl = function($scope,$http, $modalInstance,action,detalleVenta,products){
    $scope.permisos = products;
    $scope.action = action;
    $scope.detail = detalleVenta;

    $scope.ok = function (valid) {
        if(valid){
            $modalInstance.close($scope.detail);
        } 
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
 }
 

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
 <div ng-app="moduloRoles">
     <div ng-controller="controller">
		<div class="row">
             <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
            <div class="col-lg-12">
		        <h1 class="page-header">Modulo de Roles-Permiso</h1>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Roles
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive" style="overflow-x:auto ; height:600px; overflow-y:auto">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody ng-show="rolesIniciales.length > 0">
                                    <tr  class="odd gradeX" ng-repeat="compras in rolesIniciales"> 
                                        <td ng-click="viewDetail(compras)">{{compras.id_role}}</td>
                                        <td ng-click="viewDetail(compras)">{{compras.nombre}}</td>
                                        <td>
                                        	<div class="btn-group">
                                                          <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
                                                            <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
                                                          </button>
                                                          <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#" ng-click="viewDetail(compras)"> <i class="fa fa-list-alt"></i>  Ver Detalle</a></li>
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
                <div class="panel panel-default" ng-show="showDetail">
                    <div class="panel-heading">
                        Detalle Role - Permisos
                        <button class="btn btn-default pull-right btn-xs"  ng-click="addProductsToDetail(compras)">Agregar Role-Permiso</button>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID Role</th>
                                            <th>Nombre Permiso</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="detalle in detailRoleInit.rolePermisos" class="odd gradeX"> 
                                            <td>{{detalle.id_role}}</td>
                                            <td>{{detalle.nombre_permiso}}</td>
                                            <td>
                                            	<div class="btn-group">
        										  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
        										    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
        										  </button>
        										  <ul class="dropdown-menu" role="menu">
        										    <li><a href="#" ng-click="showDetailUpdateDialog(detalle)"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
        										    <li><a href="#" ng-click="deleteDetail(detalle)"> <i class="fa fa-minus-square"></i>  Eliminar</a></li>
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
                 <script type="text/ng-template" id="myProductosModal.html">
            <div class="modal-header">
                <h3 class="modal-title"¨>{{action}} Role Permiso</h3>
            </div>
            <div class="modal-body">
                <form role="form" name="detailSales">
                    <div class="form-group">
                        <label for="exampleInputEmail12">Permiso</label>
                        <div class="row" id="exampleInputEmail12">
                            <div class="col-md-12">
                                <select id="user-product-option" name="selectProduct"  ng-required="true" ng-model="detail.id_permiso" class="form-control"  ng-options="product.id_permiso as product.nombre for product in permisos"></select>
                            </div>
                        </div>
                        <div class="alert-danger" role="alert" ng-show="detailSales.selectProduct.$error.required">Este campo es requerido</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" ng-click="ok(detailSales.$valid)">OK</button>
                <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
            </div>
        </script>
            </div>      
        </div>
<?php  include("../footer.php"); ?>
