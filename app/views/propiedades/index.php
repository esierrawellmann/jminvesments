<?php  include("./../header.php"); ?>
<?php  include("./../../../backend/app/models/Propiedad.php"); ?>

 <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
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
				 		echo '<div class="fill" style="background-image:url(\''.$value['nombre'].$value['direccion'].'\');"></div>';
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

	<div>
		
	</div>

<?php  include("./../footer.php"); ?>

