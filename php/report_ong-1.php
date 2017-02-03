<?php
	include_once('common.php');

	function printPageTitle(){
		echo 'Relatório motorista';
	}

	function printPageDescr(){
		echo '&nbsp;';
	}

	function printPageText(){
		echo '&nbsp;';
	}

	function printFilterBox(){
		
		if(isset($_POST['filter-column']))
			$filter_column = $_POST['filter-column'];
		else if(isset($_GET['cidade']))
			$filter_column = 'a2.cidade';
		else
			$filter_column = '';
		
		echo "
		<div class=\"row\">
		<div class=\"col-sm-12\">
			<div class=\"row\">
				<div class=\"col-sm-4 form-group\">
					<label>Pesquisa:</label>
					<input type=\"text\" class=\"form-control\" name=\"filter-term\" value=\"";if(isset($_POST["filter-term"])) echo $_POST['filter-term']; else if(isset($_GET['cidade'])) echo $_GET['cidade'];
					echo "\" maxlength=\"" . MAX_FILTER_LENGTH . "\" />
				</div>
				<div class=\"col-sm-4 form-group\">
					<label>Campo:</label>
					<select class=\"form-control\" name=\"filter-column\">
						<option value=\"a2.cidade\" "; if($filter_column=='a2.cidade') echo " selected=\"selected\""; echo " >Cidade</option>
						<option value=\"concat(a.nome, ' ', a.sobrenome)\" "; if($filter_column=="concat(a.nome, ' ', a.sobrenome)") echo " selected=\"selected\""; echo " >Nome</option>
						<option value=\"a2.estado\" "; if($filter_column=='a2.estado') echo " selected=\"selected\""; echo " >Estado</option>
						<option value=\"a.turno\" "; if($filter_column=='a.turno') echo " selected=\"selected\""; echo " >Turno</option>
					</select>
				</div>
				<div class=\"col-sm-4 form-group\">
					<input type=\"submit\" name=\"filter-button\" value=\"Pesquisar\" class=\"button\" />
				</div>
			</div>	
		</div>
	</div>
		";
	}

	function printActionButtons(){
		echo "<div class=\"actions-wrapper\">
			<a class=\"insertButton button\" href=\"create_motoristas-1.php\">Insert</a>
			<a class=\"updateButton button\" href=\"update_motoristas-1.php\">Edit</a>
			<a class=\"deleteButton button\" href=\"report_motoristas-1.php\">Delete</a>
		</div>";
	}

	function printFormAction(){
		echo "buscar_ong.php";
	}

	function deleteRecords($ids){
		global $conn;

		if (!$conn) {
			$_SESSION['error'] = "There is no connection to the database";
			return false;
		}
		try {
			$query= sprintf("DELETE FROM public.motoristas WHERE id IN (%s)", implode("," , $ids ) );
			$count = $conn->exec($query);
				return $count  > 0;
		} catch(PDOException $e){
			$_SESSION['error'] = "There was a problem when deleting the data";
			return false;
		}
	}

	function pageOperation(){
	
		unset($_SESSION['selected']); //clears any selected value 
		$column_order = isset($_POST['column_order']) ? $_POST['column_order'] : 'a.id';
		$order = isset($_POST['order']) ? $_POST['order'] : 'ASC';
		$offset = isset($_POST["offset"]) ? $_POST["offset"] : RESULTS_START;
		echo "<input type=\"hidden\" name=\"column_order\" value=\"{$column_order}\"  id=\"column_order\" />
			<input type=\"hidden\" name=\"order\" value=\"{$order}\"  id=\"order\" />
			<input type=\"hidden\" name=\"offset\" value=\"{$offset}\"  id=\"offset\" />
				";


		global $conn;
		$extra_sql=" WHERE 1=1";
	
		
		if(isset($_POST["filter-term"])&& isset($_POST['filter-column'])){
			if(!empty($_POST["filter-term"]) && !empty($_POST['filter-column'])){
				$extra_sql.= sprintf(" AND CAST(%s  AS VARCHAR) ILIKE :term", $_POST['filter-column']);
				$term = '%'.$_POST["filter-term"] . '%';
			}
			else
				$term = NULL;
		}
		 else if(isset($_GET['cidade'])){
			$extra_sql.= sprintf(" AND CAST(%s  AS VARCHAR) ILIKE :term", 'a2.cidade');
			$term = '%'.$_GET['cidade']. '%';
		} else
			$term = NULL;
					
				
		$sql_count = "SELECT COUNT(*) FROM public.motoristas a 
				INNER JOIN logins a0  ON a.logins_id=a0.id  
				INNER JOIN enderecos a1  ON a.enderecos_id=a1.id 
				INNER JOIN bairros a2 ON a1.bairros_id=a2.id " . $extra_sql;
		
		
		
		if(isset($_POST["column_order"])){
			$extra_sql .= sprintf(" ORDER BY %s ", $_POST["column_order"]);
			$extra_sql .= $_POST["order"]=="ASC" ? " ASC" : " DESC";
		}

		$limit = isset($_POST["filter-limit"]) ? $_POST["filter-limit"] : RESULTS_LIMIT;
		
		

		if (isset($_POST['filter-button']))
			$offset = RESULTS_START;

		$offset = $limit * ($offset -1);
		$paginate_sql = " LIMIT :limit OFFSET :offset";

		if (!$conn) {
			$_SESSION['error'] = "Erro ao conectar com o banco de dados";
			exit;
		}

		try {
			$query = $conn->prepare("SELECT concat(a.nome, ' ', a.sobrenome) as nomecompleto, a2.cidade, a2.estado, a.turno, a0.email, a.telefone, a.celular
				FROM public.motoristas a 
				INNER JOIN logins a0  ON a.logins_id=a0.id  
				INNER JOIN enderecos a1  ON a.enderecos_id=a1.id 
				INNER JOIN bairros a2 ON a1.bairros_id=a2.id " . $extra_sql . $paginate_sql);
			
		
			
			
			$query_count = $conn->prepare($sql_count);
			

			if(!empty($term)){
				$query->bindParam(":term",$term, PDO::PARAM_STR);
				$query_count->bindParam(":term",$term, PDO::PARAM_STR);
			}
			
			
			$query->bindParam(":limit", $limit, PDO::PARAM_INT);
			$query->bindParam(":offset", $offset, PDO::PARAM_INT);
			
		
			
			$query->execute();
			$query_count->execute();
			$rows = $query_count->fetchColumn();
		} catch(PDOException $e){
			$_SESSION['error'] = "Houve um erro ao executar a consulta";
			exit;
		}

		
		
		echo "
		
		
		<div class=\"container\">
			<div class=\"row\">


				<div class=\"col-md-12\"><h1 class=\"well\">Pesquisar ONG</h1>";
				printFilterBox(); //Filter results
				echo "
				<div class=\"table-responsive\">


					<table id=\"results\" class=\"table table-bordred table-striped\">

						<thead>
						   	<th><a rel=\"nomecompleto\" ";
		if(isset($_REQUEST['column_order']))
			if($_REQUEST['column_order'] == 'nomecompleto')
				echo "class=\"" . strtolower($_REQUEST['order']) . "\"";
				echo ">Nome</a></th>
						   	<th><a rel=\"cidade\" ";
		if(isset($_REQUEST['column_order']))
			if($_REQUEST['column_order'] == 'cidade')
				echo "class=\"" . strtolower($_REQUEST['order']) . "\"";
				echo ">Cidade</a></th>
						   	<th><a rel=\"estado\" ";
		if(isset($_REQUEST['column_order']))
			if($_REQUEST['column_order'] == 'estado')
				echo "class=\"" . strtolower($_REQUEST['order']) . "\"";
				echo ">Estado</a></th>
						   	<th>Turno</th>
						   	<th>Email</th>
							<th>Telefone</th>
							<th>Celular</th>
						</thead>
						<tbody>
						";
		
		
		if(!$rows)
			echo "<tr><td>Nenhum registro foi encontrado.</td></tr>";

		while ($row = $query->fetch()){
			echo "	<tr>";
			for($i=0;$i<7;$i++)
				echo "<td>".htmlspecialchars($row[$i])."</td>";
			echo "</tr>";
		}
		echo "</tbody></table>";
		printRowsRadios();
		printPagination($rows,$limit);
		
		echo
				'</div>

			</div>
		</div>
	</div>';
}
?>


<form action="<?php printFormAction() ?>" id="operation-form" name="operation-form" method="post">
 
        <?php pageOperation() ?>
		
</form>


