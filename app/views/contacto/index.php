<?php  include("./../header.php");
    ob_start();
    ?>
	  	<div class="main-content" > 
			<div class="container">
				<div class="row">
	                <div class="col-lg-12">
	                    <h1 class="section-heading">Contacto</h1>
	                    <hr>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-lg-12">
	                	<div class="well">
		                    <form name="sentMessage" id="contactForm" action="sendMail.php" method="post" novalidate>
		                        <div class="row">
		                            <div class="col-md-6">
		                                <div class="form-group">
		                                    <input type="text" class="form-control" placeholder="Ingrese Su Nombre." id="name" name="name" required data-validation-required-message="Ingrese Su Nombre.">
		                                    <p class="help-block text-danger"></p>
		                                </div>
		                                <div class="form-group">
		                                    <input type="email" class="form-control" placeholder="Ingrese su Email *" name="id" id="email" required data-validation-required-message="Ingrese su direccion.">
		                                    <p class="help-block text-danger"></p>
		                                </div>
		                                <div class="form-group">
		                                    <input type="tel" class="form-control" placeholder="Ingrese su numero telefonico" name="phone" id="phone" required data-validation-required-message="Ingrese su numero telefonico.">
		                                    <p class="help-block text-danger"></p>
		                                </div>
		                                <div class="form-group">
		                                    <textarea class="form-control" placeholder="" id="message" name="message" required data-validation-required-message="Ingrese su mensaje."></textarea>
		                                    <p class="help-block text-danger"></p>
		                                </div>
		                            </div>
		                            <div class="col-md-6">
		                                
						                	<h2 class="section-heading">Información de Contacto</h2>
						                    <address>
											  <strong>13 Calle 8-44 zona 10 Oficina 102.</strong><br>
											  Teléfonos: +502 2385-61288 ó 2385-3407<br>
											  Email: info@jminversiones.com<br>
											</address>
		                            </div>
		                            <div class="clearfix"></div>
		                            <div class="col-lg-12 text-center">
		                                <div id="success"></div>
		                                <button type="submit" class="btn btn-xl">Enviar Mensaje</button>
		                            </div>
		                        </div>
		                    </form>
		                </div>
	                </div>
	            </div>
	        </div>
	    </div>	
<?php  include("./../footer.php"); ?>
