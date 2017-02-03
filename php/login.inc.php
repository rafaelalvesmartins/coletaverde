<?php
	
    $user = isset($_POST['crudgen_user']) ? $_POST['crudgen_user'] : '';
    $passwd = isset($_POST['crudgen_passwd']) ? $_POST['crudgen_passwd'] : '';
?>

  <div class="container">   
   		<?php printMessages();?>    
    	<h1 class="well">Faça login</h1>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 well">
			<div class="row">
				 <form action="" id="login-form" method="post">
				 	
				 	<div class="row"> 
				 		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<div class="col-lg-12">
								<div class="row">
									<label for="crudgen_user">Email</label>
									<input type="text" id="crudgen_user" name="crudgen_user" value="<?php echo $user ?>" class="form-control"  email="true" required/>
								</div>
							 </div>
							<div class="col-lg-12">
								<div class="row">
									<label for="crudgen_password">Senha</label>
									<input type="password" id="crudgen_passwd" name="crudgen_passwd" value="<?php echo $passwd ?>" class="form-control" required  rangelength="[6, 15]"/>
								</div>
							</div> 
							<div class=\"actions-wrapper create\">
								<input type="submit" name="button-send" value="Login" class="button"/>
							</div>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
						</div>
					 </div>
				</form>
			</div>
	  </div>
</div>