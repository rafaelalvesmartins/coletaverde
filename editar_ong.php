<?php $BASE = __DIR__?>
<?php include_once("$BASE/php/common.php");?>


<?php
require("$BASE/php/create_enderecos.php");
require("$BASE/php/create_bairros.php") ;
require("$BASE/php/create_logins.php") ;
require("$BASE/php/create_motoristas-1.php");
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
  
  
   <?php if(checkAccess()) :  ?>
	<section id="howWorks">
     <div class="container">
      <div class="row">
          <div class="howworks_area">
            <div class="client_title">
                <hr>
                <?php printMessages();?>
            </div>
                <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 wow bounceInLeft ">  
                            <h2>
                               	<div class="container">       
    							<h1 class="well">Editar ONG</h1>
                                
                                 <?php
								
									$loginID = returnUserId();
									restoreDB2PostBairro($loginID);
									restoreDB2PostEndereco($loginID);
									restoreDB2PostLogin($loginID);
									restoreDB2PostMotorista($loginID);
									
								
									printMotoristaForm();
									
								?>
                           
							   <?php
									if(isset($_POST["operation"]))
										if($_POST["operation"] == "insertUpdate")
										{
											$loginID = returnUserId();
											if(updateBairro($loginID))
												if(updateEndereco($loginID))
													if(updateLogin($loginID))
														if(updateMotorista($loginID))
															echo '<meta http-equiv="refresh" content=1;url="http://35.162.13.179/coletaverde/editar_ong.php">';

										}

									?>
								</div>
                            </h2>
                        </div>      
                </div>
              </div>
          </div>
        </div>
  </section>
  
  <?php endif; ?>


  <?php printFooter();?>

  <?php printJavaLibrary();?>
  
  <?php require('js/jsmotorista.js'); ?>
  
  
  </body>
</html>