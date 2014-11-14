<?php  include("header.php"); ?>
<?php  include("./../../backend/app/models/Propiedad.php"); ?>


    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>


	<header id="myCarousel" class="carousel slide" style="margin-top:50px">

        <!-- Indicators -->
        <ol class="carousel-indicators">
           <?php 
                $propiedad = new Propiedad();
                $objPropiedadSinImagen = $propiedad ->getTopForProperties();
                $objPropiedad = $propiedad ->getTopForImages();
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
                        echo '<div class="fill" style="background-image:url(\'/backend/images/'.$value['id_propiedad'].'/'.$value['direccion'].'\');"></div>';
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


    <div class="main-content" > 
        <div class="container">
            <div class="row">

                <?php foreach ($objPropiedadSinImagen as  $key=>$value) { ?>
                <div class="col-lg-6">
                    <div class="well" style="height:175px; overflow-y:auto; cursor:pointer;">
                        <div class="row">
                            <div class="col-lg-4 olis" style="height: 60px;padding-right: 0px;  ">
                                <img class="img-responsive img-circle" style="height: inherit;width: 64px;" ng-src="/backend/images/{{property.id_propiedad}}/{{property.url}}"></img>
                            </div>
                            <div class="col-lg-8">
                                <small><strong>Tipo: </strong>{{property.tipo}}</small></br>
                                <small><strong>Zona: </strong>{{property.zona}}</small></br>
                                <small><strong>Amueblada: </strong>{{property.amueblado === 'true' ? 'Si': 'No' }} </small></br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="overflow:auto;">
                                <small><strong>Direccion: </strong>{{property.direccion}}</small></br>
                                <small><strong>Ambiente: </strong>{{property.ambiente}}</small>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

    </div>
</div>


<?php  include("footer.php"); ?>