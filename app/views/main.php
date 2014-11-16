<?php  include("header.php"); ?>
<?php  include("./../../backend/app/models/Propiedad.php"); ?>


    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    function singleView(propiedad){
        window.location = "/app/views/propiedades/index.php?property="+propiedad;
    }
    </script>


	<header id="myCarousel" class="carousel slide" style="margin-top:50px">

        <!-- Indicators -->
        <ol class="carousel-indicators">
           <?php 
                $propiedad = new Propiedad();
                $objPropiedad = $propiedad ->searchTopFor();
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
                        echo '<div class="fill" style="background-image:url(\'/backend/images/'.$value['id_propiedad'].'/'.$value['imagen'].'\');"></div>';
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


    <div class="" > 
        <div class="">
            <div class="row" style="padding-top: 20px;  width: 73%; margin: 0 auto;">

                <?php
                foreach ($objPropiedad as  $key=>$value) { 
                    $amueblado = strcmp($value['amueblado'],'true') ? 'Si' : 'No'; 
                    ?>
                <div class="col-lg-6">
                    <div class="well" style="height:250px; overflow-y:auto; cursor:pointer;" onclick="singleView(<?php echo $value['id_propiedad']; ?>)">
                        <div class="row">
                            <div class="col-lg-4 olis" style="padding-right: 0px;  ">
                                <img class="img-responsive"  style="height: 100px;width: 140px;"   src="<?php echo '/backend/images/'.$value['id_propiedad'].'/'.$value['imagen']; ?>"  ></img>
                            </div>
                            <div class="col-lg-8">
                                <small><strong>Tipo: </strong><?php echo $value['tipo']; ?></small></br>
                                <small><strong>Zona: </strong><?php echo $value['zona']; ?></small></br>
                                <small><strong>Amueblada: </strong><?php echo $amueblado; ?></small></br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="overflow:auto;">
                                <small><strong>Direccion: </strong><?php echo $value['direccion']; ?></small></br>
                                <small><strong>Ambiente: </strong><?php echo $value['ambiente']; ?></small>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

    </div>
</div>


<?php  include("footer.php"); ?>