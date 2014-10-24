<?php 
	require_once './../../models/Agenda.php';

	$agenda = new Agenda();
 	$objAgenda = $agenda -> getEvents();
 	//$resultUser = array('id_usuario'=> $result['id_usuario'],'nombre'=>$result['nombre'], 'id_role'=>$result['id_role'],'role_name'=>$result['role_name']); 
 	//echo json_encode($resultUser);


?>
{
	"success": 1,
	"result": <?php echo json_encode($objAgenda); ?>
}
