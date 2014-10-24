<?php  include("../header.php"); ?>
	<script src="/public/js/app.config.js"></script>
	<script src="/public/js/app.min.js"></script>
    <script src="/public/js/plugins/select2.min.js"></script>
	<script src="/public/js/plugins/ion-slider/ion.rangeSlider.min.js"></script>
	<link href="/public/css/smartadmin-production.min.css" rel="stylesheet">
    <link href="/public/css/select2-bootstrap.css" rel="stylesheet">
    <link href="/public/css/select2.css" rel="stylesheet">
    <script>
        $(document).ready(function() { 
        	$(".li-advanced-search").addClass("active");

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
		        hasGrid: true
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
		        hasGrid: true
		    });
        });
    </script>
    <div class="main-content">
		<div class="container">
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
								<select multiple="" name="tipo" id="tipo" class="form-control populate select2-offscreen" tabindex="-1">
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
								<select multiple="" name="negocio" id="negocio" class="form-control populate select2-offscreen" tabindex="-1">
					            	<option>Venta</option>
					            	<option>Renta</option> 
				              	</select>
							</div>
							<label for="zona">Zonas</label>
							<div class="form-group">
								<select multiple="" name="zona" id="zona" class="form-control populate select2-offscreen" tabindex="-1">
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
								<select class="form-control">
									<option>Todos</option>
									<option>Disponible</option>
									<option>No Disponible</option>
								</select>
							</div>
							<div class="form-group">
								<label for="venta">Precio de venta</label>
								<input id="venta"  type="text" name="venta" value="">
							</div>
						</div>
				    	<div class="col-lg-6">
							<div class="form-group">
								<label for="proyecto">Nombre del proyecto</label>
								<input type="text" class="form-control" id="proyecto" >
							</div>
							<div class="form-group">
								<label for="propietario">Nombre del propietario</label>
								<input type="text" class="form-control" id="propietario" >
							</div>
							<div class="form-group">
								<label for="dormitorios">Dormitorios</label>
								<input type="number" class="form-control" id="dormitorios" >
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="renta">Precio de renta</label>
								<input id="renta" type="text" name="renta" value="">
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-lg-6">
										<div class="checkbox">
											<label>
												<input type="checkbox"> Amueblado
											</label>
										</div>
									</div>
									<div class="col-lg-6">	
										<div class="row">
											<div class="col-lg-6">
												<div class="checkbox">
													<label>
														<input type="radio" name="tipo-renta" value="directa">Directa<br>
													</label>
												</div>
											</div>
											<div class="col-lg-6">	
												<div class="checkbox">
													<label>
														<input type="radio" name="tipo-renta" value="compartida">Compartida
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
								<button type="submit" class="btn btn-default pull-right">Busqueda</button>
						</div>
					</div>
		    	</div>
			</div>
		</div>
	</div>
<?php  include("../footer.php"); ?>