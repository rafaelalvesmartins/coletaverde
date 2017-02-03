<?php	

	function printPageTitleMotoristas(){
		echo 'Criar motoristas';
	}

	function printPageDescrMotoristas(){
		echo '&nbsp;';
	}

	function printPageTextMotoristas(){
		echo '&nbsp;';
	}

	function insertRecordMotoristas(){
		
		global $conn;
		if (!$conn) {
			$_SESSION['error'] = "There is no connection to the database.";
			exit;
		}
		
		$stmt = $conn->query("select max(id) from logins");
		$lastId = $stmt->fetch(PDO::FETCH_NUM);
		$lastId = $lastId[0];
		
		$_POST["logins_id"] = $lastId;
		
		$stmt = $conn->query("select max(id) from enderecos");
		$lastId = $stmt->fetch(PDO::FETCH_NUM);
		$lastId = $lastId[0];

		$_POST["enderecos_id"] = $lastId;

		if(!isset($_POST["nome"]))
			$_POST["nome"] = '';

		if(!isset($_POST["sobrenome"]))
			$_POST["sobrenome"] = '';

		if(!isset($_POST["telefone"]))
			$_POST["telefone"] = '';

		if(!isset($_POST["celular"]))
			$_POST["celular"] = '';

		if(!isset($_POST["cnpj"]))
			$_POST["cnpj"] = '';

		if(!isset($_POST["cnh"]))
			$_POST["cnh"] = '';

		if(!isset($_POST["turno"]))
			$_POST["turno"] = '';

		


		// Test
		
		
		
		try {
			$query = $conn->prepare(
			"INSERT INTO public.motoristas (logins_id,enderecos_id,nome,sobrenome,telefone,celular,cnpj,cnh,turno) 
				VALUES (:logins_id,
				:enderecos_id,
				:nome,
				:sobrenome,
				:telefone,
				:celular,
				:cnpj,
				:cnh,
				:turno
				)");

			$query->bindParam(':logins_id', $_POST["logins_id"]);
			$query->bindParam(':enderecos_id', $_POST["enderecos_id"]);
			$query->bindParam(':nome', $_POST["nome"]);
			$query->bindParam(':sobrenome', $_POST["sobrenome"]);
			$query->bindParam(':telefone', $_POST["telefone"]);
			$query->bindParam(':celular', $_POST["celular"]);
			$query->bindParam(':cnpj', $_POST["cnpj"]);
			$query->bindParam(':cnh', $_POST["cnh"]);
			$query->bindParam(':turno', $_POST["turno"]);
			$rs = $query->execute();
		} catch (Exception $e) {
			$rs = NULL;
		}
		if (!$rs) {
			
			$arr = $query->errorInfo();
			print_r($arr);
			echo $_POST["telefone"];
			$_SESSION['error'] = "Houve um erro ao adicinar o motorista. Informe o erro aos responsáveis";
			return(false);

		} else {
			
			$_SESSION['msg'] = "As informações foram adicionadas com sucesso";
			$_POST['logins_id'] = '';
			$_POST['enderecos_id'] = '';
			$_POST['nome'] = '';
			$_POST['sobrenome'] = '';
			$_POST['telefone'] = '';
			$_POST['celular'] = '';
			$_POST['cnpj'] = '';
			$_POST['cnh'] = '';
			$_POST['turno'] = '';
			return true;
		}
	}

	function printFKOptionsMotoristas($schema,$table,$pk,$field,$selected_pk){
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

	function clearVarsMotoristas($val){
		return ($val == '' || $val == NULL) ? "NULL" : "'{$val}'";
	}

	function printFormActionMotoristas(){

		if(basename($_SERVER['PHP_SELF']) =='cadastro_motorista.php')
			echo "cadastro_motorista.php";
		else if(basename($_SERVER['PHP_SELF']) =='editar_motorista.php')
			echo "editar_motorista.php";
			
	}

	function printActionButtonsMotoristas(){
		echo "<div class=\"actions-wrapper create\">
			<input  type=\"submit\" name=\"insertButton\" value=\"Enviar\" class=\"button\" />
		</div>";
	}

	function returnMotoristaIDfromLoginID($loginID)
	{
		global $conn;

		if (!$conn) { 
			$_SESSION['error'] = "There is no connection to the database";
			exit;
		}

		try {
			$query = $conn->prepare("select motoristas.id as motoristas_id from logins inner join motoristas on logins.id = motoristas.logins_id where logins.id = $loginID");
			$rs = $query->execute();
		} catch (Exception $e) {
			$rs = NULL;
		}

		if (!$rs) {
			$_SESSION['error'] = "There was a problem when executing the query";
			exit;
		}
		$row = $query->fetch();
		return $row['motoristas_id'];
	}

	function updateRowMotorista($id){
		global $conn;

		$columns = array('nome','sobrenome','telefone','celular','cnpj','cnh','turno');
		$fieldName = array('nome','sobrenome','telefone','celular','cnpj','cnh','turno');
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

		$query = $conn->prepare(sprintf("UPDATE public.motoristas SET " . implode(',',$sql_set) . " WHERE id = '%s'",$id));


		$rs = $query->execute($params);
		if (!$rs)
			$_SESSION['error'] = "There was a problem when editing the information.";

		return $rs;
	}

	function updateMotorista($loginID)
	{
		$index = returnMotoristaIDfromLoginID($loginID);
		
		$success= updateRowMotorista($index);
		
		if($success) {
			$_SESSION['msg'] = "Editado com sucesso.";
			unset($_POST["nome"]);
			unset($_POST["sobrenome"]);
			unset($_POST["telefone"]);
			unset($_POST["celular"]);
			unset($_POST["cnpj"]);
			unset($_POST["cnh"]);
			unset($_POST["turno"]);
			
			return true;
			
		} else {
			$_SESSION['error'] = "Houve um problema ao editar o motorista.";
			return false;
		}
		
	

	}

	function returnMotoristaDBRow($motoristaID)
	{
			global $conn;
			if (!$conn) {
				$_SESSION['error'] = "There is no connection to the database.";
				exit;
			}


			try {
				$query = $conn->prepare("SELECT nome, sobrenome, telefone, celular, cnpj, cnh, turno
					FROM public.motoristas a  WHERE a.id=:id");
				$query->bindParam(":id", $motoristaID);
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


	function restoreDB2PostMotorista($loginID)
	{

		$motoristaID = returnMotoristaIDfromLoginID($loginID);
		$row = returnMotoristaDBRow($motoristaID);
		
		$_POST["nome"] = isset( $_POST["nome"] ) ? $_POST["nome"] : $row["nome"] ;
		$_POST["sobrenome"] = isset( $_POST["sobrenome"] ) ? $_POST["sobrenome"] : $row["sobrenome"] ;
		$_POST["telefone"] = isset( $_POST["telefone"] ) ? $_POST["telefone"] : $row["telefone"] ;
		
		$_POST["celular"] = isset( $_POST["celular"] ) ? $_POST["celular"] : $row["celular"] ;
		$_POST["cnpj"] = isset( $_POST["cnpj"] ) ? $_POST["cnpj"] : $row["cnpj"] ;
		$_POST["cnh"] = isset( $_POST["cnh"] ) ? $_POST["cnh"] : $row["cnh"] ;
		$_POST["turno"] = isset( $_POST["turno"] ) ? $_POST["turno"] : $row["turno"] ;
	}

	function pageOperationMotoristas(){
	
		if(!isset($_POST["logins_id"]))
			$_POST["logins_id"] = '';

		if(!isset($_POST["enderecos_id"]))
			$_POST["enderecos_id"] = '';
		
		if(isset($_GET['nome']))
			$_POST["nome"] = $_GET["nome"];
		else if(!isset($_POST["nome"]))
			$_POST["nome"] = '';

		if(isset($_GET['sobrenome']))
			$_POST["sobrenome"] = $_GET["sobrenome"];
		else if(!isset($_POST["sobrenome"]))
			$_POST["sobrenome"] = '';

		if(!isset($_POST["telefone"]))
			$_POST["telefone"] = '';

		if(!isset($_POST["celular"]))
			$_POST["celular"] = '';

		if(!isset($_POST["cnpj"]))
			$_POST["cnpj"] = '';

		if(!isset($_POST["cnh"]))
			$_POST["cnh"] = '';

		if(!isset($_POST["turno"]))
			$_POST["turno"] = '';

		
		
		
						
		
		
		echo "
			
			<input type=\"hidden\" name=\"operation\" value=\"insertUpdate\" />
			<input type=\"hidden\" name=\"page_insert_table\" value=\"motoristas\" />
			
			<div class=\"row\">
				<div class=\"col-sm-6 form-group\">
					<label>Nome</label>
					<input type=\"text\" placeholder=\"Entre com o nome da ONG aqui..\" class=\"form-control\" name=\"nome\"  id=\"nome\" required rangelength=\"[2, 100]\" value=\"".$_POST['nome']."\">
				</div>
				<div class=\"col-sm-6 form-group\">
					<label>Sigla</label>
					<input type=\"text\" placeholder=\"Entre com a sigla da ONG aqui..\" class=\"form-control\" name=\"sobrenome\"  id=\"column-3\"  required  rangelength=\"[2,100]\" value=\"".$_POST['sobrenome']."\">
				</div>
			</div>	
			
			<div class=\"row\">
				<div class=\"col-sm-6 form-group\">
					<label>Telefone</label>
					<input type=\"text\" placeholder=\"Entre com o telefone aqui..\" class=\"form-control\" class=\"form-control\" name=\"telefone\"  id=\"telefone\"  required class=\"telefone\" value=\"".$_POST['telefone']."\">
				</div>
				<div class=\"col-sm-6 form-group\">
					<label>Celular</label>
					<input type=\"text\" placeholder=\"Entre com o celular aqui..\" class=\"form-control\" name=\"celular\"  id=\"celular\" class=\"telefone\"  required value=\"".$_POST['celular']."\">
				</div>
			</div>	
			
			<div class=\"row\">
				<div class=\"col-sm-6 form-group\">
					<label>CNPJ</label>
					<input type=\"text\" placeholder=\"Entre com o CNPJ aqui..\" class=\"form-control\" name=\"cnpj\"  id=\"cnpj\"   rangelength=\"[18, 18]\" value=\"".$_POST['cnpj']."\">
				</div>
				<div class=\"col-sm-6 form-group\">
					<label>Licença da prefeitura</label>
					<input type=\"text\" placeholder=\"Entre com a licença da prefeitura aqui..\" class=\"form-control\" name=\"cnh\"  id=\"cnh\"  rangelength=\"[5, 50]\" value=\"".$_POST['cnh']."\">
				</div>
			</div>	
			
			<div class=\"row\">
				<div class=\"col-sm-6 form-group\">
					<label>Horário de funcionamento</label>
					
					<select name=\"turno\" class=\"form-control\" name=\"turno\"  id=\"turno\"  required>";
						$turnos = array('','Manhã','Tarde','Noite','Manhã e Tarde','Manhã e Noite','Tarde e Noite','Manhã, Tarde e Noite');
						foreach($turnos as $turno)
						{
							if($_POST['turno'] == $turno)
								echo "<option value=\"$turno\" selected>$turno</option>";
							else 
								echo "<option value=\"$turno\">$turno</option>";
						}
					echo "</select>
					
					
				</div>
				<div class=\"col-sm-6 form-group\">
					&nbsp;
				</div>
			</div>	
						
		";
}
 		
         
             				
function printMotoristaForm()
    {
	echo '
   <div class="col-lg-12 well">
			<div class="row">
				<form action="'; printFormActionMotoristas(); echo '"  id="operation-form" name="operation-form" method="post">
				   <div class="col-sm-12">';
						 
						
						pageOperationMotoristas();
						pageOperationEnderecos();
						pageOperationBairros(); 
						pageOperationLogins();
			
						
						printActionButtonsMotoristas();
						
						echo '	
						<!--<h3 align="center">Todos os campos marcados com * são obrigatórios.</h3>-->
					</div>
				</form> 	
			</div>
		</div>
   ';
    }
     

?>
   
		