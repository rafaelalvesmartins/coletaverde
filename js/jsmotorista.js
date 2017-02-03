<script>
jQuery("#telefone").mask("(99)9999-9999");
jQuery("#celular").mask("(99)9999-99999");
	 
 /*jQuery("input.telefone")
        .mask("(99)9999-9999?9")
        .focusout(function (event) {
            var target, phone, element;  
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
            phone = target.value.replace(/\D/g, '');
            element = $(target);  
            element.unmask();  
            if(phone.length > 10) {  
                element.mask("(99)99999-999?9");  
            } else {  
                element.mask("(99)9999-9999?9");  
            }  
        });*/
	 jQuery("#cep").mask("99999-999");
	 jQuery("#cnpj").mask("99.999.999/9999-99");
	 
  	$().ready(function() {

			$("#operation-form").validate({
				lang: 'pt' 
			});
			
		});
	 
	 
	 $(document).ready( function() {
   /* Executa a requisição quando o campo CEP perder o foco */
   $('#cep').blur(function(){
	   			
           /* Configura a requisição AJAX */
           $.ajax({
                url : 'consultar_cep.php', /* URL que será chamada */ 
                type : 'POST', /* Tipo da requisição */ 
                data: 'cep=' + $('#cep').val(), /* dado que será enviado via POST */
                dataType: 'json', /* Tipo de transmissão */
                success: function(data){
					//alert('dados'.data); 
                    //if(data.sucesso == 1){
						//alert(data.endereco);
                        $('#endereco').val(data.endereco);
                        $('#bairro').val(data.bairro);
                       
						var options = '';	
						
					
							
						$("#estado option").each(function () {
							if($(this).val()==data.estado){
								options += '<option value="' + $(this).val() + '" selected>' + $(this).text() + '</option>';
								
							}
							else{
								options += '<option value="' + $(this).val() + '">' + $(this).text() + '</option>';
							}
							
						});
					
						$("#estado").html(options);	
						$("#estado").change();
					
						var options_cidades = '';
						var str = "";					

						$("#estado option:selected").each(function () {
							str += $(this).text();
						});
						
						
												
						$("#cidade option").each(function () {
							if($(this).val()==data.cidade){
								options_cidades += '<option value="' + $(this).val() + '" selected>' + $(this).val() + '</option>';
							}
							else{
								options_cidades += '<option value="' + $(this).val() + '">' + $(this).val() + '</option>';
							}
						});							
						
						$("#cidade").html(options_cidades);
						
					
						//$('#cidade').val(data.cidade);
                       
 
                        $('#numero').focus();
                    //}
					
						
                },
			   error: function(xhr, status, error) {
					//alert(xhr.responseText);
				 }
			  
           });   
   return false;    
   })
});
	 
	 
	 $(document).ready(function () {
		
			$.getJSON('js/estados_cidades.json', function (data) {
				var items = [];
				var options = '<option value="">escolha um estado</option>';	
				
				<?php 
					if(isset($_POST["estado"]))
						echo "estado = '".$_POST["estado"]."';";
					else 
						echo "estado = '';";		
				?>
				
				$.each(data, function (key, val) {
					
					
					if(val.sigla==estado){
						options += '<option value="' + val.sigla + '" selected>' + val.nome + '</option>';
					}
					else{
						options += '<option value="' + val.sigla + '">' + val.nome + '</option>';
					}
					
					
					
				});					
				$("#estado").html(options);				
				
				$("#estado").change(function () {				
				
					var options_cidades = '<option value="">escolha uma cidade</option>';
					var str = "";					
					
					$("#estado option:selected").each(function () {
						str += $(this).text();
					});
					
					
					<?php 
					if(isset($_POST["cidade"]))
						echo "cidade = '".$_POST["cidade"]."';";
					else 
						echo "cidade = '';";		
				  	?>
					
					$.each(data, function (key, val) {
						if(val.nome == str) {							
							$.each(val.cidades, function (key_city, val_city) {
								if(val_city==cidade){
									options_cidades += '<option value="' + val_city + '" selected>' + val_city + '</option>';
								}
								else{
									options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
								}
								
								
							});							
						}
					});
					$("#cidade").html(options_cidades);
					
				}).change();		
			
			});
		
		});
	 
	 
	 
    var email = $("#email"); 
        email.blur(function() { 
            $.ajax({ 
                url: 'verificaEmail.php', 
                type: 'POST', 
                data:{"email" : email.val()}, 
				dataType: 'json', /* Tipo de transmissão */
                success: function(data) { 
                //console.log(data); 
                //data = $.parseJSON(data);
				//alert(data.email);
				//alert(data);
                
				
					 
				if(data.quant>0  <?php if(isset($_POST["email"])) echo " && '".$_POST["email"]."'!=email.val()"?>){
					$("#resposta").text(data.email);
					$('#email').val('');
				}
				else{
					$("#resposta").text('');
				}
					
				
				
            } 
        }); 
    }); 

</script>