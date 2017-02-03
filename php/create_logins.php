<?php
	include_once('/var/www/html/coletaverde/php/common.php');


	function printPageTitleLogins(){
		echo 'Criar login';
	}

	function printPageDescrLogins(){
		echo '&nbsp;';
	}

	function printPageTextLogins(){
		echo '&nbsp;';
	}

	function insertRecordLogins(){
		
		
		global $conn;
		if (!$conn) {
			$_SESSION['error'] = "There is no connection to the database.";
			exit;
		}

		if(!isset($_POST["email"]))
			$_POST["email"] = '';

		if(!isset($_POST["senha"]))
			$_POST["senha"] = '';
		$senhaHash = password_hash($_POST["senha"], PASSWORD_DEFAULT);


		if(!isset($_POST["facebook_login"]))
			$_POST["facebook_login"] = '';

		
		$_POST["created"] = date('Y-m-d H:i:s');
		$_POST["tipo_acesso"] = 'usuario';
		

		try {
			
			
			
			$query = $conn->prepare(
			"INSERT INTO public.logins (email,senha,tipo_acesso,facebook_login,created) 
				VALUES (:email,
				:senha,
				:tipo_acesso,
				:facebook_login,
				:created)");

			$query->bindParam(':email', $_POST["email"]);
			$query->bindParam(':senha', $senhaHash);
			$query->bindParam(':tipo_acesso', $_POST["tipo_acesso"]);
			$query->bindParam(':facebook_login', $_POST["facebook_login"]);
			$query->bindParam(':created', $_POST["created"]);
			$rs = $query->execute();
			
			
			
		} catch (Exception $e) {
			$rs = NULL;
		}
		if (!$rs) {
			$arr = $query->errorInfo();
			//print_r($arr);
			$_SESSION['error'] = "Houve um erro ao adicinar o login. Informe o erro aos responsáveis";
			return false;
		} else {
			$_SESSION['msg'] = "As informações foram adicionadas com sucesso";
			$_POST['email'] = '';
			$_POST['senha'] = '';
			$_POST['tipo_acesso'] = '';
			$_POST['facebook_login'] = '';
			$_POST['created'] = '';
			return true;
		}
	}

	function printFKOptionsLogins($schema,$table,$pk,$field,$selected_pk){
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
			//print_r($arr);
			$_SESSION['error'] = "Houve um erro ao adicinar o login. Informe o erro aos responsáveis";
			exit;
		}
		while ($row = $query->fetch()){
			echo "<option value=\"{$row[0]}\"";
			if($row[0] == $selected_pk) echo " selected=\"selected\"";
			echo ">{$row[1]}</option>";
		};
	}

	function clearVarsLogins($val){
		return ($val == '' || $val == NULL) ? "NULL" : "'{$val}'";
	}

	function printFormActionLogins(){

		echo "create_logins.php";
	}

	function printActionButtonsLogins(){
		echo "<div class=\"actions-wrapper create\">
			<input type=\"submit\" name=\"insertButton\" value=\"Save\" />
			<a class=\"reportButton button\" href=\"report_logins.php\">Cancel</a>
		</div>";
	}



	function updateRowLogin($id){
		global $conn;
		
		$columns = array('email','senha','facebook_login');
		$fieldName = array('email', 'senha', 'facebook_login');
		$sql_set = array();
		$params = array();
		$_POST['senha'] = password_hash($_POST["senha"], PASSWORD_DEFAULT);

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

		$query = $conn->prepare(sprintf("UPDATE public.logins SET " . implode(',',$sql_set) . " WHERE id = '%s'",$id));


		$rs = $query->execute($params);
		if (!$rs)
			$_SESSION['error'] = "There was a problem when editing the information.";

		return $rs;
	}

	function updateLogin($loginID)
	{
		
		
		$success= updateRowLogin($loginID);
		if($success) {
			$_SESSION['msg'] = "Login editado com sucesso.";
			unset($_POST["email"]);
			unset($_POST["senha"]);
			unset($_POST["facebook_login"]);
			return true;
			
		} else {
			$_SESSION['error'] = "Houve um problema ao editar o login.";
			return false;
		}
		
	

}

function returnLoginDBRow($loginID)
{
		global $conn;
		if (!$conn) {
			$_SESSION['error'] = "There is no connection to the database.";
			exit;
		}
		
		
		try {
			$query = $conn->prepare("SELECT a.email, a.facebook_login
				FROM public.logins a  WHERE a.id=:id");
			$query->bindParam(":id", $loginID);
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


function restoreDB2PostLogin($loginID)
{
	$row = returnLoginDBRow($loginID);
	$_POST["email"] = isset( $_POST["email"] ) ? $_POST["email"] : $row["email"] ;
	$_POST["facebook_login"] = isset( $_POST["facebook_login"] ) ? $_POST["facebook_login"] : $row["facebook_login"] ;
	
}

	function pageOperationLogins(){
		
	
		if(isset($_GET['email']))
			$_POST["email"] = $_GET["email"];
		else if(!isset($_POST["email"]))
			$_POST["email"] = '';

		if(!isset($_POST["senha"]))
			$_POST["senha"] = '';

		if(!isset($_POST["tipo_acesso"]))
			$_POST["tipo_acesso"] = '';

		if(isset($_GET['facebook_login']))
			$_POST["facebook_login"] = $_GET["facebook_login"];
		else if(!isset($_POST["facebook_login"]))
			$_POST["facebook_login"] = '';

		if(!isset($_POST["created"]))
			$_POST["created"] = '';

		
					

		echo "	
		
		<input type=\"hidden\" name=\"facebook_login\" value=\"".$_POST["facebook_login"]."\" />
		<div class=\"form-group\">
			<label>Email</label>
			<input type=\"text\" placeholder=\"Entre com o email aqui..\" class=\"form-control\" name=\"email\"  id=\"email\"   email=\"true\" required rangelength=\"[10, 100]\" value=\"".$_POST["email"]."\" >
			<div id='resposta' class='msg'></div>
		</div>	
		<div class=\"form-group\">
			<label>Senha</label>
			<input type=\"password\" placeholder=\"Entre com a senha aqui..\" class=\"form-control\" name=\"senha\"  id=\"senha\"  required  rangelength=\"[6, 15]\">
		</div>	
		<div class=\"form-group\">
			<label>Confirmar Senha</label>
			<input type=\"password\" placeholder=\"Confirme a senha aqui..\" class=\"form-control\" name=\"confirmarSenha\"  id=\"column-1\"  required  equalTo=\"#senha\" rangelength=\"[6, 15]\">
		</div>
		";
}
?>

