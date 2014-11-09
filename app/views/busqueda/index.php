<?php  include("../header.php"); ?>
    <script src="/backend/public/js/angular.min.js" type="text/javascript"></script>
    <!-- Morris Charts JavaScript -->
    <script src="/backend/public/js/angular-route.min.js" type="text/javascript"></script>
    <script src="/backend/public/js/ui-bootstrap-tpls-0.11.0.min.js" type="text/javascript"></script>
	<script src="/public/js/app.config.js"></script>
	<script src="/public/js/app.min.js"></script>
    <script src="/public/js/plugins/select2.min.js"></script>
	<script src="/public/js/plugins/ion-slider/ion.rangeSlider.min.js"></script>

    <link href="/public/css/select2-bootstrap.css" rel="stylesheet">
    <link href="/public/css/select2.css" rel="stylesheet">
    <script>
     var app = angular.module('rol', ['ngRoute']);
	 angular.module('rol', ['ui.bootstrap']);
	 function controller($scope, $modal, $log , $http)
	 {
	 	$scope.src = {};
	 	angular.element(document).ready(function () {
	 		$("#tipo").select2();
        	$("#negocio").select2();
        	$("#zona").select2();

        	 $("#renta").ionRangeSlider({
		        min: 0,
		        max: 1000000,
		        from: 0,
		        to: 40000,
		        type: 'double',
		        step: 1,
		        prefix: "$",
		        prettify: false,
		        hasGrid: true, 
		        onChange: function (obj) {      // callback is called on every slider change
			       $scope.src.renta_desde = obj.fromNumber;
			       $scope.src.renta_hasta = obj.toNumber;
			    }
		    });
        	  $("#venta").ionRangeSlider({
		        min: 0,
		        max: 1000000,
		        from: 0,
		        to: 40000,
		        type: 'double',
		        step: 1,
		        prefix: "$",
		        prettify: false,
		        hasGrid: true, 
		        onChange: function (obj) {      // callback is called on every slider change
			       $scope.src.venta_desde = obj.fromNumber;
			       $scope.src.venta_hasta = obj.toNumber;
			    }
		    });
    	  
	    });

 		$scope.findProperties = function (datos){

			$http.post('/app/controllers/busqueda/busquedaFunctions.php', '{"action":"query","data":'+JSON.stringify(datos)+'}').success(function(data){
				console.log(data);
			});             
		}
	 }
    </script>

    <div class="main-content" ng-app="rol"> 
		<div class="container" ng-controller="controller">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Busqueda</h1>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-6">
							<label for="tipo">Tipo</label>
							<div class="form-group">
								<select multiple="" ng-model="src.tipo" name="tipo" id="tipo" class="form-control populate select2-offscreen" tabindex="-1">
					            	<option>Apartamento</option>
					            	<option>Bodega</option>
					            	<option>Casa</option>
					            	<option>Edificio</option>
					            	<option>Local</option>
					            	<option>Terreno</option>
				              	</select>
							</div>
							<label for="negocio">Negocio</label>
							<div class="form-group">
								<select multiple="" ng-model="src.negocio" name="negocio" id="negocio" class="form-control populate select2-offscreen" tabindex="-1">
					            	<option>Venta</option>
					            	<option>Renta</option>
				              	</select>
							</div>
							<label for="zona">Zonas</label>
							<div class="form-group">
								<select multiple="" name="zona" ng-model="src.zona" id="zona" class="form-control populate select2-offscreen" tabindex="-1">
					            	<option>Todas</option>
					            	<option>1</option>
					            	<option>2</option>
					            	<option>3</option>
					            	<option>4</option>
					            	<option>5</option>
					            	<option>6</option>
					            	<option>7</option>
					            	<option>8</option>
					            	<option>9</option>
					            	<option>10</option>
					            	<option>11</option>
					            	<option>12</option>
					            	<option>13</option>
					            	<option>14</option>
					            	<option>15</option>
					            	<option>16</option>
					            	<option>17</option>
					            	<option>18</option>
					            	<option>19</option>
					            	<option>21</option>
				              	</select>
							</div>
							<div class="form-group">
								<label for="zona">Status</label>
								<select class="form-control" ng-model="src.estado">
									<option>Todos</option>
									<option>Disponible</option>
									<option>No Disponible</option>
								</select>
							</div>
							<div class="form-group">
								<label for="venta">Precio de venta</label>
								<input id="venta"  type="text" name="venta" ng-model="src.precio_venta" value="">
							</div>
						</div>
				    	<div class="col-lg-6">
							<div class="form-group">
								<label for="proyecto">Nombre del proyecto</label>
								<input type="text" class="form-control" ng-model="src.nombre_proyecto" id="proyecto" >
							</div>
							<div class="form-group">
								<label for="propietario">Nombre del propietario</label>
								<input type="text" class="form-control" ng-model="src.nombre_propietario" id="propietario" >
							</div>
							<div class="form-group">
								<label for="dormitorios">Dormitorios</label>
								<input type="number" class="form-control" ng-model="src.dormitorios" id="dormitorios" >
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="renta">Precio de renta</label>
								<input id="renta" type="text" name="renta" ng-model="src.precio_renta" >
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-lg-6">
										<div class="checkbox">
											<label>
												<input type="checkbox" ng-model="src.amueblado"> Amueblado
											</label>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="row">
											<div class="col-lg-6">
												<div class="checkbox">
													<label>
														<input type="radio" name="tipo-renta" ng-model="src.directa_compartida" value="directa">Directa<br>
													</label>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="checkbox">
													<label>
														<input type="radio" name="tipo-renta" ng-model="src.directa_compartida" value="compartida">Compartida
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
								<button type="submit" ng-click="findProperties(src)" class="btn btn-default pull-right">Busqueda</button>
						</div>
					</div>
		    	</div>
			</div>
		</div>
	</div>
<?php  include("../footer.php"); ?>