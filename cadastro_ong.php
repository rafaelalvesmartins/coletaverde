
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
    							<h1 class="well">Cadastro de ONG</h1>
                               
                               
                                <?php
									printMotoristaForm();
								?>
                           
                           		<?php
								if(isset($_POST["operation"]))
									if($_POST["operation"] == "insertUpdate")
									{
										if(insertRecordBairros())
											if(insertRecordEnderecos())
												if(insertRecordLogins())
													if(insertRecordMotoristas())
														echo '<meta http-equiv="refresh" content=1;url="http://35.162.13.179/coletaverde/">';

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


  <?php printFooter();?>

  <?php printJavaLibrary();?>
  
  <?php require('js/jsmotorista.js'); ?>
  
  
  </body>
</html>