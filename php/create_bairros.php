<?php
	include_once('/var/www/html/coletaverde/php/common.php');

	function printPageTitleBairros(){
		echo 'Criar bairro';
	}

	function printPageDescrBairros(){
		echo '&nbsp;';
	}

	function printPageTextBairros(){
		echo '&nbsp;';
	}

	function insertRecordBairros(){
		
		global $conn;
		if (!$conn) {
			$_SESSION['error'] = "There is no connection to the database.";
			exit;
		}
		
		if(!isset($_POST["bairro"]))
			$_POST["bairro"] = '';

		if(!isset($_POST["cidade"]))
			$_POST["cidade"] = '';

		if(!isset($_POST["estado"]))
			$_POST["estado"] = '';


		try {
			$query = $conn->prepare(
			"INSERT INTO public.bairros (nome,cidade, estado) 
				VALUES (:nome,
				:cidade,
				:estado)");

			$query->bindParam(':nome', $_POST["bairro"]);
			$query->bindParam(':cidade', $_POST["cidade"]);
			$query->bindParam(':estado', $_POST["estado"]);
			
			$rs = $query->execute();
			
			
			
		} catch (Exception $e) {
			$rs = NULL;
		}
		if (!$rs) {
			$arr = $query->errorInfo();
			//print_r($arr);
			$_SESSION['error'] = "Houve um erro ao adicinar o motorista. Informe o erro aos responsáveis";
			return false;
		} else {
			
			$_SESSION['msg'] = "As informações foram adicionadas com sucesso";
			$_POST['bairro'] = '';
			$_POST['cidade'] = '';
			$_POST['estado'] = '';
			return true;
		}
	}

	function printFKOptionsBairros($schema,$table,$pk,$field,$selected_pk){
		global $conn;

		if (!$conn) { 
			$_SESSION['error'] = "There is no connection to the database";
			exit;
		}

		try {
			$query = $conn->prepare(sprintf("SELECT %s,%s  FROM %s.%s", $pk, $field, $schema, $table));
			$rs = $query->execute();
		} catch (Exception $e) {
			$rs = NULL;
		}

		if (!$rs) {
			
			$arr = $query->errorInfo();
			$_SESSION['error'] = "Houve um erro ao adicinar o bairro. Informe o erro aos responsáveis: ".print_r($arr);
			exit;
		}
		while ($row = $query->fetch()){
			echo "<option value=\"{$row[0]}\"";
			if($row[0] == $selected_pk) echo " selected=\"selected\"";
			echo ">{$row[1]}</option>";
		};
	}

	function clearVarsBairros($val){
		return ($val == '' || $val == NULL) ? "NULL" : "'{$val}'";
	}

	function printFormActionBairros(){

		echo "create_bairros.php";
	}

	function printActionButtonsBairros(){
		echo "<div class=\"actions-wrapper create\">
			<input type=\"submit\" name=\"insertButton\" value=\"Save\" />
			<a class=\"reportButton button\" href=\"report_bairros.php\">Cancel</a>
		</div>";
	}

	function returnBairroIDfromLoginID($loginID)
	{
		global $conn;

		if (!$conn) { 
			$_SESSION['error'] = "There is no connection to the database";
			exit;
		}

		try {
			$query = $conn->prepare("select bairros.id as bairro_id from logins inner join motoristas on logins.id = motoristas.logins_id inner join enderecos on motoristas.enderecos_id = enderecos.id inner join bairros on enderecos.bairros_id = bairros.id where logins.id = $loginID");
			$rs = $query->execute();
		} catch (Exception $e) {
			$rs = NULL;
		}

		if (!$rs) {
			$_SESSION['error'] = "There was a problem when executing the query";
			exit;
		}
		$row = $query->fetch();
		return $row['bairro_id'];
	}

	function updateRowBairro($id){
		global $conn;

		$columns = array('nome','cidade','estado');
		$fieldName = array('bairro', 'cidade', 'estado');
		$sql_set = array();
		$params = array();

		foreach($columns as $key => $column){
			if($_POST[$column] == "")
				$sql_set[] = "{$column} = NULL";
			else{
				$sql_set[] = "{$column} = ?";
				$params[] = $_POST[$fieldName[$key]];
			}
		}

		if (!$conn ) {
			$_SESSION['error'] = "There is no connection to the database.";
			exit;
		}

		$query = $conn->prepare(sprintf("UPDATE public.bairros SET " . implode(',',$sql_set) . " WHERE id = '%s'",$id));
		

		$rs = $query->execute($params);
		if (!$rs)
			$_SESSION['error'] = "There was a problem when editing the information.";

		return $rs;
	}

	function updateBairro($loginID)
	{
		$index = returnBairroIDfromLoginID($loginID);
		

		
		$success= updateRowBairro($index);
		if($success) {
			$_SESSION['msg'] = "Bairro editado com sucesso.";
			unset($_POST["bairro"]);
			unset($_POST["estado"]);
			unset($_POST["cidade"]);
			return true;
			
		} else {
			$_SESSION['error'] = "Houve um problema ao editar o bairro.";
			return false;
		}
		
	

}

function returnBairroDBRow($bairroID)
{
		global $conn;
		if (!$conn) {
			$_SESSION['error'] = "There is no connection to the database.";
			exit;
		}
		
		
		try {
			$query = $conn->prepare("SELECT a.nome, a.cidade, a.estado
				FROM public.bairros a  WHERE a.id=:id");
			$query->bindParam(":id", $bairroID);
			$rs = $query->execute();
			
		} catch (Exception $e) {
			$rs = NULL;
		}
		if (!$rs){
			$_SESSION['error'] = "Houve um problema ao executar a consulta.";
			exit;
		}
		$row = $query->fetch(PDO::FETCH_ASSOC);
		return $row;
}


function restoreDB2PostBairro($loginID)
{
	
	$bairroID = returnBairroIDfromLoginID($loginID);
	$row = returnBairroDBRow($bairroID);
	$_POST["bairro"] = isset( $_POST["bairro"] ) ? $_POST["bairro"] : $row["nome"] ;
	$_POST["cidade"] = isset( $_POST["cidade"] ) ? $_POST["cidade"] : $row["cidade"] ;
	$_POST["estado"] = isset( $_POST["estado"] ) ? $_POST["estado"] : $row["estado"] ;
}
	

	function pageOperationBairros(){
	
		if(!isset($_POST["bairro"]))
			$_POST["bairro"] = '';

		
		if(!isset($_POST["estado"]))
			$_POST["estado"] = '';
		
			
		
		// Get used when is loging on facebook
		/*if(isset($_GET['cidade']))
			$_POST["cidade"] = $_GET["cidade"];
		else if(!isset($_POST["cidade"]))
			$_POST["cidade"] = '';*/
		
		if(!isset($_POST["cidade"]))
			$_POST["cidade"] = '';
					

		echo "
		
		<div class=\"row\">
			<div class=\"col-sm-4 form-group\">
				<label>Bairro</label>
				<input type=\"text\" placeholder=\"Entre com o bairro aqui..\" class=\"form-control\" name=\"bairro\"  id=\"bairro\" value=\"{$_POST["bairro"]}\" required  rangelength=\"[2, 100]\">
			</div>	
			<div class=\"col-sm-4 form-group\">
				<label>Estado</label>
				<select name=\"estado\" id=\"estado\" class=\"form-control\" required>
					<option value=\"\"></option>
				</select>
			</div>	
			<div class=\"col-sm-4 form-group\">
				<label>Cidade</label>
				<select name=\"cidade\" id=\"cidade\" class=\"form-control\" required>
				</select>
				
			</div>		
		</div>
		
		";
}
?>


