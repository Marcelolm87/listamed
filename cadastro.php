<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php
	require_once "classes/pagseguro.php";
	$sessionCode = PagSeguro::getSessionCode()->getResult();

	require_once("config.php");
	$conteudo =	json_decode(file_get_contents("http://listamed.com.br/api/page", false, stream_context_create($arrContextOptions)));

?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Fale Conosco - ListaMED</title>
        <meta title="Fale Conosco - ListaMED">
        <meta description="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet"> 
        <link rel="stylesheet" type="text/css" href="./css/champs.min.css">
        <link rel="icon" type="image/png" sizes="96x96" href="./images/favicon/favicon-96x96.png">
    </head>
<body>
	<div class="page page-cadastro" id="listamed-cadastro">
	    <div class="page-nav page-nav-links-blue" id="listamed-nav">
	    	<div class="container">
        		<div class="row container-fluid">
	        		<div class="pull-left">
	                    <h1 class="logo">
	                        <a href="index.php">
	                        	<img src="./images/logo-internas-top.png" />
	                        </a>
	                    </h1>	        			
	        		</div>	        			
	        		<div class="pull-right text-right">
		            	<div class="nora-menu" id="listamed-menu">
		            		<div class="visible-xs visible-sm hidden-md hidden-lg">
			            		<button type="button" class="nora-menu-btn nora-menu-action" nora-action="open">
			            			<i class="fa fa-bars"></i>
			            		</button>			            			
		            		</div>
		            		<div class="nora-menu-view">
		            			<div class="nora-menu-content">
			            			<div class="visible-xs visible-sm hidden-md hidden-lg">
					            		<button type="button" class="nora-menu-btn nora-menu-action" nora-action="close">
					            			<i class="fa fa-close"></i>
					            		</button>			            			
				            		</div>
				            		<ul class="nora-menu-list list list-items--inline">
				            			<li class="list--item"><a href="/sobre">Sobre a ListaMed</a></li>
				            			<li class="list--item"><a href="/seja" id="seja-header">Seja Lista Med</a></li>
				            			<li class="list--item"><a href="/perguntas-frequentes">Perguntas Frequentes</a></li>
				            			<li class="list--item"><a target="_blank" href="/blog">Blog</a></li>
				            			<li class="list--item"><a href="/contato">Contato</a></li>
				            		</ul>			            				
		            			</div>
		            		</div>
		            	</div>		        			
	        		</div>
        		</div>    		
	    	</div>
	    </div>
	    <div class="page-main">
			<div class="container">
				<div class="cadastro">
					<form action="" class="cadastro-form" name="formPag" id="formPagamento" method="post">
						<fieldset>
							<legend class="sr-only">Cadastro de novos Cliente</legend>
							<div class="cadastro-header text-center">
								<h2>Informações Pessoais</h2>
							</div>
							<div class="cadastro-fields">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<div class="form-group">
											<label class="control-label">Nome</label>
											<input class="form-control" type="text" id="txtNome" name="txtNome" placeholder="Nome" required/>
											<input type="hidden" id="txtSessao" name="txtSessao" value="<?php echo $sessionCode; ?>" />
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<div class="form-group">
											<label class="control-label">E-mail</label>
											<input  class="form-control" type="email" id="txtEmail" name="txtEmail" placeholder="Email" required/>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<div class="form-group">
											<label class="control-label">Telefone</label>
											<input class="form-control" type="text" id="txtTel" name="txtTel" placeholder="Telefone" required/>										
										</div>
									</div>
								</div>
							</div>
							<div class="cadastro-header text-center">
								<h2>Endereço</h2>
							</div>	
							<div class="cadastro-fields">
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<div class="form-group">
											<label class="control-label">CEP</label>
											<input class="form-control" type="text" id="txtCEP" name="txtCEP" placeholder="CEP" required/>
										</div>									
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label class="control-label">Rua</label>
											<input class="form-control" type="email" id="txtEndereco" name="txtEndereco" placeholder="Rua" required/>
										</div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<div class="form-group">
											<label class="control-label">Numero</label>
											<input class="form-control" type="number" id="txtNumero" name="txtNumero" placeholder="Numero" required/>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label class="control-label">Bairro</label>
											<input class="form-control" type="text" id="txtBairro" name="txtBairro" placeholder="Bairro" required/>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label class="control-label">Estado</label>
											<input class="form-control" type="text" id="txtEstado" name="txtEstado" placeholder="Estado" required/>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label class="control-label">Cidade</label>
											<input class="form-control" type="text" id="txtCidade" name="txtCidade" placeholder="Cidade" required/>
										</div>
									</div>
								</div>
							</div>
							<div class="cadastro-header text-center">
								<h2>Informações de Pagamento</h2>
							</div>
							<div class="cadastro-fields">
								<div class="metodoPagamento">
									<div class="form-group">
										<div class="radio">
											<label>
												<input name="inputMetodo" value="cartao" type="radio" class="btnRadioCart" /> 
												Cartão de Crédito
											</label>
										</div>
									</div>
									<div class="pagarCartao" style="display: none;">
										<div class="form-group">
											<div class="radio-inline">
												<label>
													<input type="radio" name="cartao" value="Visa">
													<img src="/images/cartao_visa.png" />														
												</label>
											</div>
											<div class="radio-inline">
												<label>
													<input type="radio" name="cartao" value="Mastercard"> 
													<img src="/images/cartao_mastercard.png" />
												</label>
											</div>
											<div class="radio-inline">
												<label> 
													<input type="radio" name="cartao" value="Elo"> 
													<img src="/images/cartao_elo.png" /> 
												</label>
											</div>
											<div class="radio-inline">
												<label>
													<input type="radio" name="cartao" value="Hipercard"> 
													<img src="/images/cartao_hipercard.png" />
												</label>
											</div>
											<div class="radio-inline">
												<label>
													<input type="radio" name="cartao" value="Hiper"> 
													<img src="/images/cartao_hiper.png" />
												</label>
											</div>
											<div class="radio-inline">
												<label>
													<input type="radio" name="cartao" value="American Express"> 
													<img src="/images/cartao_american.png" />
												</label>
											</div>
											<div class="radio-inline">
												<label>
													<input type="radio" name="cartao" value="Dinners"> 
													<img src="/images/cartao_dinners.png" />
												</label>
											</div>
										</div>
										<div class="cadastro-fields">
											<div class="row">
												<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
													<div class="form-group">
														<label class="control-label">Nome do cartão</label>
														<input  class="form-control" type="text" id="txtNomeCartao" name="txtNomeCartao" placeholder="Nome" required/>														
													</div>
												</div>
												<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
													<div class="form-group">
														<label class="control-label">CPF</label>
														<input class="form-control" type="text" id="txtCPF" name="txtCPF" placeholder="CPF" required/>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
													<div class="form-group">
														<label class="control-label">Numero do cartão</label>
														<input class="form-control" type="text" id="txtNumeroCartao" name="txtNumeroCartao" placeholder="Cartão" required/>														
													</div>
												</div>
												<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
													<div class="form-group">
														<label class="control-label">Mês</label>
														<input class="form-control" maxlength="2" type="text" id="txtMes" name="txtMes" placeholder="Mes" required/>														
													</div>
												</div>
												<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
													<div class="form-group">
														<label class="control-label">Ano</label>
														<input class="form-control"  maxlength="2" type="text" id="txtAno" name="txtAno" placeholder="Ano" required/>														
													</div>
												</div>
												<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
													<div class="form-group">													
														<label class="control-label">Código</label>
														<input class="form-control" maxlenght="3" type="text" id="txtCodigo" name="txtCodigo" placeholder="Codigo" required/>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
												<div class="form-group">
													<div class="checkbox">
														<label>
															<input id="checkBox" type="checkbox"> 
															Aceito os 
															<a href="#" data-toggle="modal" data-target="#listamed-modal-cadastro-termos">Termos de uso</a>	
														</label>
													</div>
												</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
												<button class="btn btn-theme-blue btnEnviar desativado" disabled="disabled" style="transition: 0.3s" onclick="enviarPagamento()" type="button">Enviar</button>
											</div>
										</div>  
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										</div>  
									</div>
								</div>
							</div>
						</fieldset>
						<div class="pagarBoleto" style="display: none;">
							<div class="col-lg-12 col-xs-12">
							Gerar boleto
							</div>
							<button class="btnEnviar" onclick="enviarPagamento()" type="button">Finalizar e gerar boleto</button>
						</div>
					</form>		
				</div>
			</div>
	    </div>
	    <?php include 'footer-pages.php'; ?>
	    <div class="page-modals">
	    	<div id="listamed-modal-cadastro-termos" class="modal fade">
	    		<div class="modal-dialog">
	    			<div class="modal-content">
	    				<div class="modal-header">
	    					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    					<h2 style="color:#01abeb;">Termos de Uso</h2>
	    				</div>
	    				<div class="modal-body">
							<?php echo $conteudo->termos; ?>	    					
	    				</div>
	    				<div class="modal-footer">
	    					<button type="button" class="btn btn-link btn-block" data-dismiss="modal" aria-label="Close">Fechar</button>
	    				</div>
	    			</div>
	    		</div>
			</div>
	    </div>
	</div>

	<script src="/js/jquery-1.12.4.min.js"></script>
	    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
	    <script src="<?php echo $caminho; ?>js/champs.min.js"></script>
	    <script src="<?php echo $caminho; ?>js/ouibounce.js"></script>
	    <script src="<?php echo $caminho; ?>js/script.js"></script>
	    </body>
	</html>
