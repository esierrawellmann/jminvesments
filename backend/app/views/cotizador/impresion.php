
<?php  include("../header.php"); 
$json = json_decode($_POST['param'], true);
$contador = count($json);
?>
<style>
    @media print {
        .row {
            margin-left: 100px;
            margin:top:75px
        }

    }
</style>
    <div class="row" style="" >
        <div class="col-sm-12" style="margin-top:70px;">
                <label class=""><?php echo $_POST['encabezado']; ?></label>
        </div>

        <div class="col-sm-12">
                <br><br><br>
                <label>Señor(a)</label><br>
                <label><?php echo $_POST['cliente']; ?></label><br>
                <label>Presente</label><br><br><br>
                
                <label>Estimado <?php echo $_POST['cliente']; ?></label><br><br>
                
                <p>Es para nosotros un gusto darle a conocer las propiedades que veremos el dia de hoy.</p>
                <br>
                <br>
        </div>
        
        
                <?php for ($i = 0; $i < $contador; $i++) {
                       ?> 
               <div class="col-sm-12">
                    <label> <?php echo ($i+1).". "; echo $json[$i]['tipo']." - ".$json[$i]['nombre_proyecto']; ?> </label><br> 
                    <div class="col-lg-5" style="margin-bottom:60px">
                        <?php echo $json[$i]['ambiente']; ?>
                        <label>Area:</label> <?php echo $json[$i]['area']." Mts"; ?>
                        <label>Precio:</label> <?php echo "$ ".$json[$i]['precio_venta']; ?>
                    </div>
               </div>
            <?php  }?>
        

        <div class="col-sm-12 ">
                <label> Agradeciendo la oportunidad de servirle </label><br><br>
                <label>Atentamente,</label><br><br>
                
                <label><?php echo $_POST['asesor']; ?></label><br>
                <label><?php echo $_POST['puesto']; ?></label>
        </div>
    </div>

  <?php include("../footer.php"); 
  ?>




