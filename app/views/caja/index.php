<?php  include("../header.php");
        require_once '../../models/Usuario.php';
        
        if(isset($_POST['todos']) || isset($_POST['id_usuario'])){
?>

<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>Cierre de caja </strong> realizado con exito.
</div>

        <?php } ?>
  <div class="col-lg-12">
        <h1 class="page-header">Cierre de Caja</h1>
   </div>


<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Realizar cierre de Caja
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
                               <label>
                              <input id="todos" name="todos" type="checkbox"> Todos los Usuarios
                            </label>
                               
                            <select id="id_usuario" name="id_usuario" class="form-control">
                                 <?php 
                            $contador_array = count($lista);
                             for($c=0;$c<$contador_array;$c++){
                                     ?>
                            <option value="<?php echo $lista[$c]['id_usuario'] ?>"><?php echo $lista[$c]['nombre'] ?></option>

                                <?php } ?>
                             </select>
                            <br>
                                <label> Fecha: </label>
                                    <input class="form-control" type="text" onclick="displayDatePicker('fecha');" name="fecha" readonly required="true"/> 
                                
                                 <br>
                            <button type="submit" class="btn btn-danger">Cierre De Caja</button>
                            </form>
                        </div>
                    </div>
                </div> 
    
    <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Reporte de Cierre: Ventas
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
                                   
                                   if(isset($_POST['todos'])){
                                       $ventas = $usuario->getCaja($fecha);
                                   }else{
                                       if(isset($_POST['id_usuario'])){
                                       $ventas = $usuario->getCajaxUser($_POST['id_usuario'],$fecha);
                                       }
                                   }
                                   
                                   if(isset($_POST['todos']) || isset($_POST['id_usuario'])){
                                       
                                                   $contador = count($ventas);
                                        
                                         if($contador===0){
                                             echo "<div class='alert alert-info' role='alert'>No hay ventas.</div>";
                                         }else{
                                             echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Cliente</th>
                                                    <th>Vendedor</th>
                                                    <th>Efectivo</th>
                                                    <th>Tarjeta</th>
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
                            echo "<span class='list-group-item active'>Total Efectivo: Q.". $total_efectivo."</span>";
                            echo "<span class='list-group-item active'>Total Tarjeta: Q.". $total_tarjeta."</span></div>";
                            
                            ?>
        </label>

<?php  include("../footer.php"); ?>