<script type="text/javascript">
	jQuery(".btnRadioCart").click(function(data){
		var radioSelecionado = $(this).val();
		if(radioSelecionado=="boleto"){
			$(".pagarCartao").fadeOut('fast');
			$(".pagarBoleto").fadeIn('slow');
		}else if(radioSelecionado=="cartao"){
			$(".pagarBoleto").fadeOut('fast');
			$(".pagarCartao").fadeIn('slow');
		}
	});
</script>

<script type="text/javascript">

	jQuery(document).ready(function($) {
		jQuery('.btnRadioCart').click(function(event) {

			var txtNome = jQuery('#txtNome').val();
			var txtEmail = jQuery('#txtEmail').val();
			var txtTel = jQuery('#txtTel').val();
			var txtEndereco = jQuery('#txtEndereco').val();
			var txtNumero = jQuery('#txtNumero').val();
			var txtBairro = jQuery('#txtBairro').val();
			var txtCEP = jQuery('#txtCEP').val();
			var txtEstado = jQuery('#txtEstado').val();
			var txtCidade = jQuery('#txtCidade').val();

			$.post('/enviar-cadastro.php', {txtNome: txtNome, txtEmail: txtEmail, txtTel: txtTel, txtEndereco: txtEndereco, txtNumero: txtNumero, txtBairro: txtBairro, txtCEP: txtCEP, txtEstado: txtEstado, txtCidade: txtCidade}, function(data, textStatus, xhr) {});
		});

		$("#txtCEP").blur(function() {
			 var cep = $(this).val().replace(/\D/g, '');

            if (cep != "") {
                var validacep = /^[0-9]{8}$/;
                if(validacep.test(cep)) {

                    $("#txtEndereco").val("...");
                    $("#txtBairro").val("...");
    	            $("#txtCidade").val("...");
                    $("#txtEstado").val("...");

                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            $("#txtEndereco").val(dados.logradouro);
                            $("#txtBairro").val(dados.bairro);
                            $("#txtCidade").val(dados.localidade);
                            $("#txtEstado").val(dados.uf);
                            
                            $("#txtNumero").focus();
                        } else {
                            alert("CEP não encontrado.");
                        }
                    });
                }
                else {
                    alert("Formato de CEP inválido.");
                }
            } 
        });

        jQuery("#checkBox").click(function(){
        	if($(this).is(":checked")){
       			jQuery('.btnEnviar').removeAttr('disabled');
       			jQuery('.btnEnviar').removeClass('desativado');
        	}else{
       			jQuery('.btnEnviar').attr('disabled','disabled');
       			jQuery('.btnEnviar').addClass('desativado');
        	}
        });


		$("#btnModalTermos").click(function(){
			var modal = new Modal(),
				clone = $("#ModalTermos").clone();
			modal.setContainer(clone[0]);
			modal.setClassModal("fade-in");
			modal.setClassModal("modal-exists");
			modal.setClassModalContainer("open");
			modal.setClassModalContainer("col-lg-9");
			modal.setClassModalContainer("col-sm-12");
			modal.setClassModalContainer("col-xs-10");
			modal.setClassModalContainer("offset-xs-1");
			modal.setClassModalContainer("container");
			modal.setClassModalContainer("center");
			modal.showModal();
			//jQuery('.modal-block--perfil').css('display','block');
			//jQuery('.modal-container').css('margin-top','0%');
		});

		jQuery('.modal-control--close').click(function(){
			jQuery('#ModalTermos').css('display','none');
		});

	});

</script>
<style type="text/css">
	ul.cartao_lista{ list-style: none; margin: 15px 0;padding: 0; }
	ul.cartao_lista li { float:left; }
	.termos-uso input{ width: auto; margin: 3px; }
	.termos-uso { margin: 25px 0px; }
	.desativado { opacity:0.1; }
	span#btnModalTermos{ color: #5bc0de; text-decoration: underline; cursor: pointer; }
</style>
