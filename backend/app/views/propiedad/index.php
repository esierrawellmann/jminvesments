<?php  include("../header.php");?>
<script>
var app = angular.module('moduloCompras', ['ngRoute']);
angular.module('moduloCompras', ['ui.bootstrap']);
function controller($scope, $modal, $log , $http)
 {
    $scope.alerts = [];
    $scope.compra = [];
    $scope.comprasIniciales =[];
    $scope.detailComprasInit = [];
    $scope.users = [];

    angular.element(document).ready(function () {
        $http.post('./../../controllers/propiedad/propiedadFunctions.php', '{"action":"query"}').success(function(data){
            console.log(data);
            $scope.comprasIniciales = data;
         });
    });
    
    $scope.viewDetail = function (venta){
        $scope.showDetail = true;
        $('#dataTables-example1').on('click', 'tbody tr', function(event) {
                $(this).addClass('success').siblings().removeClass('success');
            });
        $http.post('./../../controllers/detalleCompra/detalleCompraFunctions.php', '{"action":"query" , "compra":'+JSON.stringify(venta)+'}').success(function(data){
            $scope.detailComprasInit = data;
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
                    return $scope.detailComprasInit.productos;
                }

            }
        });

        modalProductsOpen.result.then(function (detalleCompra) {   
            $http.post('./../../controllers/detalleCompra/detalleCompraFunctions.php', '{"action":"insert","detalleCompra":'+JSON.stringify(detalleCompra)+',"compra":'+JSON.stringify($scope.detailComprasInit.compra)+'}').success(function(data){
                  $scope.detailComprasInit.detalleCompras.push(data);
                  console.log(data);
            });             
        }, function () {});
    }
    
    $scope.alerts = [];
      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };
    
          $scope.deleteCompra = function (user){
         if(confirm("Esta apunto de eliminar una Propiedad \n Esto eliminara todas los detalles de la propiedad asignados a esta \n Desea continuar?")){
                    $scope.showDetail = false;
                    var index = $scope.comprasIniciales.compras.indexOf(user);
                    $http.post('./../../controllers/propiedad/propiedadFunctions.php','{"action":"delete","propiedad":'+JSON.stringify(user)+'}').success(function(data){
                       $scope.alerts.push({type: 'success', msg: 'Propiedad  Exitosamente Eliminada' });
                        $scope.comprasIniciales.compras.splice(index,1);

                  });
            }
        };  
        
            $scope.deleteDetail = function (detalle){
        if(confirm("Esta apunto de eliminar Desea continuar?")){
            $http.post('./../../controllers/detalleCompra/detalleCompraFunctions.php','{"action":"delete","detalleCompra":'+JSON.stringify(detalle)+'}').success(function(data){
                var index = $scope.detailComprasInit.detalleCompras.indexOf(detalle);
                $scope.alerts.push({type: 'success', msg: 'Detalle de Compra Exitosamente Eliminado' });
                $scope.detailComprasInit.detalleCompras.splice(index,1);
          });    
        }
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
            $http.post('./../../controllers/propiedad/propiedadFunctions.php', '{"action":"update","propiedad":'+JSON.stringify(user)+'}').success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Propiedad Modificada Exitosamente' });
             });
             
        }, function () {
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
            console.log(gasto);
            $http.post('./../../controllers/propiedad/propiedadFunctions.php', '{"action":"insert","propiedad":'+JSON.stringify(gasto)+'}').success(function(data){
                  $scope.comprasIniciales.compras.push(data);
                  $scope.alerts.push({type: 'success', msg: 'Propiedad Agregada Exitosamente' });
                
            });             
        }, function () {});
    };
 
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
                    return $scope.detailComprasInit.productos;
                }
            }
        });
        modalInstanceDetailUpdate.result.then(function (detalle) {
            $http.post('./../../controllers/detalleCompra/detalleCompraFunctions.php', '{"action":"update","detalleCompra":'+JSON.stringify(detalle)+',"compra":'+JSON.stringify($scope.detailComprasInit.compras)+'}').success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Detalle de Compra Modificado Exitosamente' });
             });
             
        }, function () {
        });
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
 } 
    
      var ModalInstanceDetailUpdateCtrl = function($scope,$http, $modalInstance,action,detalleVenta,products){
    $scope.products = products;
    console.log(products);
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
            $modalInstance.close($scope.new);
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


    $scope.tipos =["Apartamento","Bodega","Casa","Edificio","Local","Terreno"];
    $scope.negocios =["Venta","Renta"];
    $scope.zonas =["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21"];

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
		        <h1 class="page-header">Ingreso de Propiedades</h1>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Propiedad
                        <button class="btn btn-default pull-right btn-xs"  ng-click="openVentas()">Nueva Propiedad</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive" style="overflow-x:auto ; height:600px; overflow-y:autp">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Ambiente</th>
                                        <th>Negocio</th>
                                        <th>Zona</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody ng-show="comprasIniciales.compras.length > 0">
                                    <tr  class="odd gradeX" ng-repeat="compras in comprasIniciales.compras"> 
                                        <td>{{compras.id_propiedad}}</td>
                                        <td>{{compras.ambiente}}</td>
                                        <td>{{compras.negocio}}</td>
                                        <td>{{compras.zona}}</td>
                                        <td>
                                        	<div class="btn-group">
											  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
											    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
											  </button>
											  <ul class="dropdown-menu" role="menu">
											    <li><a href="#" ng-click="showUpdateDialog(compras)"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
											    <li><a href="#" ng-click="deleteCompra(compras)"> <i class="fa fa-minus-square"></i>  Eliminar</a></li>
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
             <div class="col-lg-6">
                <div class="panel panel-default" ng-show="showDetail">
                    <div class="panel-heading">
                        Detalle Propiedades
                        <button class="btn btn-default pull-right btn-xs"  ng-click="addProductsToDetail(compras)">Agregar Imagenes</button>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Ubicacion</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="detalle in detailComprasInit.detalleCompras" class="odd gradeX"> 
                                            <td>{{detalle.id_compra}}</td>
                                            <td>{{detalle.nombre}}</td>
                                            <td>{{detalle.cantidad}}</td>
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
                <script type="text/ng-template" id="myModalContent.html">
                    <div class="modal-header">
                        <h3 class="modal-title"¨>{{action}} Propiedad</h3>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group">
                                <label for="userStatus">Tipo</label>
                                <select id="user-status-option" name="userNameField3" ng-model="new.tipo" id="exampleInputEmail1" placeholder="Tipo" required="true" class="form-control" ng-options="stat for stat in tipos"></select>
                                <div class="alert-danger" role="alert" ng-show="userForm.userNameField3.$error.required">Este campo es requerido</div>
                            </div>
                        </form>
                        <form role="form">
                            <div class="form-group">
                                <label for="userStatus">Negocio</label>
                                <select id="user-status-option" name="userNameField4" ng-model="new.negocio" id="exampleInputEmail1" placeholder="Negocio" required="true" class="form-control" ng-options="stat for stat in negocios"></select>
                                <div class="alert-danger" role="alert" ng-show="userForm.userNameField4.$error.required">Este campo es requerido</div>
                            </div>
                        </form>
                        <form role="form">
                            <div class="form-group">
                                <label for="userStatus">Zona</label>
                                <select id="user-status-option" name="userNameField5" ng-model="new.zona" id="exampleInputEmail1" placeholder="Zona" required="true" class="form-control" ng-options="stat for stat in zonas"></select>
                                <div class="alert-danger" role="alert" ng-show="userForm.userNameField5.$error.required">Este campo es requerido</div>
                            </div>
                        </form>
                        <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre Proyecto</label>
                                <input type="text" class="form-control" ng-model="rol.nombre_proyecto" id="exampleInputEmail1" placeholder="Nombre del Proyecto"/>          
                            </div>
                        </form>
                        <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre Propietario</label>
                                <input type="text" class="form-control" ng-model="rol.nombre_propietario" id="exampleInputEmail1" placeholder="Nombre del Propietario"/>
                            </div>
                        </form>
                        <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Dormitorios</label>
                                <input type="text" class="form-control" ng-model="rol.dormitorios" id="exampleInputEmail1" placeholder="Numero de Dormitorios"/>
                            </div>
                        </form>
                        <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Precio Renta</label>
                                <input type="text" class="form-control" ng-model="rol.precio_renta" id="exampleInputEmail1" placeholder="Precio de Renta"/>
                            </div>
                        </form>
                        <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Precio Compra</label>
                                <input type="text" class="form-control" ng-model="rol.precio_venta" id="exampleInputEmail1" placeholder="Precio de Venta"/>
                            </div>
                        </form>
                        <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Amueblado</label>
                                <input type="text" class="form-control" ng-model="rol.amueblado" id="exampleInputEmail1" placeholder="Amueblado"/>
                            </div>
                        </form>
                        <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Directa/Compartida</label>
                                <input type="text" class="form-control" ng-model="rol.directa_compartida" id="exampleInputEmail1" placeholder="Directa o Compartida"/>
                            </div>
                        </form>
                        <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Area</label>
                                <input type="text" class="form-control" ng-model="rol.area" id="exampleInputEmail1" placeholder="Area"/>
                            </div>
                        </form>
                       <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Direccion</label>
                                <input type="text" class="form-control" ng-model="rol.direccion" id="exampleInputEmail1" placeholder="Direccion de la Propiedad"/>
                            </div>
                        </form>
                        <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Departamento</label>
                                <input type="text" class="form-control" ng-model="rol.departamento" id="exampleInputEmail1" placeholder="Nombre del Departamento"/>
                            </div>
                        </form>
                        <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Municipio</label>
                                <input type="text" class="form-control" ng-model="rol.municipio" id="exampleInputEmail1" placeholder="Nombre del Municipio"/>
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
                <h3 class="modal-title"¨>{{action}} Detalle Compra</h3>
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
