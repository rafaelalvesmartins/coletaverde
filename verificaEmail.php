<?php
include_once('/var/www/html/coletaverde/php/common.php');
#Verifica se tem um email para pesquisa
if(isset($_POST['email'])){ 

    #Recebe o Email Postado
    $emailPostado = $_POST['email'];

    #Conecta banco de dados 
	global $conn;
	if (!$conn) {
		$_SESSION['error'] = "There is no connection to the database.";
		exit;
	}
	
	$stmt = $conn->query("select count(motoristas.id) as quant from motoristas left join logins on motoristas.logins_id = logins.id where email =  '{$emailPostado}'");
	$quantRegis = $stmt->fetch(PDO::FETCH_NUM);
	$quantRegis = $quantRegis[0];
	
	
 	
  	$dados['quant'] = $quantRegis;
    if($quantRegis>0) {
		$dados['email'] = (string) 'Ja existe um usuario cadastrado com este email.';
	}
        
    else {
		$dados['email'] = (string) 'Usuario valido.';
	}
		
        echo json_encode($dados);
}
?>