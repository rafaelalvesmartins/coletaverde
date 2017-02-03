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
  
	<?php
		require_once "$BASE/php/report_ong-1.php";
	?>

  <?php printFooter();?>

  <?php printJavaLibrary();?>
	
	<script>
		$('a.pagination').on('click', function(){
			$('#offset').val($(this).attr('rel'));
			 document.getElementById("operation-form").submit();
			
		});	
		
		$('.limit-wrapper select').on('change', function(){
		$('#offset').val(1);
		document.getElementById("operation-form").submit();
		
	})
		
		
		
	$('#results th a').on('click', function(){
		var order = $('#order').val() == 'ASC' ? 'DESC' : 'ASC' 
		console.log(order);
		$('#order').val(order);
		$('#column_order').val($(this).attr('rel'));
		document.getElementById("operation-form").submit();
	})
	</script>
  </body>
</html>