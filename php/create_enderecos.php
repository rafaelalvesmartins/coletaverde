<?php
	include_once('/var/www/html/coletaverde/php/common.php');

	function printPageTitleEnderecos(){
		echo 'Criar endereço';
	}

	function printPageDescrEnderecos(){
		echo '&nbsp;';
	}

	function printPageTextEnderecos(){
		echo '&nbsp;';
	}

	function insertRecordEnderecos(){
		

		global $conn;
		if (!$conn) {
			$_SESSION['error'] = "There is no connection to the database.";
			exit;
		}

		$stmt = $conn->query("select max(id) from bairros");
		$lastId = $stmt->fetch(PDO::FETCH_NUM);
		$lastId = $lastId[0];
		
		$_POST["bairros_id"] = $lastId;

		if(!isset($_POST["endereco"]))
			$_POST["endereco"] = '';

		if(!isset($_POST["numero"]))
			$_POST["numero"] = '';

		if(!isset($_POST["cep"]))
			$_POST["cep"] = '';

		if(!isset($_POST["gps_lat"]))
			$_POST["gps_lat"] = 0.0;

		if(!isset($_POST["gps_lon"]))
			$_POST["gps_lon"] = 0.0;


		try {
			$query = $conn->prepare(
			"INSERT INTO public.enderecos (bairros_id,endereco,numero,cep,gps_lat,gps_lon) 
				VALUES (:bairros_id,
				:endereco,
				:numero,
				:cep,
				:gps_lat,
				:gps_lon)");

			$query->bindParam(':bairros_id', $_POST["bairros_id"]);
			$query->bindParam(':endereco', $_POST["endereco"]);
			$query->bindParam(':numero', $_POST["numero"]);
			$query->bindParam(':cep', $_POST["cep"]);
			$query->bindParam(':gps_lat', $_POST["gps_lat"]);
			$query->bindParam(':gps_lon', $_POST["gps_lon"]);
			$rs = $query->execute();
		} catch (Exception $e) {
			$rs = NULL;
		}
		if (!$rs) {
			
			$arr = $query->errorInfo();
			//print_r($arr);
			$_SESSION['error'] = "Houve um erro ao adicinar o endereço. Informe o erro aos responsáveis";
			return false;
		} else {
			$_SESSION['msg'] = "As informações foram adicionadas com sucesso";
			$_POST['bairros_id'] = '';
			$_POST['endereco'] = '';
			$_POST['numero'] = '';
			$_POST['cep'] = '';
			$_POST['gps_lat'] = 0.0;
			$_POST['gps_lon'] = 0.0;
			return true;
		}
	}

	function printFKOptionsEnderecos($schema,$table,$pk,$field,$selected_pk){
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
			$_SESSION['error'] = "There was a problem when executing the query";
			exit;
		}
		while ($row = $query->fetch()){
			echo "<option value=\"{$row[0]}\"";
			if($row[0] == $selected_pk) echo " selected=\"selected\"";
			echo ">{$row[1]}</option>";
		};
	}

	function clearVarsEnderecos($val){
		return ($val == '' || $val == NULL) ? "NULL" : "'{$val}'";
	}

	function printFormActionEnderecos(){

		echo "create_enderecos.php";
	}

	function printActionButtonsEnderecos(){
		echo "<div class=\"actions-wrapper create\">
			<input type=\"submit\" name=\"insertButton\" value=\"Save\" />
			<a class=\"reportButton button\" href=\"report_enderecos.php\">Cancel</a>
		</div>";
	}

	function returnEnderecoIDfromLoginID($loginID)
	{
		global $conn;

		if (!$conn) { 
			$_SESSION['error'] = "There is no connection to the database";
			exit;
		}

		try {
			$query = $conn->prepare("select enderecos.id as endereco_id from logins inner join motoristas on logins.id = motoristas.logins_id inner join enderecos on motoristas.enderecos_id = enderecos.id  where logins.id = $loginID");
			$rs = $query->execute();
		} catch (Exception $e) {
			$rs = NULL;
		}

		if (!$rs) {
			$_SESSION['error'] = "There was a problem when executing the query";
			exit;
		}
		$row = $query->fetch();
		return $row['endereco_id'];
	}

	function updateRowEndereco($id){
		global $conn;

		$columns = array('endereco','numero','cep');
		$fieldName = array('endereco', 'numero', 'cep');
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

		$query = $conn->prepare(sprintf("UPDATE public.enderecos SET " . implode(',',$sql_set) . " WHERE id = '%s'",$id));


		$rs = $query->execute($params);
		if (!$rs)
			$_SESSION['error'] = "There was a problem when editing the information.";

		return $rs;
	}

	function updateEndereco($loginID)
	{
		$index = returnEnderecoIDfromLoginID($loginID);
		

		
		$success= updateRowEndereco($index);
		if($success) {
			$_SESSION['msg'] = "Endereço editado com sucesso.";
			unset($_POST["endereco"]);
			unset($_POST["numero"]);
			unset($_POST["cep"]);
			
			return true;
			
		} else {
			$_SESSION['error'] = "Houve um problema ao editar o endereço.";
			return false;
		}
		
	

	}

	function returnEnderecoDBRow($enderecoID)
	{
			global $conn;
			if (!$conn) {
				$_SESSION['error'] = "There is no connection to the database.";
				exit;
			}


			try {
				$query = $conn->prepare("SELECT a.endereco, a.numero, a.cep
					FROM public.enderecos a  WHERE a.id=:id");
				$query->bindParam(":id", $enderecoID);
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


	function restoreDB2PostEndereco($loginID)
	{
		$enderecoID = returnEnderecoIDfromLoginID($loginID);
		$row = returnEnderecoDBRow($enderecoID);
		$_POST["endereco"] = isset( $_POST["endereco"] ) ? $_POST["endereco"] : $row["endereco"] ;
		$_POST["numero"] = isset( $_POST["numero"] ) ? $_POST["numero"] : $row["numero"] ;
		$_POST["cep"] = isset( $_POST["cep"] ) ? $_POST["cep"] : $row["cep"] ;
		
		
	}

	function pageOperationEnderecos(){
	

		if(!isset($_POST["endereco"]))
			$_POST["endereco"] = '';

		if(!isset($_POST["numero"]))
			$_POST["numero"] = '';

		if(!isset($_POST["cep"]))
			$_POST["cep"] = '';

		if(!isset($_POST["gps_lat"]))
			$_POST["gps_lat"] = 0.0;

		if(!isset($_POST["gps_lon"]))
			$_POST["gps_lon"] = 0.0;

		
					

		echo "
		
		
		
		<div class=\"row\">
			<div class=\"col-sm-4 form-group\">
				<label>CEP</label>
				<input type=\"text\" placeholder=\"Entre com o CEP aqui..\" class=\"form-control\" name=\"cep\"  id=\"cep\" required  rangelength=\"[9, 9]\" value=\"{$_POST["cep"]}\">
			</div>	
			<div class=\"col-sm-4 form-group\">
				&nbsp;
			</div>	
			<div class=\"col-sm-4 form-group\">
				&nbsp;
			</div>		
		</div>
		
		
		
		<div class=\"form-group\">
			<label>Endereço</label>
			<textarea placeholder=\"Entre com o Endereço aqui..\" rows=\"3\" class=\"form-control\" name=\"endereco\"  id=\"endereco\"  required  rangelength=\"[2, 100]\" >{$_POST["endereco"]}</textarea>
		</div>	
		
		<div class=\"row\">
			<div class=\"col-sm-4 form-group\">
				<label>Número</label>
				<input type=\"text\" placeholder=\"Entre com o número aqui..\" class=\"form-control\" name=\"numero\"  id=\"numero\" required  rangelength=\"[1, 50]\" value=\"{$_POST["numero"]}\">
			</div>	
			<div class=\"col-sm-4 form-group\">
				&nbsp;
			</div>	
			<div class=\"col-sm-4 form-group\">
				&nbsp;
			</div>		
		</div>
		
			
			
		
		";
}
?>
