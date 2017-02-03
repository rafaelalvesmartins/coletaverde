<?php $BASE = __DIR__?>

<?php include_once("$BASE/php/common.php");?>

<?php
require("$BASE/php/create_enderecos.php");
require("$BASE/php/create_bairros.php") ;
?>


<!DOCTYPE html>
<html lang="pt">
  <head>
   <?php printHead($BASE);?>
  </head>
<body>
     
  <?php
	
	  printPreLoader();

	  printNavbar();

	  printSliderSection();
  ?>
  
	<section id="howWorks">
     <div class="container">
      <div class="row">
          <div class="howworks_area">
            <div class="client_title">
                <hr>
                
            </div>
                <div class="row">
                     <div class="col-lg-12 col-md-12 col-sm-12 wow bounceInLeft ">  
                           	
                            <h2>
                               <div class="container">       
    							<h1 class="well">Cadastro de doação</h1>
                               
                               
                               <div class="col-lg-12 well">
									<div class="row">
										<form action=""  id="operation-form" name="operation-form" method="post">
										   <div class="col-sm-12">
										   
										   
										   
																		   <input type="hidden" name="operation" value="insertUpdate" />
											<input type="hidden" name="page_insert_table" value="motoristas" />

											<div class="row">
												<div class="col-sm-6 form-group">
													<label>Item</label>
													<input type="text" placeholder="Entre com a descrição do item a ser doado aqui.." class="form-control" name="nome"  id="nome" required rangelength="[2, 100]" value="".$_POST['nome']."">
												</div>
												<div class="col-sm-6 form-group">
													<label>Quantidade</label>
													<input type="text" placeholder="Entre com a quantidade do item a ser doado aqui.." class="form-control" name="sobrenome"  id="column-3"  required  rangelength="[2,100]" value="".$_POST['sobrenome']."">
												</div>
											</div>	

											<div class="row">
												<div class="col-sm-6 form-group">
													<label>Telefone</label>
													<input type="text" placeholder="Entre com o telefone aqui.." class="form-control" class="form-control" name="telefone"  id="telefone"  required class="telefone" value="".$_POST['telefone']."">
												</div>
												<div class="col-sm-6 form-group">
													<label>Celular</label>
													<input type="text" placeholder="Entre com o celular aqui.." class="form-control" name="celular"  id="celular" class="telefone"  required value="".$_POST['celular']."">
												</div>
											</div>	


											<div class="row">
												<div class="col-sm-6 form-group">
													<label>Turno para retirar o item</label>

													<select name="turno" class="form-control" name="turno"  id="turno"  required>";
														<?php $turnos = array('','Manhã','Tarde','Noite','Manhã e Tarde','Manhã e Noite','Tarde e Noite','Manhã, Tarde e Noite');
														foreach($turnos as $turno)
														{
															if($_POST['turno'] == $turno)
																echo "<option value=\"$turno\" selected>$turno</option>";
															else 
																echo "<option value=\"$turno\">$turno</option>";
														}
													?>
													</select>

													
												</div>
												
												<?php
													pageOperationEnderecos();
													pageOperationBairros();
												?>
												
												<div class="col-sm-6 form-group">
													&nbsp;
												</div>
												
												
												<div class="row">
												<div class="col-sm-12 form-group">
													<label>ONG escolhida para doação</label>

													<select name="turno" class="form-control" name="turno"  id="turno"  required>";
														<?php 
															global $conn;
															$query = $conn->prepare("SELECT concat(a.nome, ' ', a.sobrenome) as nomecompleto
															FROM public.motoristas a ");



															$query->execute();
															
															while ($row = $query->fetch()){
																	echo "<option value=\"$row[0]\">$row[0]</option>";
															}
																
													?>
													</select>

													
												</div>
												
												
												
											</div>	
									   		
									   		<div class="actions-wrapper create">
												<input  type="submit" name="insertButton" value="Enviar" class="button" />
											</div>
										   

											</div>
										</form> 	
									</div>
								</div>
                       		</div>
                        </h2>
                    </div>      
                </div>
              </div>
          </div>
        </div>
  </section>


  <?php printFooter();?>

  <?php printJavaLibrary();?>
  
  <?php require('js/jsmotorista.js'); ?>
  
  
  </body>
</html>