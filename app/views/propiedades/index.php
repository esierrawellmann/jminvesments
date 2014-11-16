<?php  include("./../header.php"); ?>
<?php  include("./../../../backend/app/models/Propiedad.php"); ?>

 <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    function cotizar(propiedad){
        
    }
    </script>


	<header id="myCarousel" class="carousel slide" style="margin-top:70px">

        <!-- Indicators -->
        <ol class="carousel-indicators">
        	<?php 
        		$propiedad = new Propiedad();
		     	$objPropiedad = $propiedad ->getPropertyImages($_GET['property']);
		     	foreach ($objPropiedad as  $key=>$value) {
		     		$class = $key == 0  ? 'class="active"' : '';
				  echo '<li data-target="#myCarousel"  data-slide-to="'.$key.'" '.$class.'></li>';
				}
        	?>
        </ol>
        <!-- Wrapper for Slides -->
        <div class="carousel-inner">
        	<?php 
		     	foreach ($objPropiedad as  $key=>$value) {
		     		$class = $key == 0  ? 'active' : '';
	     			echo '<div class="item '.$class.'">';
				 		echo '<div class="fill" style="background-image:url(\'/backend/images/'.$_GET['property'].'/'.$value['direccion'].'\');"></div>';
					echo '</div>';
				}
        	?>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
	</header>

<style type="text/css">
hr{
    display:block;
    border:none;
    color:white;
    height:1px;
    background:black;
    background: -webkit-gradient(radial, 50% 50%, 0, 50% 50%, 350, from(#193147), to(#fff));
}
</style>


	<div>
        <div class="row">
            <div class="col-lg-3" >
            </div>
            <div class="col-lg-6" style="margin-top:20px;" >
                <?php 
                    $singleProperty = new Propiedad();
                    $objPropiedad = $singleProperty ->getPropertyById($_GET['property']);
                    $amueblado = strcmp($objPropiedad['amueblado'],'true') ? 'Si' : 'No'; 

                    echo '<h3><strong>Codigo : </strong> '.$objPropiedad['id_propiedad'].'</h3>';
                    echo '<hr>';
                    echo '<h3><strong>Tipo : </strong> '.$objPropiedad['tipo'].'</h3>';
                    echo '<hr>';
                    echo '<h3><strong>Negocio : </strong> '.$objPropiedad['negocio'].'</h3>';
                    echo '<hr>';
                    echo '<h3><strong>Zona : </strong> '.$objPropiedad['zona'].'</h3>';
                    echo '<hr>';
                    echo '<h3><strong>Precio Venta : </strong> '.$objPropiedad['precio_venta'].'</h3>';
                    echo '<hr>';
                    echo '<h3><strong>Precio Renta : </strong> '.$objPropiedad['precio_renta'].'</h3>';
                    echo '<hr>';
                    echo '<h3><strong>Amueblado : </strong> '.$amueblado.'</h3>';
                    echo '<hr>';
                    echo '<h3><strong>Area : </strong> '.$objPropiedad['area'].'Mts 2</h3>';
                    echo '<hr>';
                    echo '<h3><strong>Direccion : </strong> '.$objPropiedad['direccion'].'</h3>';
                    echo '<hr>';
                    echo '<h3><strong>Departamento : </strong> '.$objPropiedad['departamento'].'</h3>';
                    echo '<hr>';
                    echo '<h3><strong>Municipio : </strong> '.$objPropiedad['municipio'].'</h3>';
                    echo '<hr>';
                    echo '<h3><strong>Descripcion : </strong> '.$objPropiedad['ambiente'].'</h3>';



                ?>
            </div>
            <div class="col-lg-3" >
                 <button type="button" onclick="cotizar(<?php echo $objPropiedad['id_propiedad'] ; ?>)">Cotizar</button>
            </div>
        </div>
		
	</div>

<?php  include("./../footer.php"); ?>

