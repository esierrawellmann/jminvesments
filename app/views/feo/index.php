<?php  include("../header.php"); ?>


    <script src="/backend/public/js/ui-bootstrap-tpls-0.11.0.min.js" type="text/javascript"></script>

	<script src="/public/js/app.config.js"></script>

	<script src="/public/js/app.min.js"></script>

    <script src="/public/js/plugins/select2.min.js"></script>

    <link href="/public/css/select2-bootstrap.css" rel="stylesheet">

    <link href="/public/css/select2.css" rel="stylesheet">

    <script>

     var app = angular.module('rol', ['ngRoute']);

	 angular.module('rol', ['ui.bootstrap']);

	 function controller($scope, $modal, $log , $http)

	 {

	 	<?php

	 	if(!empty($_POST)){

	 		echo '$scope.src = '.json_encode($_POST).';';
	 	
	 	}else{
	 	
	 		echo '$scope.src = {};';
	 	
	 	}?>
	 	
	 	<?php if(!empty($_POST)){ ?>

	 	if($scope.src.amueblado !=null){
	 	
	 		$scope.src.amueblado = true;
	 	
	 	}
 	    
 	    $scope.$watch('src.dormitorios',function(val,old){

       		$scope.src.dormitorios = parseFloat(val); 

    	});

    	<?php } ?>

    	$scope.resultados = {"mostrar":false};

            angular.element(document).ready(function () {

            $("#tipo").select2();

        	$("#negocio").select2();

        	$("#zona").select2();
        	
	        <?php if(!empty($_POST)){ ?>

        		$scope.findProperties($scope.src); 

    		<?php } ?>


        });



		$scope.showDetail = function (data){

			window.location = "/app/views/propiedades/index.php?property="+data.id_propiedad;

		}

 		$scope.findProperties = function (datos){

 			$scope.resultados.mostrar = true;
 			console.log(datos);
			$http.post('/app/controllers/busqueda/busquedaFunctions.php', '{"action":"query","data":'+JSON.stringify(datos)+'}').success(function(data){

				$scope.properties = data;

				$scope.src = {};

			});             

		}

	 }

    </script>



    <div class="main-content" ng-app="rol"> 

		<div class="container" ng-controller="controller">

			<div class="row">

				<div class="col-lg-3">

					<div class="panel panel-default"  collapse="isCollapsed">

						<div class="panel-heading">

							<div class="row">

								<div class="col-lg-12">

									<label for="tipo">Tipo</label>

									<div class="form-group">

							            	<input type="checkbox"> Apartamento

							            	<input type="checkbox"> Bodega

							            	<input type="checkbox"> Casa

							            	<input type="checkbox"> Edificio

							            	<input type="checkbox"> Local

							            	<input type="checkbox"> Terreno

							            	<input type="checkbox"> Oficina

									</div>

									<label for="negocio">Negocio</label>

									<div class="form-group">

										<select multiple="" ng-model="src.negocio" name="negocio" id="negocio" class="form-control populate select2-offscreen" tabindex="-1">

							            	<option>Venta</option>

							            	<option>Renta</option>

						              	</select>

									</div>

									<div class="form-group">

										<label for="dormitorios">Dormitorios</label>
										
										<input type="number" class="form-control" ng-model="src.dormitorios" id="dormitorios" >

									</div>

									<div class="form-group">

										<label for="precio_venta">Precio de venta</label>

										<select name="precio_venta" ng-model="src.precio_venta" class="form-control" id="precio_venta">

										   <option value="" selected="">[Opcional]</option>

										      <option value="1">Menor a  $ 75,000 USD</option>

										      <option value="2">$ 75,000 - $ 100,000 USD</option>

										      <option value="3">$ 100,001 - $ 150,000 USD</option>

										      <option value="4">$ 150,001 - $ 200,000 USD</option>

										      <option value="5">$ 200,001 - $ 250,000 USD</option>

										      <option value="6">$ 250,001 - $ 300,000 USD</option>

										      <option value="7">Mayor a  $ 300,000 USD</option>

										</select>

									</div>

									<div class="form-group">

										<label for="precio_renta">Precio de renta</label> 

										<select name="precio_renta" ng-model="src.precio_renta" class="form-control" id="precio_renta">

										   <option value="" selected="">[Opcional]</option>

										      <option value="8">Menor a  $ 500 USD</option>

										      <option value="9">$ 500 - $ 1,000 USD</option>

										      <option value="10">$ 1,001 - $ 1,500 USD</option>

										      <option value="11">$ 1,501 - $ 2,000 USD</option>

										      <option value="12">$ 2,001 - $ 2,500 USD</option>

										      <option value="13">$ 2,501 - $ 3,000 USD</option>

										      <option value="14">Mayor a  $ 3,000 USD</option>

										</select>

									</div>
									
									 <label for="zona">Zonas</label>

                                <div class="form-group">

                                    <select multiple="" name="zona" id="zona" ng-model="src.zona" class="form-control populate select2-offscreen" tabindex="-1">

                                        <option>Todas</option>

                                        <option>Carretera a El Salvador</option>

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

										<div class="checkbox">

										<label>

											<input type="checkbox" ng-model="src.amueblado"> Amueblado

										</label>

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

				<div class="col-lg-9">



				</div>

			</div>

		</div>

	</div>

<?php  include("../footer.php"); ?>