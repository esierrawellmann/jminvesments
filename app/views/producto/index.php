<?php  include("../header.php");
 ?>
<script>    
 var app = angular.module('producto', ['ngRoute']);
 angular.module('producto', ['ui.bootstrap']);
 function controller($scope, $modal, $log , $http)
 {
    $scope.producto = [];
    $scope.initialProductos =[];
    $scope.tipo_productos = [];
    angular.element(document).ready(function () {

    	$http.post('../../controllers/producto/productoFunctions.php', '{"action":"query"}').success(function(data){
            $scope.initialProductos = data;
         });
    });

    $scope.alerts = [];
      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };

    $scope.deleteUser = function (user){
        var index = $scope.initialProductos.productos.indexOf(user);
        console.log(user);
        $http.post('../../controllers/producto/productoFunctions.php','{"action":"delete","producto":'+JSON.stringify(user)+'}').success(function(data){
           $scope.alerts.push({type: 'success', msg: 'Producto  Exitosamente Eliminado' });
            $scope.initialProductos.productos.splice(index,1);
        
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
                    console.log(data);
                        return data;
                    },
                roles:function(){
                    return $scope.initialProductos.tipo_productos;
                }
          	}
        });
        modalInstanceUpdate.result.then(function (user) {
            console.log(user);
            $http.post('../../controllers/producto/productoFunctions.php', '{"action":"update","producto":'+JSON.stringify(user)+'}').success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Producto Modificado Exitosamente' });
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
				return $scope.initialProductos.tipo_productos;
    		}
        	}
        });

        modalInstanceOpen.result.then(function (user) {
            console.log(user);
           $http.post('../../controllers/producto/productoFunctions.php', '{"action":"insert","producto":'+JSON.stringify(user)+'}').success(function(data){
                 $scope.initialProductos.productos.push(data);
                 $scope.alerts.push({type: 'success', msg: 'Producto Agregado Exitosamente' });
                
            });             
        }, function () {});
    };
        

 }
 var ModalInstanceAddCtrl = function ($scope,$http, $modalInstance,action,roles) {
    $scope.tipo_productos = roles;
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
    $scope.tipo_productos = roles;
    $scope.ok = function (valid) {
        if(valid){
            var index = functiontofindIndexByKeyValue(roles, "id_tipo_producto", $scope.new.id_tipo_producto);
            $scope.new.tipo_producto = roles[index].nombre;
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
 <div ng-app="producto">
     <div ng-controller="controller">
		<div class="row">
              <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
		    <div class="col-lg-12">
		        <h1 class="page-header">Productos</h1>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Productos actuales
                        <button class="btn btn-default pull-right btn-xs"  ng-click="open()">Agregar Producto</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Tipo Producto</th>
                                        <th>Precio Compra</th>
                                        <th>Precio Venta</th>
                                        <th>Cantidad</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody ng-show="initialProductos.productos.length > 0">
                                    <tr ng-repeat="user in initialProductos.productos" class="odd gradeX"> 
                                        <td>{{user.id_producto}}</td>
                                        <td>{{user.nombre}}</td>
                                        <td>{{user.tipo_producto}}</td>
                                        <td>{{user.precio_compra}}</td>
                                        <td>{{user.precio_venta}}</td>
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
                <h3 class="modal-title"¨>{{action}} Producto</h3>
            </div>
            <div class="modal-body">
                <form role="form" name="userForm">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" class="form-control" name="userNameField" ng-model="new.nombre" id="exampleInputEmail1" placeholder="Nombre del Producto" required="true"/>
                         <div class="alert-danger" role="alert" ng-show="userForm.userNameField.$error.required">Este campo es requerido</div>
                    </div>
            <div class="form-group">
                        <label for="user-rol-option">Seleccionar Tipo De Producto</label>
                        <select id="user-rol-option" name="selectRol" required ng-model="new.id_tipo_producto" class="form-control" ng-options="rol.id_tipo_producto as rol.nombre for rol in tipo_productos"></select>
                        <div class="alert-danger" role="alert" ng-show="userForm.selectRol.$error.required">Este campo es requerido</div>
                    </div>
              <div class="form-group">
                        <label for="exampleInputEmail1">Precio Compra</label>
                        <input type="text" class="form-control" name="userNameField2" ng-model="new.precio_compra" id="exampleInputEmail1" placeholder="Precio Compra" required="true"/>
                         <div class="alert-danger" role="alert" ng-show="userForm.userNameField2.$error.required">Este campo es requerido</div>
                    </div>
                          <div class="form-group">
                        <label for="exampleInputEmail1">Precio Venta</label>
                        <input type="text" class="form-control" name="userNameField3" ng-model="new.precio_venta" id="exampleInputEmail1" placeholder="Precio Venta" required="true"/>
                         <div class="alert-danger" role="alert" ng-show="userForm.userNameField3.$error.required">Este campo es requerido</div>
                    </div>
              <div class="form-group">
                        <label for="exampleInputEmail1">Cantidad</label>
                        <input type="text" class="form-control" name="userNameField4" ng-model="new.cantidad" id="exampleInputEmail1" placeholder="Cantidad" required="true"/>
                         <div class="alert-danger" role="alert" ng-show="userForm.userNameField4.$error.required">Este campo es requerido</div>
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

