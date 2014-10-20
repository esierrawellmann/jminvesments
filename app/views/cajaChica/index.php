<?php  include("../header.php");
 ?>
 <script>
 var app = angular.module('cajaChica', ['ngRoute']);
 angular.module('cajaChica', ['ui.bootstrap']);
 function controller($scope, $modal, $log , $http)
 {
    $scope.caja = [];
    $scope.initialCaja =[]
    angular.element(document).ready(function () {
    	$http.post('./../../controllers/cajaChica/cajaChicaFunctions.php', '{"action":"query"}').success(function(data){
            $scope.initialCaja = data;
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
            $http.post('./../../controllers/cajaChica/cajaChicaFunctions.php', '{"action":"update","caja":'+JSON.stringify(permiso)+'}').success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Caja Chica Modificada Exitosamente' });
             });
             
        }, function () {
        });
    };
        

 }
 
var ModalInstanceUpdateCtrl = function ($scope, $modalInstance,permiso,action) {
    $scope.caja = permiso;
    $scope.action = action;
    $scope.ok = function (permiso) {
        $modalInstance.close(permiso);
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};
 </script>
<div ng-app="cajaChica">
	<div ng-controller="controller">
		<div class="row">
              <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
		    <div class="col-lg-12">
		        <h1 class="page-header">Caja Chica</h1>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Caja Chica actual
                        <button class="btn btn-default pull-right btn-xs" ng-disabled="true" ng-click="open()">Agregar Permiso</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Cantidad</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody ng-show="initialCaja.length > 0">
                                    <tr ng-repeat="data in initialCaja" class="odd gradeX"> 
                                        <td>{{data.id_caja}}</td>
                                        <td>{{data.cantidad}}</td>
                                        <td>
                                        	<div class="btn-group">
											  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
											    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
											  </button>
											  <ul class="dropdown-menu" role="menu">
											    <li><a href="#" ng-click="showUpdateDialog(data)"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
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
                <h3 class="modal-title"¨>{{action}} Caja Chica</h3>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Cantidad</label>
                        <input type="text" class="form-control" ng-model="caja.cantidad" id="exampleInputEmail1" placeholder="Cantidad"/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" ng-click="ok(caja)">OK</button>
                <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
            </div>
        </script>
	</div>
</div>
<?php  include("../footer.php"); ?>
