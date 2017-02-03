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

	  printSliderSection();
  ?>
  

<!-- start How it works area -->
  <section id="howWorks">
     <div class="container">
      <div class="row">
          <div class="howworks_area">
            <div class="client_title">
                <hr>
                <?php printMessages();?>
                <h2>Pesquise sua ONG aqui</h2>
            </div>
                <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 wow bounceInLeft ">  
                            <h2>
                                <form action="buscar_ong.php">
                                    <div class="row">
                                       <div class="col-md-3 col-md-offset-0 col-sm-12   col-sm-offset-3">
                                       		<!--Destino <input type="text" placeholder="Bairro,endereço,escola">!-->
                                       </div>
                                        <div class="col-md-5 col-md-offset-0 col-sm-12   col-sm-offset-3">
                                        	<label>Cidade</label> 
                                        	<input type="text" placeholder="Nome da cidade" name="cidade" id="cidade" list="json-datalist">
											<datalist id="json-datalist"></datalist>
                                        </div>
                                        
                                        <div class="col-md-4 col-md-offset-0 col-sm-12   col-sm-offset-6">
                                        	<input type="submit" value="Buscar" class="button"> 
                                        </div> 
                                    </div>
                                </form>
                            </h2>
                        </div>      
                </div>
              </div>
          </div>
        </div>
  </section>
  <!-- End How it works area -->
    
  <!-- Start Service area -->
  <section id="service">
    <div class="container">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="service_area">
          <div class="service_title">
           <hr>
            <h2>Serviço de catálogo de ONGs em todo o Brasil.</h2>
          </div>
          <ul class="service_nav wow flipInX">
            <li>
              <a class="service_icon" href="#"><i class="fa fa-users"></i></a>
              <h2>Mais segurança com recomendações</h2>
              <p>Faça busca de motoristas baseando nas recomendações de outros usuário.</p>
              <!--<a class="read_more" href="#">read more<i class="fa fa-long-arrow-right"></i></a>-->
            </li>
           <li>
              <a class="service_icon" href="#"><i class="fa fa-gears"></i></a>
              <h2>Facilidade de descarte de material </h2>
              <p>Você pode ajudar uma ONG a se manter.</p>
              <!--<a class="read_more" href="#">read more<i class="fa fa-long-arrow-right"></i></a>-->
            </li>
            <li>
              <a class="service_icon" href="#"><i class="fa fa-support"></i></a>
              <h2>Mais suporte</h2>
              <p>Oferecemos vários canais de suporte para que você possa tirar suas dúvidas.</p>
              <!--<a class="read_more" href="#">read more<i class="fa fa-long-arrow-right"></i></a>-->
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- End Service area -->

  <!-- start How it works area -->
  <section id="howWorks">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="howworks_area">
            <div class="client_title">
              <hr>
              <h2>Como <span>usar o Coleta Verde</span></h2>
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="howworks_slider wow fadeInLeftBig">
                  <div class="slider_area">
                      <!-- Set up your HTML -->
                    <div class="slick_slider">
                      <div class="single_iteam">
                        <a href="single_page.html"> <img src="img/works_slider1.jpg" alt="img"></a>                          
                      </div>
                      <div class="single_iteam">
                        <a href="single_page.html"> <img src="img/works_slider2.jpg" alt="img"></a>                          
                      </div>
                      <div class="single_iteam">
                        <a href="single_page.html"> <img src="img/works_slider3.jpg" alt="img"></a>                          
                      </div>
                      <div class="single_iteam">
                        <a href="single_page.html"> <img src="img/works_slider4.jpg" alt="img"></a>                          
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="howworks_featured wow fadeInRightBig">
                <!-- single featured -->
                  <div class="media">
                    <a class="media-left media-middle" href="#">
                      <i class="fa fa-laptop"></i>
                    </a>
                    <div class="media-body">
                      <h4 class="media-heading">Faça a pesquisa das ONGs</h4>
                      <p>Informe o endereço de origem e destino e clique em buscar.</p>
                    </div>
                  </div>
                  <!-- End single featured -->

                  <!-- single featured -->
                  <div class="media">
                    <a class="media-left media-middle" href="#">
                      <i class="fa fa-filter"></i>
                    </a>
                    <div class="media-body">
                      <h4 class="media-heading">Filtre as ONGs</h4>
                      <p>Selecione os diversos filtros de busca como os mais recomendados e os mais pontualidade.</p>
                    </div>
                  </div>
                  <!-- End single featured -->

                  <!-- single featured -->
                  <div class="media">
                    <a class="media-left media-middle" href="#">
                      <i class="fa fa-check-circle-o"></i>
                    </a>
                    <div class="media-body">
                      <h4 class="media-heading">Procure a ONG desejada</h4>
                      <p>Procure a ONG desejada então o motorista terá um prazo de 48 horas para confirmar a coleta. </p>
                    </div>
                  </div>
                  <!-- End single featured -->
                  <a class="featured_btn" href="#">Pesquise a sua ONG</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End How it works area -->


  <!-- start Our Team area -->
  <section id="ourTeam">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="team_area wow fadeInLeftBig">
            <div class="team_title">
              <hr>
              <h2>Nossos paceiros</h2>
              <p>Ninguém conseguirá trabalhar em equipe se não aprender a ouvir. Ninguém aprenderá a ouvir se não aprender a se colocar no lugar dos outros.
