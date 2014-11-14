
<?php  include("../header.php"); 

//header("Content-Type: application/pdf");
//header("Content-Disposition: attachment; filename=\"ejemplo.pdf\"");
//passthru("htmldoc --embedfonts --format pdf --left 2.5cm --right 1.5cm --top 1.5cm --bottom 1.5cm " .
//"--headfootsize 5 --header 'l' --footer 't' '/' " .
//"--logoimage ../imagen.jpg --linkcolor '#0000FF' " .
//"--size 'a4' --fontsize 10 --bodyfont Verdana --charset 8859-15");
//  var_dump($_POST['encabezado']);
//  var_dump($_POST['cliente']);
//  var_dump($_POST['asesor']);
//  var_dump($_POST['puesto']);
//  var_dump(json_decode($_POST['param'])); 

$json = json_decode($_POST['param'], true);
$contador = count($json);
?>

<style>
    @media print {
        .row {
            margin-left: 50px;
        }
    }
</style>

    <div class="row" >
    
                <div class="col-lg-8 pull-right">
                    <div class="form-group">
                        <label><?php echo $_POST['encabezado']; ?></label>
                    </div>
                </div>
        
                <div class="col-lg-8 ">
                    <div class="form-group">
                        <br><br><br>
                        <label>Señor(a)</label><br>
                        <label><?php echo $_POST['cliente']; ?></label><br>
                        <label>Presente</label><br><br><br>
                        
                        <label>Estimado <?php echo $_POST['cliente']; ?></label><br><br>
                        
                        Es para nosotros un gusto darle a conocer los apartamentos que veremos el dia de hoy.
                        <br>
                        <br>
                    </div>
                </div>
                
                <div class="col-lg-8 ">
                    <div class="form-group">
                        <?php 
                        for ($i = 0; $i < $contador; $i++) {
                               ?> 
                        <label> <?php echo ($i+1).". "; echo $json[$i]['tipo']." - ".$json[$i]['nombre_proyecto']; ?> </label><br> 
                       <div class="col-lg-5">
                         <?php echo $json[$i]['ambiente']; ?>
                           <label>Area:</label> <?php echo $json[$i]['area']." Mts"; ?>
                           <label>Precio:</label> <?php echo "$ ".$json[$i]['precio_venta']; ?>
                       </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                          <?php  }
                        ?>
                    </div>
                </div>
        
                <div class="col-lg-8 ">
                    <div class="form-group">
                        <label> Agradeciendo la oportunidad de servirle </label><br><br>
                        <label>Atentamente,</label><br><br>
                        
                        <label><?php echo $_POST['asesor']; ?></label><br>
                        <label><?php echo $_POST['puesto']; ?></label>
                    </div>
                </div>
    </div>

  <?php include("../footer.php"); 
  ?>




