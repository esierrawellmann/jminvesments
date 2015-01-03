<?php  include("../header.php"); 
        require_once '../../../backend/app/models/Propiedad.php';
        
        $negocio = $_GET['negocio'];
        $tipo = $_GET['tipo'];
        $zona = new Propiedad(); 
        
        $array = $zona->getZonas($negocio,$tipo);
?> 

<script>
     function singleView(zona){

        var tipo = '<?php echo $tipo; ?>'; 
        var negocio = '<?php echo $negocio; ?>'; 
        window.location = "/app/views/propiedadesZona/index.php?zona="+zona+"&tipo="+tipo+"&negocio="+negocio;

    }
    </script>

 <div class="main-content"> 

		<div class="container"> 
                    
                    <span class="label label-primary">Seleccione la zona:</span>
                   
                    <div class="row">
                    
                    
                <?php  
                    $contador = count($array);
                   for ($i = 0; $i < $contador; $i++) {
                        
                ?>  
                
                <div class="col-lg-2" style="">

                    <div class="well" style="height:90px; overflow-y:auto; cursor:pointer;" onclick="singleView('<?php echo $array[$i]['zona']; ?>')">
                     <h2 style="margin-top: 0;"><?php echo $array[$i]['zona']; ?></h2>
                        </div>

                    </div>
                    
                    <?php 
                    }
                    ?> 
                    </div>
                    
                     </div>
    </div>
<?php  include("../footer.php"); ?>