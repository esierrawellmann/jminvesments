<?php  include("../header.php"); 
        require_once '../../../backend/app/models/Propiedad.php';

$negocio = $_GET['negocio'];
$tipo = $_GET['tipo'];
$zona = $_GET['zona'];

?> 
<script>
     function singleView(propiedad){
        window.location = "/app/views/propiedades/index.php?property="+propiedad;
    }
    </script>

<div class="main-content"> 

		<div class="container" > 
                    <div class="row" style="padding-top: 20px;"> 
                        
                        
                        <?php 
                        $propiedades = new Propiedad();
                        $pro = $propiedades->getPropiedadesManuales($negocio, $tipo, $zona);
                        
                        foreach ($pro as $key=>$value) { 
                            $amueblado = ($value['amueblado'] === 'true') ? 'Si' : 'No'; ?> 
                        <div class="col-lg-6" style=""> 
                            <div class="well" style="height:250px; overflow-y:auto; cursor:pointer;" onclick="singleView(<?php echo $value['id_propiedad']; ?>)">
                                <div class="row"> 
                                    <div class="col-sm-5 olis" style="padding-right: 0px; "> 
                                        <img class="img-responsive" style="height: 100px;width: 140px;" src="<?php echo '/backend/images/'.$value['id_propiedad'].'/'.$value['imagen']; ?>" ></img> </div>
                                    <div class="col-sm-7">
                                        <small><strong>Tipo: </strong><?php echo $value['tipo']; ?></small></br> 
                                        <small><strong>Zona: </strong><?php echo $value['zona']; ?></small></br> 
                                        <small><strong>Amueblada: </strong><?php echo $amueblado; ?></small></br> 
                                    </div> 
                                </div> 
                                <div class="row"> 
                                    <div class="col-sm-12" style="overflow:auto; margin-top:20px;"> 
                                        <small><strong>Direccion: </strong><?php echo $value['direccion']; ?></small></br>
                                        <small><strong>Ambiente: </strong><?php echo $value['ambiente']; ?></small>
                                    </div> 
                                </div> 
                            </div>
                        </div> <?php } ?>
                        
                        
                    
                </div>
</div>
