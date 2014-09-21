<?php  include("../header.php");
        require_once '../../models/Usuario.php';
        
        if(isset($_POST['todos']) || isset($_POST['id_usuario'])){
?>

<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>Perfil </strong> obtenido exitosamente 
</div>

        <?php } ?>
  <div class="col-lg-12">
        <h1 class="page-header">Perfil</h1>
   </div>


<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Realizar Perfil
 </div>
                   <!-- echo "Role: ".$_SESSION['usuario'][0]['role_name'];  -->
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            
                            <?php
                                  $usuario = new Usuario();
                                  $lista = $usuario->getUsers();
                            ?>
                            <form action="index.php" method="POST">
                               
                            <select id="id_usuario" name="id_usuario" class="form-control">
                                 <?php 
                            $contador_array = count($lista);
                             for($c=0;$c<$contador_array;$c++){
                                     ?>
                            <option value="<?php echo $lista[$c]['id_usuario']  ?>"><?php echo $lista[$c]['nombre'] ?></option>

                                <?php } ?>
                             </select>
                            <br>

                            <div class="row">
                              <div class="col-md-6">
                                <label> Fecha Inicio: </label>
                                    <input class="form-control" type="text" onclick="displayDatePicker('fecha');" name="fecha" readonly required="true"/> 
                                
                              </div>
                              <div class="col-md-6">
                                <label> Fecha FInal: </label>
                                    <input class="form-control" type="text" onclick="displayDatePicker('fecha_final');" name="fecha_final" readonly required="true"/> 
                                
                              </div>
                            </div>
                                
                                 <br>
                            <button type="submit" class="btn btn-danger">Generar Pefil</button>
                            </form>
                        </div>
                    </div>
                </div> 
    
    <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Perfil: Ventas
 </div>
    
    <div class="panel-body">
                        <div class="table-responsive">
                            
                                   
                                   <?php 
                                   
                                   $total = 0;
                                   $total_efectivo =0;
                                   $total_tarjeta=0;
                                   $fecha="";
                                   date_default_timezone_set("America/Guatemala");
                                   if(isset($_POST['fecha'])){
                                       if($_POST['fecha']==""){
                                           $fecha = date('Y-m-d');
                                       }else{
                                         $fecha = $_POST['fecha'];
                                       }
                                   }else{
                                     $fecha = date('Y-m-d');
                                   }
                                   if(isset($_POST['fecha_final'])){
                                       if($_POST['fecha_final']==""){
                                           $fecha_final = date('Y-m-d');
                                       }else{
                                         $fecha_final = $_POST['fecha_final'];
                                       }
                                   }else{
                                     $fecha_final = date('Y-m-d');
                                   }
                                   
                                  
                                       if(isset($_POST['id_usuario'])){
                                       $ventas = $usuario->getCajaxUser($_POST['id_usuario'],$fecha,$fecha_final);
                                       $ventasg = $usuario->getCajaxUserxFecha($_POST['id_usuario'],$fecha,$fecha_final);
                                       }
                                   if( isset($_POST['id_usuario'])){
                                       
                                                   $contador = count($ventas);
                                                   $contadorf = count($ventasg);
                                        
                                         if($contador===0 || $contadorf===0){
                                             echo "<div class='alert alert-info' role='alert'>No hay ventas.</div>";
                                         }else{

                                          echo '<div id="myfirstchart" style="height: 250px;"></div>';
                                          echo "<script>
                                          new Morris.Line({
                                              // ID of the element in which to draw the chart.
                                              element: 'myfirstchart',
                                              // Chart data records -- each entry in this array corresponds to a point on
                                              // the chart.
                                              data: ";
                                              
                                         
                                              echo  json_encode($ventasg, JSON_NUMERIC_CHECK);  

                                              echo ",
                                              // The name of the data record attribute that contains x-values.
                                              xkey: 'fecha',
                                              // A list of names of data record attributes that contain y-values.
                                              ykeys: ['cantidad'],
                                              // Labels for the ykeys -- will be displayed when you hover over the
                                              // chart.
                                              labels: ['Importe']
                                            });
                                          </script>";
                                             echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Cliente</th>
                                                    <th>Vendedor</th>
                                                    <th>Tarjeta</th>
                                                    <th>Efectivo</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
                                         }
                                         
                                         for($c=0;$c<$contador;$c++){
                                                echo " <tr class='odd gradeX'>";
                                               echo "<td>".$ventas[$c]['id_venta']."</td>";
                                               echo "<td>".$ventas[$c]['cliente']."</td>";
                                               echo "<td>".$ventas[$c]['vendedor']."</td>";
                                               echo "<td>".$ventas[$c]['tarjeta']."</td>";
                                               echo "<td>".$ventas[$c]['efectivo']."</td>";
                                               echo "<td>".$ventas[$c]['suma']."</td>";
                                               echo " </tr>";
                                               $total = $total + $ventas[$c]['suma'];
                                               $total_efectivo = $total_efectivo + $ventas[$c]['efectivo'];
                                               $total_tarjeta = $total_tarjeta + $ventas[$c]['tarjeta']; 
                                         }
                                         
                                         
                                   }
                                   else {
                                   echo "<div class='alert alert-info' role='alert'>No hay ventas.</div>";
                                   }

                                   ?>
                                   
                                </tbody>
                            </table
                        </div>
                    </div>
        <label>
                                    <?php 
                            echo "<div style='font-weight:normal;' class='list-group' ><span class='list-group-item active'>Total: Q.". $total."</span>";
                            
                            ?>
        </label>

<?php  include("../footer.php"); ?>


