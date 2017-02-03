<?php
	define( 'DB_HOST' , '127.0.0.1' );
	define( 'DB_PORT' , 5432 );
	define( 'DB_USER' , 'root' );
	define( 'DB_PASS' , 'root' );
	define( 'DB_NAME' , 'byvan' );
	define( 'RESULTS_LIMIT' , 10 );
	define( 'RESULTS_START' , 1 );
	define( 'MAX_FILTER_LENGTH' , 50 );

	if (session_status() == PHP_SESSION_NONE) {
    	session_start();
	}
	
	

	function printTitle(){
		echo 'Coleta Verde';
	}

	function printDescr(){
		echo '';
	}



	function printPagination($nrows,$limit){
		if(!$nrows) return '';

		$pages = ceil($nrows/$limit);
		
		

		if($pages < 2) return ;
		
		echo "<div class=\"clearfix\"></div>
			<ul class=\"pagination pull-right\">";
		$max = RESULTS_LIMIT;
		$current = isset($_POST['offset']) ? $_POST['offset'] : RESULTS_START;
		$previous = $current - 1;
		$next = $current + 1;

		if($current == 1)
			echo "<li class=\"disabled\"><a class=\"pagination\" rel=\"1\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a></li>";
		else
			echo "<li ><a class=\"pagination\" rel=\"". $previous ."\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a></li>";

		$toPrint = 5;
		
		for($i= ($current-$toPrint); $i< $current;$i++){
			
			if($i>0)
				echo "<li ><a class=\"pagination\"  rel=\"". $i ."\" >$i</a></li>";
		}


		for($i=$current;($i < ($current+$toPrint)) && ($i <= $pages);$i++){
			echo '<li  ';
			if($current == $i)
				echo 'class="active"';
			echo "><a class=\"pagination\"  rel=\"". $i ."\" >$i</a></li>";
		}
		
		
		if($current < $pages)
			echo "<li ><a class=\"pagination\" rel=\"". $next ."\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a></li>";
		else
			echo "<li class=\"disabled\"><a class=\"pagination\" rel=\"". $current ."\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a></li>";
		
		echo '</ul>';
	}

	function printRowsRadios(){
		$limit = isset($_POST['filter-limit']) ? $_POST['filter-limit'] : 10;
		echo "<div class=\"limit-wrapper\">
			Mostrar
			<select name=\"filter-limit\">
				<option value=\"10\" "; if($limit=='10') echo " selected=\"selected\""; echo " >10</option>
				<option value=\"20\" "; if($limit=='20') echo " selected=\"selected\""; echo " >20</option>
				<option value=\"50\" "; if($limit=='50') echo " selected=\"selected\""; echo " >50</option>
				<option value=\"100\" "; if($limit=='100') echo " selected=\"selected\""; echo " >100</option>
			</select>
			<label>registros</label>
		</div>";
	}

	function printMessages(){
		if(isset($_SESSION['error'])) echo "<div class=\"msg\">{$_SESSION['error']}</div>";
		if(isset($_SESSION['msg'])) echo "<div class=\"msg\">{$_SESSION['msg']}</div>";
		unset($_SESSION['error']);
		unset($_SESSION['msg']);
	}

	function logout(){

		unset($_SESSION['crudgen_user']);
		unset($_SESSION['crudgen_passwd']);
		session_destroy();
	
	}
	
	$conn = new PDO("pgsql:dbname=" . DB_NAME . ";host=" . DB_HOST . ";port=" . DB_PORT . ";user=" . DB_USER . ";password=" . DB_PASS);

	function isLoged()
	{
		if(isset($_SESSION['crudgen_user']))
			return true;
	}

	function returnUserId()
	{
		if(isLoged())
			return $_SESSION['crudgen_user'];
		else
			return -1;
	}

	function checkAccess(){
		global $conn;

		if(isLoged())
			return true;
		else{
			if(isset($_POST['crudgen_user']) && isset($_POST['crudgen_passwd']) ){
				$query="SELECT email,senha,id
						FROM public.logins 
						WHERE email=:crudgen_user";
				$rs = $conn->prepare($query);
				$rs->execute(array(':crudgen_user'=>$_POST['crudgen_user']));
				
				if($rs->rowCount()==1){
					$row = $rs->fetch();
					if(password_verify($_POST['crudgen_passwd'], $row['senha'])) {
						$_SESSION['crudgen_user'] = $row['id'];
						return true;
					}
					else{
						$_SESSION['error']="Falha na autenticação! Verifique o email e a senha.";
						include "login.inc.php";	
					}
					
				} else {
					$_SESSION['error']="Falha na autenticação! Verifique o email e a senha.";
					include "login.inc.php";
				}
			} else {
				include "login.inc.php";
			}
		}
	}

	if(isset($_REQUEST['logout']))
		logout();

	

	function printLogout(){
		if(isset($_SESSION['crudgen_user']))
			return "<a class=\"logout\" href=\"?logout=true\">Sair</a>";
	}


  
  
	function printNavbar()
	{
		
		if(isLoged())
		{
			echo '	<!-- start navbar -->
				<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
				<div class="container">
				  <div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					  <span class="sr-only">Toggle navigation</span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php"><span>Coleta Verde</span></a>
					<!-- <a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="logo"></a> -->
				  </div>
				  <div id="navbar" class="navbar-collapse collapse navbar_area">          
					<ul class="nav navbar-nav navbar-right custom_nav">
					  <li '; if(basename($_SERVER['PHP_SELF']) =='index.php') echo 'class="active"'; echo '><a href="index.php">Início</a></li> 
					  <li '; if(basename($_SERVER['PHP_SELF']) =='buscar_ong.php') echo 'class="active"'; echo ' ><a href="buscar_ong.php">Buscar ONG</a></li>
					  <li '; if(basename($_SERVER['PHP_SELF']) =='contato.php') echo 'class="active"'; echo '><a href="contato.php">Contato</a></li>
					  <li class="dropdown '; if(basename($_SERVER['PHP_SELF']) =='editar_motorista.php') echo 'active'; echo '">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Você está logado <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
						  <li ><a href="editar_motorista.php">Editar</a></li>
						  <li>'.printLogout().'</li>
						</ul>
					  </li> 
					  
					                    
					</ul>
				  </div><!--/.nav-collapse -->
				</div>
			  </nav>';
			}
		else {
			echo '	<!-- start navbar -->
				<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
				<div class="container">
				  <div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					  <span class="sr-only">Toggle navigation</span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php"><span>Coleta Verde</span></a>
					<!-- <a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="logo"></a> -->
				  </div>
				  <div id="navbar" class="navbar-collapse collapse navbar_area">          
					<ul class="nav navbar-nav navbar-right custom_nav">
					  <li '; if(basename($_SERVER['PHP_SELF']) =='index.php') echo 'class="active"'; echo '><a href="index.php">Início</a></li>
					  
					  <li '; if(basename($_SERVER['PHP_SELF']) =='cadastro_ong.php') echo 'class="active"'; echo ' ><a href="cadastro_ong.php">Cadastro de ONG</a></li>
					  
					  <li '; if(basename($_SERVER['PHP_SELF']) =='cadastro_doacao.php') echo 'class="active"'; echo ' ><a href="cadastro_doacao.php">Cadastro de Doação</a></li>
					  
					  <li '; if(basename($_SERVER['PHP_SELF']) =='buscar_ong.php') echo 'class="active"'; echo ' ><a href="buscar_ong.php">Buscar ONG</a></li>
					  
					  <li '; if(basename($_SERVER['PHP_SELF']) =='contato.php') echo 'class="active"'; echo '><a href="contato.php">Contato</a></li>
					  <li '; if(basename($_SERVER['PHP_SELF']) =='entrar.php') echo 'class="active"'; echo '><a href="entrar.php">Entrar</a></li>                    
					</ul>
				  </div><!--/.nav-collapse -->
				</div>
			  </nav>
			  <!-- End navbar -->';
			}
	}

	function printHead($BASE)
	{
		echo'
		<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coleta Verde</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- for fontawesome icon css file -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- superslides css -->
    <link rel="stylesheet" href="css/superslides.css">
    <!-- for content animate css file -->
    <link rel="stylesheet" href="css/animate.css">    
    <!-- slick slider css file -->
    <link href="css/slick.css" rel="stylesheet">        
    <!-- website theme color file -->   
     <link id="switcher" href="css/themes/cyan-theme.css" rel="stylesheet">    
    <!-- main site css file -->    
    <link href="style.css" rel="stylesheet">    
    <!-- google fonts  -->  
    <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">    
    <link href="http://fonts.googleapis.com/css?family=Raleway" rel="stylesheet" type="text/css">  -->
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">  
  
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn"t work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
 
		';
	}


	function printPreLoader()
	{
		echo'
		  <!-- Preloader -->
		  <div id="preloader">
			<div id="status">&nbsp;</div>
		  </div>

		  <!-- End Preloader -->   
		  <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
		';
	}

	function printSliderSection(){
		
		echo '
		<!-- start slider section -->
  <section id="sliderSection">            
    <div class="mainslider_area">
      <!-- Start super slider -->
      <div id="slides">
        <ul class="slides-container">
          <!-- Start single slider-->';
		
		if(basename($_SERVER['PHP_SELF']) =='buscar_ong.php')
			echo '
			<li>
            <img src="img/slider/2.jpg" alt="img">
             <div class="slider_caption">
              <h2>Seja um motorista cadastro no <br><span>Coleta Verde</span></h2>
              <!--<p>Com o <span>Coleta Verde</span> você pode ajudar o meio ambiente.</p>-->
              <a class="slider_btn" href="cadastro_ong.php">Cadastra-se</a>
            </div>
           </li>
			';
		
		
		
		if(basename($_SERVER['PHP_SELF']) =='cadastro_ong.php')
			echo '
			<li>
            <img src="img/slider/3.jpg" alt="img">
             <div class="slider_caption">
              <h2>Utilize ONGs legalizadas através do <span>Coleta Verde</span></h2>
              <!--<p>Os veículos escolares legalizos são  específicos para trabalhar no transporte de crianças, adaptados para tal função. Além disso o profissional que dirige um carro escolar legalizado é preparado para tal, tem curso específico e cumpre uma série de exigências da prefeitura.</p>
              <!--<a class="slider_btn" href="#">Read More</a>-->
            </div>
            </li>
			';
		
		  echo'	
          <li>
            <img src="img/slider/1.jpg" alt="img">
            <div class="slider_caption">
				<h2>Bem-vindo ao <span>Coleta Verde</span></h2>
              <p>Pesquise a sua ONG com mais segurança.</p>
              <!--<a class="slider_btn" href="#">Leia mais</a>-->
            </div>
          </li> 
          <!-- Start single slider-->           
          <li>
            <img src="img/slider/3.jpg" alt="img">
             <div class="slider_caption">
              <h2>Utilize ONGs legalizadas através do <span>Coleta Verde</span></h2>
              <!--<p>Os veículos escolares legalizos são  específicos para trabalhar no transporte de crianças, adaptados para tal função. Além disso o profissional que dirige um carro escolar legalizado é preparado para tal, tem curso específico e cumpre uma série de exigências da prefeitura.</p>
              <!--<a class="slider_btn" href="#">Read More</a>-->
            </div>
            </li>
          <!-- Start single slider-->
          <li>
            <img src="img/slider/2.jpg" alt="img">
             <div class="slider_caption">
              <h2>Seja uma ONG cadastro no <br><span>Coleta Verde</span></h2>
              <!--<p>Com o <span>Coleta Verde</span> você pode fazer sua ONG mais legal.</p>-->
              <a class="slider_btn" href="cadastro_ong.php">Cadastra-se</a>
            </div>
           </li>
        </ul>
        <nav class="slides-navigation">
          <a href="#" class="next"></a>
          <a href="#" class="prev"></a>
        </nav>
      </div>
    </div>  
  </section>
  <!-- End slider section -->
		';
	}

