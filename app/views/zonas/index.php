<?php  include("../header.php"); 
        require_once '../../../backend/app/models/Propiedad.php';
        
        $negocio = $_GET['negocio'];
        $tipo = $_GET['tipo'];
        $zona = new Propiedad(); 
        
        $array = $zona->getZonas($negocio,$tipo);
?> 

<script>
     function singleView(tipo){

        window.location = "/app/views/zonas/index.php?zona="+tipo;

    }
    </script>

 <div class="main-content"> 

		<div class="container" > 
                    
                <?php  
                    $contador = count($array);
                   for ($i = 0; $i < $contador; $i++) {
                        
                ?>  
                
                <div class="col-lg-6" style="">

                    <div class="well" style="height:200px; overflow-y:auto; cursor:pointer;" onclick="singleView('<?php echo $array[$i]['zona']; ?>')">
                     <h2 style="margin-top: 0;"><?php echo $array[$i]['zona']; ?></h2>
                     <img class="img-responsive" src="bodega.jpg">
                        </div>

                    </div>
                    
                    <?php 
                    }
                    ?> 
                    
                     </div>
    </div>
<?php  include("../footer.php"); ?>