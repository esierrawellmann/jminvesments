<?php  include("../header.php");
 ?>
 <script>
var app = angular.module('moduloVentas', ['ngRoute']);
angular.module('moduloVentas', ['ui.bootstrap']);
function controller($scope, $modal, $log , $http)
 {
    $scope.showDetail = false;
    $scope.alerts = [];
    $scope.venta = [];
    $scope.ventasIniciales =[];
    $scope.detailVentasInit = [];
    $scope.users = [];
    angular.element(document).ready(function () {
        $http.post('./../../controllers/venta/ventaFunctions.php', '{"action":"query"}').success(function(data){
            $scope.ventasIniciales = data;
         });
    });

    $scope.viewDetail = function (venta){
        $scope.showDetail = true;
        $http.post('./../../controllers/detalleVenta/detalleVentaFunctions.php', '{"action":"query" , "venta":'+JSON.stringify(venta)+'}').success(function(data){
            $scope.detailVentasInit = data;
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
                    return $scope.detailVentasInit.productos;
                }

            }
        });

        modalProductsOpen.result.then(function (detalleVenta) {            
            $http.post('./../../controllers/detalleVenta/detalleVentaFunctions.php', '{"action":"insert","detalleVenta":'+JSON.stringify(detalleVenta)+',"venta":'+JSON.stringify($scope.detailVentasInit.venta)+'}').success(function(data){
                  $scope.detailVentasInit.detalleVentas.push(data);
            });             
        }, function () {});
    }
    $scope.alerts = [];
      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };
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
                return $scope.ventasIniciales.usuarios;
            }
            }
        });

        modalInstanceOpen.result.then(function (venta) {
           venta.fecha = venta.fecha.toMysqlFormat();
            $http.post('./../../controllers/venta/ventaFunctions.php', '{"action":"insert","venta":'+JSON.stringify(venta)+'}').success(function(data){
                  $scope.ventasIniciales.ventas.push(data);
                  console.log(data);
                  $scope.alerts.push({type: 'success', msg: 'Venta Agregada Exitosamente' });
                
            });             
        }, function () {});
    };
     
 }
 var productsModalController = function ($scope,$http, $modalInstance,action,products) {
    $scope.products = products;
    $scope.detail ={};


    $scope.ok = function (valid) {
        if(valid){
            $modalInstance.close($scope.detail);
        } 
    };

    $scope.cancel = function () {
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
 
function twoDigits(d) {
    if(0 <= d && d < 10) return "0" + d.toString();
    if(-10 < d && d < 0) return "-0" + (-1*d).toString();
    return d.toString();
}
Date.prototype.toMysqlFormat = function() {
    return this.getFullYear() + "-" + twoDigits(1 + this.getMonth()) + "-" + twoDigits(this.getDate());
};
</script>
<div ng-app="moduloVentas">
    <div ng-controller="controller">
		<div class="row">
            <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
            <div class="col-lg-12">
		        <h1 class="page-header">Modulo de Ventas</h1>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Ventas
                                <button class="btn btn-default pull-right btn-xs"  ng-click="openVentas()">Nueva Venta</button>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive" style="overflow-x:auto ; height:600px; overflow-y:autp">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Nit</th>
                                                <th>Fecha</th>
                                                <th>Usuario</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody ng-show="ventasIniciales.ventas.length > 0">
                                            <tr  class="odd gradeX" ng-repeat="ventas in ventasIniciales.ventas"> 
                                                <td>{{ventas.nombre}}</td>
                                                <td>{{ventas.nit}}</td>
                                                <td>{{ventas.fecha}}</td>
                                                <td>{{ventas.user_name}}</td>
                                                <td>
                                                	<div class="btn-group">
        											  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
        											    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
        											  </button>
        											  <ul class="dropdown-menu" role="menu">
        											    <li><a href="#"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
        											    <li><a href="#"> <i class="fa fa-minus-square"></i>  Eliminar</a></li>
                                                        <li><a href="#" ng-click="viewDetail(ventas)"> <i class="fa fa-list-alt"></i>  Ver Detalle</a></li>
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
                </div >  
             </div>   
             <div class="col-lg-6">
                <div class="panel panel-default" ng-show="showDetail">
                    <div class="panel-heading">
                        Detalle Productos
                        <button class="btn btn-default pull-right btn-xs"  ng-click="addProductsToDetail(ventas)">Agregar Productos</button>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID Venta</th>
                                            <th>Nombre Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="detalle in detailVentasInit.detalleVentas" class="odd gradeX"> 
                                            <td>{{detalle.id_venta}}</td>
                                            <td>{{detalle.nombre}}</td>
                                            <td>{{detalle.cantidad}}</td>
                                            <td>{{detalle.precio}}</td>
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
            </div> 
        </div>
        <script type="text/ng-template" id="myModalContent.html">
            <div class="modal-header">
                <h3 class="modal-title"¨>{{action}} Venta</h3>
            </div>
            <div class="modal-body">
                <form role="form" name="spendForm">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" class="form-control" name="asuntoNameField" ng-model="new.nombre" id="asuntoID" placeholder="Factura a nombre de..."  ng-required="true"/>
                        <div class="alert-danger" role="alert" ng-show="spendForm.asuntoNameField.$error.required">Este campo es requerido</div>
                    </div>
                    <div class="form-group">
                        <label for="user-rol-option">Nit</label>
                        <input type="text" class="form-control" name="comentNameField" ng-model="new.nit" id="comentarioID" placeholder="Numero de Nit"/>
                    </div>
                    <div class="form-group">
                        <label for="user-rol-option">Fecha</label>
                        <input type="text" class="form-control" datepicker-popup="{{format}}" ng-model="new.fecha" is-open="opened"  datepicker-options="dateOptions"  ng-required="true" readonly close-text="Close"  ng-click="open($event)" style="cursor:pointer;" />
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
        <script type="text/ng-template" id="myProductosModal.html">
            <div class="modal-header">
                <h3 class="modal-title"¨>{{action}} Venta</h3>
            </div>
            <div class="modal-body">
                <form role="form" name="detailSales">
                    <div class="form-group">
                        <label for="exampleInputEmail12">Producto</label>
                        <div class="row" id="exampleInputEmail12">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="asuntoNameField" ng-model="productFilter" id="asuntoID" placeholder="Filtrar Producto..." />
                            </div>
                            <div class="col-md-6">
                                <select id="user-product-option" name="selectProduct"  ng-required="true" ng-model="detail.id_producto" class="form-control"  ng-options="product.id_producto as product.nombre for product in products"></select>
                            </div>
                        </div>
                        <div class="alert-danger" role="alert" ng-show="detailSales.selectProduct.$error.required">Este campo es requerido</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Precio</label>
                        <input type="number" class="form-control" name="precio" ng-model="detail.precio" id="asuntoID" placeholder="Precio"  ng-required="true"/>
                        <div class="alert-danger" role="alert" ng-show="detailSales.precio.$error.required || detailSales.precio.$error.number">Este campo es requerido o incorrecto</div>
                    </div>
                    <div class="form-group">
                        <label for="user-rol-option">Cantidad</label>
                        <input type="number" class="form-control" name="cantidad" ng-model="detail.cantidad" id="comentarioID" placeholder="cantidad" ng-required="true"/>
                        <div class="alert-danger" role="alert" ng-show="detailSales.cantidad.$error.required  || detailSales.cantidad.$error.number">Este campo es requerido o incorrecto</div>
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