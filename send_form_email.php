<?php

include_once('/var/www/html/coletaverde/php/common.php');
 
if(isset($_POST['email'])) {
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
 
    $email_to = "rafaelmartinsalves@gmail.com;rodrigowindows@gmail.com";
 
    $email_subject = "Contato Coleta Verde";
 
     
 
     
 
    function died($error) {
 
        // your error code can go here
 
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
 
        echo "These errors appear below.<br /><br />";
 
        echo $error."<br /><br />";
 
        echo "Please go back and fix these errors.<br /><br />";
 
        die();
 
    }
 
     
 
    // validation expected data exists
 
    if(!isset($_POST['nome']) ||
 
        !isset($_POST['email']) ||
 
        !isset($_POST['assunto']) ||
 
        !isset($_POST['texto'])) {
 
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
 
    }
 
     
 
    $nome = $_POST['nome']; // required
 
    $email_from = $_POST['email']; // required
 
    $assunto = $_POST['assunto']; // not required
 
    $texto = $_POST['texto']; // required
 
     
 
    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
 
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
 
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$nome)) {
 
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
 
  }
 
  
 
  if(strlen($error_message) > 0) {
 
    died($error_message);
 
  }
 
    $email_message = "Form details below.\n\n";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
 
     
 
    $email_message .= "Nome: ".clean_string($nome)."\n";
 
 
    $email_message .= "Email: ".clean_string($email_from)."\n";
 
 
    $email_message .= "Assunto: ".clean_string($assunto )."\n";
	
	
	$email_message .= "Texto: ".clean_string($texto )."\n";
 
     
 
     
 
// create email headers
 
$headers = 'From: '.$email_from."\r\n".
 
'Reply-To: '.$email_from."\r\n" .
 
'X-Mailer: PHP/' . phpversion();
 
 
 
?>
 
 
 
<!-- include your own success html here -->
 
<?php
	$errLevel = error_reporting(E_ALL ^ E_NOTICE);  // suppress NOTICEs
	if(mail($email_to, $email_subject, $email_message, $headers)){
		$_SESSION['msg'] = "A menssagem foi enviada com sucesso.";
		//echo "enviou";
		
	}
		
	else{
		
		$_SESSION['error'] = "Houve um erro ao enviar a mensagem.";
		//echo "$email_to - $email_subject - $email_message - $headers";
		//print_r(error_get_last());
		//echo 'erro';
		
		error_reporting($errLevel);  // restore old error levels
	}
		
	header("Location: contato.php");
?>  
 

 
 
 
<?php
 
}
 
?>