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

		<div class="container" > 
            <div class="row">
                <div class="col-lg-12">

                    <h1 class="page-header">Zonas </h1>

                </div>
                    
                    <span class="label label-primary">Seleccione la zona:</span>
                   
                    <div class="row">
                    
                    
                <?php  
                    $contador = count($array);
                   for ($i = 0; $i < $contador; $i++) {
                        
                ?>  
                
                <div class="col-lg-3 col-md-4 col-xs-6" style="text-align:center; padding:60px;">

                    <div class="well" style="height:150px;  cursor:pointer;  vertical-align: middle;" onclick="singleView('<?php echo $array[$i]['zona']; ?>')">
                     <h2 style="font-size:76px; font-weight: bold;"><?php echo $array[$i]['zona']; ?></h2>
                        </div>

                    </div>
                    
                    <?php 
                    }
                    ?> 
                    
             </div>
         </div>

    </div>
<?php  include("../footer.php"); ?>
