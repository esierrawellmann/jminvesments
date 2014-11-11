<?php  include("../header.php"); ?> 
    <script src="/backend/public/js/angular.min.js" type="text/javascript"></script>
    <script src="/backend/public/js/angular-route.min.js" type="text/javascript"></script>
    <script src="/backend/public/js/ui-bootstrap-tpls-0.11.0.min.js" type="text/javascript"></script>
    <script src="/public/js/app.config.js"></script>
    <script src="/public/js/app.min.js"></script>
        
<script>
        var app = angular.module('rol', ['ngRoute']);
	angular.module('rol', ['ui.bootstrap']);
        
</script>

 <div class="main-content" ng-app="rol"> 
		<div class="container" ng-controller="controller">
			<div class="row">
				<div class="col-lg-12">
					<img src="/public/img/logojm.png" class="img-responsive pull-right" alt="Logo">
					<h1 class="page-header">Cotización en linea - Proyecciones para su Inversion</h1>
				</div>
			</div>
             
            <div class="row">
                <div class="col-sm-8"> 
               <div class="panel panel-primary">
                   <div class="panel-heading"><h6 class="panel-title">Apartamento Torre Elgin</h6></div>
                 <div class="panel-body">
                     
                      <form role="form">
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-6 control-label">Modelo</label>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Modelo">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-6 control-label">Nivel</label>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputPassword3" placeholder="Nivel">
                          </div>
                        </div>
                          <div class="form-group">
                          <label for="inputEmail4" class="col-sm-6 control-label">Metros Cuadrados de Construccion</label>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Mts.2">
                          </div>
                        </div>
                          
                           <div class="form-group">
                          <label for="inputEmail5" class="col-sm-6 control-label">No. de Dormitorios</label>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputEmail5" placeholder="Dormitorios">
                          </div>
                        </div>
                          
                          <div class="form-group">
                          <label for="inputEmail6" class="col-sm-6 control-label">No. de Parqueos</label>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputEmail6" placeholder="Parqueos">
                          </div>
                        </div>
                          
                      </form>
                 </div>
                 
                    </div>
               </div>     
            </div>
		</div>
	</div>
        
<?php  include("../footer.php"); ?>

