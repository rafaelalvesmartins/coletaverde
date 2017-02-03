<?php $BASE = __DIR__?>
<?php include_once("$BASE/php/common.php");?>


<!DOCTYPE html>
<html lang="pt">
  <head>
   	<?php printHead($BASE);?>
  </head>
<body>
     
  <?php
	
	  printPreLoader();

	  printNavbar();

	 // printSliderSection();
  ?>
  
 <!-- Start Contact section --> 
 <!-- start Contact section -->
  <section id="contact">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="contact_map">
          <!-- Start Google map -->
          <div id="map_canvas"></div>
        </div>
      </div>
    </div>
	 <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
         <div class="contact_area">
           <div class="client_title">
              <hr>
              <?php printMessages();?>
              <h2>Gostaríamos <span>de ouvir você</span></h2>
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="contact_left wow fadeInLeft">
                  <form class="submitphoto_form" action="send_form_email.php" method="post" name="operation-form" id="operation-form">
                    <input type="text" name="nome" class="form-control wpcf7-text" placeholder="Seu Nome" required rangelength="[2, 100]">
                    <input type="mail" name="email" class="form-control wpcf7-email" placeholder="Endereço de email" required email="true">          
                    <input type="text" name="assunto" class="form-control wpcf7-text" placeholder="Assunto" required rangelength="[5, 100]">
                    <textarea name="texto" class="form-control wpcf7-textarea" cols="30" rows="10" placeholder="O que você gostaria de nos dizer" required rangelength="[10, 500]"></textarea>
                    <input type="submit" value="Enviar" class="button">                     
                  </form>
                </div>                  
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="contact_right wow fadeInRight">
                  <img src="img/phone_icon.png" alt="img">
                  <p>Diga olá! Queremos ouvir sobre o que você tem a dizer. Estamos abertos a comentários e perguntas que você possa ter.</p>
                  <address>
                    <p><a href="mailto:contato@coletaverde.com"> contato@coletaverde.com</a></p>
                    <p> +55 53 9 8159-6199</p>
                  </address>
                </div>
              </div>
            </div>              
         </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Contact section -->

  <?php printFooter();?>

  <?php printJavaLibrary();?>
  
  <script>
			$().ready(function() {

			$("#operation-form").validate({
				lang: 'pt' 
			});
			
  });
	  
</script>
	
  </body>
</html>