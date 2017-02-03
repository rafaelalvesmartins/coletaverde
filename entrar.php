<?php $BASE = __DIR__?>
<?php include_once("$BASE/php/common.php");?>

<?php
	require('/var/www/html/coletaverde/php/create_enderecos.php');
	require('/var/www/html/coletaverde/php/create_bairros.php') ;
	require('/var/www/html/coletaverde/php/create_logins.php') ;
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
  
	
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 wow bounceInLeft "> 
			 	 
				 <?php if(checkAccess()) :  ?>
					Seja Bem-Vindo! Você está logado!
					<meta http-equiv="refresh" content=1;url="http://35.162.13.179/coletaverde/editar_ong.php">
				  <?php endif; ?>

	</div>
</div>
				
  <?php printFooter();?>

  <?php printJavaLibrary();?>
  
  <script>
	
	$().ready(function() {

			$("#login-form").validate({
				lang: 'pt' 
			});
			
	});	
 </script>
	
	
  </body>
</html>