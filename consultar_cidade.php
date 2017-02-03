<?php
include_once('/var/www/html/byvan/php/common.php');
#Verifica se tem um email para pesquisa
if(isset($_POST['cidade'])){ 


	$cidade = $_POST['cidade'];

	#Conecta banco de dados 
	global $conn;
	if (!$conn) {
		$_SESSION['error'] = "There is no connection to the database.";
		exit;
	}

	$coluna_cidade = "a2.cidade";

	$extra_sql=" WHERE 1=1";

	$extra_sql.= sprintf(" AND CAST(%s  AS VARCHAR) ILIKE :term", $coluna_cidade);	
	
	$limit_sql = " LIMIT :limit";

	$query = $conn->prepare("SELECT DISTINCT ON(cidade)  cidade
					FROM public.motoristas a 
					INNER JOIN enderecos a1  ON a.enderecos_id=a1.id 
					INNER JOIN bairros a2 ON a1.bairros_id=a2.id " . $extra_sql.$limit_sql);

	$term = '%'.$cidade . '%';
	$limit = 5;

	$query->bindParam(":term",$term, PDO::PARAM_STR);
	$query->bindParam(":limit",$limit, PDO::PARAM_INT);

	$query->execute();
	
	while ($row = $query->fetch(PDO::FETCH_ASSOC)){
		 $dados[] = (string) $row['cidade'];
		//echo "<option value=\"".htmlspecialchars($row['cidade'])."\">";
	}
	
	
     echo json_encode($dados);
}
 
// Acentuação
header("Content-Type: text/html; charset=ISO-8859-1",true);
?>