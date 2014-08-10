
<?php  include("../header.php");
 ?>
 <script>
 var app = angular.module('permiso', ['ngRoute']);
 angular.module('permiso', ['ui.bootstrap']);
 function controller($scope, $modal, $log , $http)
 {
    $scope.permiso = [];
    $scope.initialPermisos =[]
    angular.element(document).ready(function () {
    	$http.post('../../controllers/permiso/permisoFunctions.php', '{"action":"query"}').success(function(data){
            $scope.initialPermisos = data;
         });
    });

    $scope.alerts = [
      ];

      $scope.addAlert = function() {
        $scope.alerts.push({msg: 'Another alert!'});
      };

      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };

    $scope.deleteRol = function (permiso){
        $scope.alerts = [];
        var index = $scope.initialPermisos.indexOf(permiso);
         $scope.initialPermisos.splice(index,1);
         
         $http.post('../../controllers/permiso/permisoFunctions.php','{"action":"delete","permiso":'+JSON.stringify(permiso)+'}').success(function(data){
            $scope.alerts.push({type: 'success', msg: 'Permiso  Exitosamente Eliminado' });
         });
    }
    $scope.showUpdateDialog = function (data,size){
    	var modalInstanceUpdate = $modal.open({
            templateUrl: 'myModalContent.html',
            controller: ModalInstanceUpdateCtrl,
            size: size,
            resolve: {
                action: function(){
                return "Modificar";
            }, 
                permiso: function () {
              		return data;
          		}
          	}
        });
        modalInstanceUpdate.result.then(function (permiso) {
            $scope.alerts = [];
            $http.post('../../controllers/permiso/permisoFunctions.php', '{"action":"update","permiso":'+JSON.stringify(permiso)+'}').success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Permiso Modificado Exitosamente' });
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
          	permiso: function () {
            		return [];
        		}
        	}
        });

        modalInstanceOpen.result.then(function (permiso) {
           $scope.alerts = [];
           $http.post('../../controllers/permiso/permisoFunctions.php', '{"action":"insert","permiso":"'+permiso.nombre+'"}').success(function(data){
                $scope.initialPermisos.push(data[0]);
                $scope.alerts.push({type: 'success', msg: 'Permiso Agregado Exitosamente' });
             });             
        }, function () {});
    };
        

 }
 var ModalInstanceAddCtrl = function ($scope, $modalInstance,permiso,action) {
    $scope.permiso = permiso;
    $scope.action = action;
    $scope.ok = function (permiso) {
        $modalInstance.close(permiso);
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};
var ModalInstanceUpdateCtrl = function ($scope, $modalInstance,permiso,action) {
    $scope.permiso = permiso;
    $scope.action = action;
    $scope.ok = function (permiso) {
        $modalInstance.close(permiso);
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};
 </script>
<div ng-app="permiso">
	<div ng-controller="controller">
		<div class="row">
              <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
		    <div class="col-lg-12">
		        <h1 class="page-header">Permisos</h1>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Permiso actuales
                        <button class="btn btn-default pull-right btn-xs"  ng-click="open()">Agregar Permiso</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Permiso</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody ng-show="initialPermisos.length > 0">
                                    <tr ng-repeat="data in initialPermisos" class="odd gradeX"> 
                                        <td>{{data.id_permiso}}</td>
                                        <td>{{data.nombre}}</td>
                                        <td>
                                        	<div class="btn-group">
											  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
											    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
											  </button>
											  <ul class="dropdown-menu" role="menu">
											    <li><a href="#" ng-click="showUpdateDialog(data)"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
											    <li><a href="#" ng-click="deleteRol(data)"> <i class="fa fa-minus-square"></i>  Eliminar</a></li>
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
                <h3 class="modal-title"¨>{{action}} Permiso</h3>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" class="form-control" ng-model="permiso.nombre" id="exampleInputEmail1" placeholder="Nombre del Permiso"/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" ng-click="ok(permiso)">OK</button>
                <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
            </div>
        </script>
	</div>
</div>
<?php  include("../footer.php"); ?>
