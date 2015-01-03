<?php  include("../header.php"); 
        require_once '../../../backend/app/models/Propiedad.php';

$negocio = $_GET['negocio'];
$tipo = $_GET['tipo'];
$zona = $_GET['zona'];

?> 

<div class="main-content"> 

		<div class="container" > 
                    <?php 
                    var_dump($negocio);
                    var_dump($tipo);
                    var_dump($zona); 
                    
                    $propiedades = new Propiedad();
                    $pro = $propiedades->getPropiedadesManuales($negocio, $tipo, $zona);
                    
                    var_dump($pro);
                    
                    ?>
                </div>
</div>