"Augusto Cury"</p>
            </div>
            <div class="team">
              <ul class="team_nav">
              <!--<li>
                  <div class="team_img">
                    <img src="img/rafael.jpg" alt="team-img">
                  </div>
                  <div class="team_content">
                     <h4 class="team_name">Rafael Martins</h4>
                    <p>Diretor Executivo (Engenheiro de Computação)</p>
                  </div>
                  <div class="team_social">
                    <a href="https://www.facebook.com/rafael.martinsalves.75?fref=ts"><span class="fa fa-facebook"></span></a>
                    <a href="https://drive.google.com/file/d/0B2Jzo5PLasYqQkpCV0lZMFRVa00/view"><span class="fa fa-linkedin"></span></a>
                    <a href="https://plus.google.com/u/0/109427577019006818474"><span class="fa fa-google-plus"></span></a>
                  </div>
                </li>
                <li>
                  <div class="team_img">
                    <img src="img/rodrigo.gif" alt="team-img">
                  </div>
                  <div class="team_content">
                    <h4 class="team_name">Rodrigo Martins</h4>
                    <p>Diretor de Desenvolvimento (Engenheiro de Computação)</p>
                  </div>
                  <div class="team_social">
                    <a href="https://www.facebook.com/rodrigo.m.alves.37"><span class="fa fa-facebook"></span></a>
                    <a href="https://docs.google.com/document/d/1oJwN5EsmNhIjx_KisQ84g-ZZbCTVHrHrsALcn9LE9qI/edit"><span class="fa fa-linkedin"></span></a>
                    <a href="https://plus.google.com/u/0/111563380430393034127"><span class="fa fa-google-plus"></span></a>
                  </div>
                </li>-->
                <li>
                
                  <div class="team_img">
                    <img src="img/coca.jpg" alt="team-img">
                  </div>
                  <div class="team_content">
                    <h4 class="team_name">Coca</h4>
              
                  </div>
                  <div class="team_social">
                    <a href="#"><span class="fa fa-facebook"></span></a>
                    <a href="#"><span class="fa fa-twitter"></span></a>
                    <a href="#"><span class="fa fa-linkedin"></span></a>
                    <a href="#"><span class="fa fa-google-plus"></span></a>
                  </div>
                </li>
                <li>
                  <div class="team_img">
                    <img src="img/hp.jpg" alt="team-img">
                  </div>
                  <div class="team_content">
                    <h4 class="team_name">HP</h4>
                  </div>
                  <div class="team_social">
                    <a href="#"><span class="fa fa-facebook"></span></a>
                    <a href="#"><span class="fa fa-twitter"></span></a>
                    <a href="#"><span class="fa fa-linkedin"></span></a>
                    <a href="#"><span class="fa fa-google-plus"></span></a>
                  </div>
                </li>
                <li>
                  <div class="team_img">
                    <img src="img/bancodobrasil.jpg" alt="team-img">
                  </div>
                  <div class="team_content">
                    <h4 class="team_name">BBB</h4>
                  </div>
                  <div class="team_social">
                    <a href="#"><span class="fa fa-facebook"></span></a>
                    <a href="#"><span class="fa fa-twitter"></span></a>
                    <a href="#"><span class="fa fa-linkedin"></span></a>
                    <a href="#"><span class="fa fa-google-plus"></span></a>
                  </div>
                </li>
                
                 <li>
                  <div class="team_img">
                    <img src="img/john.gif" alt="team-img">
                  </div>
                  <div class="team_content">
                    <h4 class="team_name">John Deere</h4>
                  </div>
                  <div class="team_social">
                    <a href="#"><span class="fa fa-facebook"></span></a>
                    <a href="#"><span class="fa fa-twitter"></span></a>
                    <a href="#"><span class="fa fa-linkedin"></span></a>
                    <a href="#"><span class="fa fa-google-plus"></span></a>
                  </div>
                </li>
         
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Our Team area -->


  <!-- start price section -->
  <section id="priceSection">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="client_title">
            <hr>
            <h2>Vantagens do <span> Coleta Verde</span></h2>
          </div>
          <!-- Start Plan area -->
          <div class="pricearea">
            <ul class="price_nav wow bounceIn">               
              <li class ="col-md-offset-3  col-sm-offset-3">
                <h2 class="price_heading">Para quem descarta o material</h2>
               <ul class="pfeatured_nav">
                  <li><strong>Recomendações</strong> de outros usuários</li>
                  <li><strong>Facilidade</strong> do descarte do material</li>
                  <li>Seja <strong>avisado</strong> quando o coletor chegar</li>
                  <li><strong>Suporte</strong> técnico</li>
                </ul>
               <!-- <h3>$30</h3>
                <p>Per Month</p>
                <a class="get_button" href="#">Get a quote</a>-->
              </li>
              <!-- Start single Plan -->
              <li>
                <h2 class="price_heading">Para a ONG</h2>
                <ul class="pfeatured_nav">
                  <li><strong>Divulgação </strong> do serviço de coleta de materias na internet </li>
                  <li><strong>Facilidade no recebimento </strong> na coleta</li>
                  <li><strong>Controle </strong> do fluxo de caixa</li>
                  <li><strong>Suporte </strong> técnico</li>
                </ul>
                <!--<h3>$50</h3>
                <p>Per Month</p>
                <a class="get_button" href="#">Get a quote</a>-->
              </li>
              <!-- Start single Plan -->
              <!--<li>
                <h2 class="price_heading">Business</h2>
                <ul class="pfeatured_nav">
                  <li><strong>3GB</strong> Disk Space </li>
                  <li><strong>1.5Gb</strong> Monthly Traffic</li>
                  <li><strong>25</strong> Subdomains</li>
                  <li><strong>200</strong> Email Accounts</li>
                  <li>Webmail Support</li>
                  <li>MySQL Support</li>
                  <li>PHP5 Support</li>
                </ul>
                <h3>$90</h3>
                <p>Per Month</p>
                <span class="price_badge">Most Popular!</span>
                <a class="get_button" href="#">Get a quote</a>
              </li>-->
              <!-- Start single Plan -->
              <!--<li>
                <h2 class="price_heading">Platinum</h2>
                <ul class="pfeatured_nav">
                  <li><strong>Unlimited</strong> Disk Space </li>
                  <li><strong>Unlimited</strong> Monthly Traffic</li>
                  <li><strong>Unlimited</strong> Subdomains</li>
                  <li><strong>Unlimited</strong> Email Accounts</li>
                  <li>Webmail Support</li>
                  <li>MySQL Support</li>
                  <li>PHP5 Support</li>
                 </ul>
                <h3>$130</h3>
                <p>Per Month</p>
                <a class="get_button" href="#">Get a quote</a>
              </li>-->
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End price section -->

  <!-- start special quote -->
  <section id="specialQuote">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 wow bounceInLeft">
          <p>“A QUALIDADE de seu trabalho tem tudo a ver com a qualidade de sua VIDA.” Orison Swett Marden</p>
        </div>
      </div>
    </div>
  </section>
  <!-- End special quote -->

  <!-- start client testimonial -->
  <!--<section id="testimonial">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="testimonial_area wow bounceIn">
            <div class="client_title">
              <hr>
              <h2>What <span>Others are Saying</span></h2>
            </div>
            <ul class="testimon_nav">
              <li>
               <div class="testimonial_content">
                  <blockquote>
                    <p>Perfect has been one of our most valued discoveries! The exceptional service offered by the team is second to none; the finished product is delivered perfectly, with remarkably quick turnaround, every time. It is a service we can (& do!) rely on and recommend to all that we meet.</p>
                  <small>Jacquie Ward, Love Movement</small>
                  </blockquote>
                  <div class="client_img">
                    <img src="img/leify.png" alt="img">
                  </div>
               </div>
              </li>
             <li>
               <div class="testimonial_content">
                  <blockquote>
                    <p>Perfect has been one of our most valued discoveries! The exceptional service offered by the team is second to none; the finished product is delivered perfectly, every time. It is a service we can (& do!) rely on and recommend to all that we meet.</p>
                  <small>Jacquie Ward, Love Movement</small>
                  </blockquote>
                  <div class="client_img">
                    <img src="img/leify.png" alt="img">
                  </div>
               </div>
              </li>
              <li>
               <div class="testimonial_content">
                  <blockquote>
                    <p>Perfect has been one of our most valued discoveries! The exceptional service offered by the team is second to none; the finished product is delivered perfectly, with remarkably quick turnaround, every time. It is a service we can (& do!) rely on and recommend to all that we meet.</p>
                  <small>Jacquie Ward, Love Movement</small>
                  </blockquote>
                  <div class="client_img">
                    <img src="img/leify.png" alt="img">
                  </div>
               </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>-->
  <!-- End client testimonial -->  

  <!-- start featured blog area --><!--
  <section id="featuredBlog">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="featuredBlog_area">
            <div class="team_title">
              <hr>
              <h2>News <span>From Our Blog</span></h2>
              <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
            </div>-->
            <!-- start featured blog -->
            <!--<div class="featured_blog">
              <div class="row">-->
                <!-- start single featured blog -->
                <!--<div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="single_featured_blog">                      
                    <img alt="img" src="img/blog.jpg">
                    <h2>It's That time of year again! </h2>
                    <div class="post_commentbox">
                      <a href="#"><i class="fa fa-tags"></i>Technology</a>
                      <a href="#"><i class="fa fa-comments"></i>Comments</a>      
                    </div>
                    <p>As the second largest social network in existence, a Google+ profile will give your brand a massive reach. But the most valuable thing about getting your eCommerce store onto Google+ is that Google prioritises all Google+, making it the best social media platform for search engine optimisation.</p>
                    <a href="single.html" class="read_more">read more<i class="fa fa-long-arrow-right"></i></a>
                  </div>
                </div>-->
                <!-- start single featured blog -->
                <!--<div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="single_featured_blog">                      
                    <img alt="img" src="img/blog.jpg">
                    <h2>It's That time of year again! Prepare your ecomarce </h2>
                    <div class="post_commentbox">
                      <a href="#"><i class="fa fa-tags"></i>Technology</a>
                      <a href="#"><i class="fa fa-comments"></i>Comments</a>      
                    </div>
                    <p>As the second largest social network in existence, a Google+ profile will give your brand a massive reach. But the most valuable thing about getting your eCommerce store onto Google+ is that Google prioritises all Google+, making it the best social media platform for search engine optimisation.</p>
                    <a href="single.html" class="read_more">read more<i class="fa fa-long-arrow-right"></i></a>
                  </div>
                </div>-->
                <!-- start single featured blog -->
                <!--<div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="single_featured_blog">                      
                    <img alt="img" src="img/blog.jpg">
                    <h2>It's That time of year again!</h2>
                    <div class="post_commentbox">
                      <a href="#"><i class="fa fa-tags"></i>Technology</a>
                      <a href="#"><i class="fa fa-comments"></i>Comments</a>      
                    </div>
                    <p>As the second largest social network in existence, a Google+ profile will give your brand a massive reach. But the most valuable thing about getting your eCommerce store onto Google+ is that Google prioritises all Google+, making it the best social media platform for search engine optimisation.</p>
                    <a href="single.html" class="read_more">read more<i class="fa fa-long-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>-->
  <!-- End featured blog area -->

  <!-- start clients brand area -->
  <!--<section id="clients_brand">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="clients_brand_area wow flipInX">
            <div class="client_title">
              <hr>
              <h2><span>Our</span> Clients</h2>
            </div>              
            <div class="clients_brand">-->
              <!-- Start clients brand slider -->
             <!--<ul class="clb_nav wow flipInX">
               <li><img src="img/envato-studio.png" alt="brand-img"></li>
               <li><img src="img/codecanyon.png" alt="brand-img"></li>
               <li><img src="img/audiojungle.png" alt="brand-img"></li>
               <li><img src="img/themeforest.png" alt="brand-img"></li>
               <li><img src="img/envato-studio.png" alt="brand-img"></li>
               <li><img src="img/codecanyon.png" alt="brand-img"></li>
               <li><img src="img/audiojungle.png" alt="brand-img"></li>
               <li><img src="img/themeforest.png" alt="brand-img"></li>
             </ul>-->
             <!-- End clients brand slider -->
            <!--</div>
          </div>
        </div>
      </div>
    </div>
  </section>-->
  <!-- End clients brand area -->  
  
  
  
  
 
  

  <?php printFooter();?>

  <?php printJavaLibrary();?>
  
  
   <script>
	  
	$("#cidade").on("change paste keyup", function() {
	    $.ajax({ 
                url: 'consultar_cidade.php', 
                type: 'POST', 
                data: 'cidade=' + $('#cidade').val(), /* dado que será enviado via POST */
				dataType: 'json', /* Tipo de transmissão */
                success: function(data) { 
                console.log(data); 
					
				$("#json-datalist").empty();
					
				for(var i=0;i<data.length;i++)
				{
					console.log('valor:'+data[i]);
					$("#json-datalist").append("<option value='" + 
					data[i] + "'></option>");
				}	
				
                
				
            } 
        }); 
	});
  	
	
	
  </script>
  </body>
</html>