function printFooter(){
	echo '
		<!-- start footer -->
  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="footer_top">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="single_footer_top">
                  <h2>Coleta Verde </h2>
                  <ul>
                    <li><a href="#">Sobre</a></li>
                    <li><a href="#">Política de uso</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="single_footer_top">
                  <h2>Evolução</h2>
                  <p>O Coleta Verde está constantemente melhorando as suas ferramentas, assim sinta-se livre para nos enviar as suas dúvidas e sugestões sobre o nosso serviço.</p>
                </div>
                <div class="single_footer_top contact_mail">
                  <h2>Contato</h2>
                  <p>Estamos sempre disponíveis para conversar! Envie um email para nós a qualquer hora que iremos responder rapidamente. <a href="contato.php">Contato</a></p>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="single_footer_top">
                  <h2>Acesso </h2>
                  <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="cadastro_motorista">Cadastra-se como motorista</a></li>
                    <li><a href="contato.html">Contato</a></li>
                    <li><a href="entrar.php">Entrar</a></li>
                  </ul>
                </div>
                <div class="single_footer_top">
                  <h2>Redes sociais </h2>
                  <ul class="social_nav">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>        
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="footer_bottom">
            <div class="copyright">
              <p>Todos os direitos reservados </p>
            </div>
            <div class="developer">
              <p>Desenvolvido por <a href="#" rel="nofollow">Coleta Verde developers</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- End footer -->
	';
}
		
function printJavaLibrary()
{
	echo'
		<!-- jQuery Library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <!-- For content animatin  -->
  <script src="js/wow.min.js"></script>
  <!-- bootstrap js file -->
  <script src="js/bootstrap.min.js"></script> 
  <!-- superslides slider -->
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.animate-enhanced.min.js"></script>
  <script src="js/jquery.superslides.min.js" type="text/javascript" charset="utf-8"></script>
  <!-- slick slider js file -->
  <script src="js/slick.min.js"></script>
  <!-- Google map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnYmJHxZorP0kNrRgRQDiB5Hv6PQXsrqE"></script>
  <script src="js/jquery.ui.map.js"></script>

  <!-- custom js file include -->
  <script src="js/custom.js"></script>  
  
  
 <script src="http://code.jquery.com/jquery-1.7.2.js"></script>
 <script src="php/js/jquery.validate.min.js"></script>
 <script src="http://digitalbush.com/wp-content/uploads/2014/10/jquery.maskedinput.js"></script>
	';
}
?>