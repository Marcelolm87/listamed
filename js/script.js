
// function removePonto(ponto){
//     if(ponto['id_onibus']>0){
//         if (typeof markers[ponto['id_consultorio']] === "undefined"){
//             console.log('Ponto novo no mapa'); 
//         }else{
//             console.log('Atualizou a posição de um ponto'); 
//             markers[ponto['id_consultorio']].setMap(null);
//         }
//     }
// }

// function addPonto(ponto)
// {
// 		var image = {
//         url: '/images/marcador.png',
//         size: new google.maps.Size(48, 48),
//         origin: new google.maps.Point(0, 0),
//         anchor: new google.maps.Point(0, 32)
//     };
// 	$.getJSON( "https://maps.googleapis.com/maps/api/geocode/json?address="+ponto+"&key=AIzaSyCBQVaqBA6BwvVbTX_rw7ttjEIMTi8cxXg", function( data ) {
// 		var myLatLng = {lat: data.results[0].geometry.location.lat, lng: data.results[0].geometry.location.lng};
// 			map = new google.maps.Map(document.getElementById('map2'), {
// 		  center: myLatLng,
// 		  zoom: 15,
// 		  scrollwheel: false
// 		});
// 	    var marker = new google.maps.Marker({
// 	        position: myLatLng,
// 	        map: map,
// 	        icon: image
// 	    });
//     	markers[ponto['id_consultorio']] = [ marker ];
// 	});	
// }


function enviarPagamento(){


	$(".btnEnviar").css('background-color', 'transparent');
	$(".btnEnviar").css('color', '#000');
	$(".btnEnviar").css('padding', 'padding: 12px 0px;');
	$(".btnEnviar").html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw" style="font-size:18px; margin-right:5px;"></i>Enviando');


	var tipoPagamento = document.getElementById("formPagamento");
	if(tipoPagamento.elements["inputMetodo"].value=="cartao"){

		var AuxTelefone = document.getElementById('txtTel').value.trim().replace(/[^0-9]/g,'');
		var idPedido = Math.floor(Math.random() * 65536);
		var cartaoAux = document.getElementById('txtNumeroCartao').value.trim().replace(/\s/g, "");
		//alert(cartaoAux);
		
		var dados = { 
		    sessao_id: document.getElementById('txtSessao').value.trim(),
		    cartao_numero: cartaoAux,
		    cartao_codigo: document.getElementById('txtCodigo').value.trim(),
		    cartao_mes: document.getElementById('txtMes').value.trim(),
		    cartao_ano: document.getElementById('txtAno').value.trim(),
		    cartao_bin: document.getElementById('txtNumeroCartao').value.trim().substring(1, 6),
		    cartao_bandeira: '',
		    cartao_hash: '',
		    cartao_token: '',
		    email_notificacoes: 'seuemail@email.com.br',
		    pedido_id: idPedido,
		    url_retorno: 'http://listamed.com.br/retorno.php?code=',
		    comprador_nome: document.getElementById('txtNome').value.trim(),
		    comprador_cpf: document.getElementById('txtCPF').value.trim(),
		    comprador_ddd: AuxTelefone.substring(0,2),
		    comprador_telefone: AuxTelefone.substring(2,11),
		    comprador_email: document.getElementById('txtEmail').value.trim(), //'joao@sandbox.pagseguro.com.br',
		    endereco_endereco: document.getElementById('txtEndereco').value.trim(),
		    endereco_numero: document.getElementById('txtNumero').value.trim(),
		    endereco_bairro: document.getElementById('txtBairro').value.trim(),
		    endereco_cep: document.getElementById('txtCEP').value.trim(),
		    endereco_cidade: document.getElementById('txtCidade').value.trim(),
		    endereco_estado: document.getElementById('txtEstado').value.trim(),
		    endereco_pais: 'BRA',
		    valor_extra: '0',
		    parcelas_quantidade: '1',
		    valor_total: '1',
		    cobranca_endereco: document.getElementById('txtEndereco').value.trim(),
		    cobranca_numero: document.getElementById('txtNumero').value.trim(),
		    cobranca_bairro: document.getElementById('txtBairro').value.trim(),
		    cobranca_cep: document.getElementById('txtCEP').value.trim(),
		    cobranca_cidade: document.getElementById('txtCidade').value.trim(),
		    cobranca_estado: document.getElementById('txtEstado').value.trim(),
		    cobranca_pais: 'BRA',
		    cartao_nome: document.getElementById('txtNomeCartao').value.trim(),
		    cartao_nascimento: '01/01/1990',
		    cartao_ddd: AuxTelefone.substring(0,2),
		    cartao_telefone: AuxTelefone.substring(2,11),
		    cartao_cpf: document.getElementById('txtCPF').value.trim(),
		    produto_sequencial: '001',
		    produto_descricao: 'Listamed',
		    produto_quantidade: '1',
		    produto_valor: '1'
		};

	    PagSeguroDirectPayment.setSessionId(dados.sessao_id);
	    dados.cartao_hash = PagSeguroDirectPayment.getSenderHash();

	    PagSeguroDirectPayment.getBrand({
	            cardBin: dados.cartao_numero.substring(0, 6),
	            success: function(response) {
	                brand = response.brand;
	                dados.cartao_bandeira = brand.name;
	                var param = {
	                        cardNumber: dados.cartao_numero,
	                        cvv: dados.cartao_codigo,
	                        expirationMonth: dados.cartao_mes,
	                        expirationYear: dados.cartao_ano,
	                        success: function(response) {
	                            dados.cartao_token = response.card.token;
								
								$.post('ajax-pagamento.php', {dados: dados}, function(data, textStatus, xhr) {
									if(data==1){
										window.location= dados.url_retorno+"error";
									}else{
										window.location= dados.url_retorno+"ok";
									}
								});

	                        },
	                        error: function(response) {
	                            alert("Erro ao gerar token");
	                        },
	                        complete: function(response) {}
	                    }
	                param.brand = brand.name;
	                PagSeguroDirectPayment.createCardToken(param);

/*					$.post('ajax-pagamento.php', {dados: dados}, function(data, textStatus, xhr) {
						alert("enviou");
						
console.log(data);

						if(data==1){
							//window.location= dados.url_retorno+"error";
						}else{
							//window.location= dados.url_retorno+"ok";
						}
					});*/
	            },
	            error: function(response) {
	                alert("Cartão Invalido");
	            },
	            complete: function(response) {
	            }
	    });


	}
}

var CidadeEstado = function(){
  this.jsonPath = "/js/estados-cidades.json"
}
CidadeEstado.prototype.listarEstados = function(config){
  var path = this.jsonPath;
  $.ajax({
    dataType: 'json',
    type: 'get',
    url: path,
    success: function(results){
      var result = results.estados,
          selector = document.getElementById(config.selector),
          rows = Object.keys(result).length;
      for(var i = 0; i < rows; i++){
          var item = result[i], 
          option = document.createElement("option");
          option.setAttribute("value", item.sigla);
          option.innerHTML =  item.nome;
         // selector.appendChild(option);
        }
      }
  });
}

CidadeEstado.prototype.listarCidades = function(config){
    var path = this.jsonPath;
    $.ajax({
      dataType: 'json',
      type: 'get',
      url: path,
      success: function(results){
        var result = results.estados,
            selector = document.getElementById(config.selector),
            rows = Object.keys(result).length,
            items = selector.children,
            itemsSize = items.length;
        $("#"+config.selector).empty();
        var first = document.createElement("option");
        first.setAttribute("value", "");
        first.innerHTML="Cidade";
        selector.appendChild(first);
        for(var i = 0; i < rows; i++){
          var item = result[i]; 
          if(config.estado == item.sigla){
            var cidades = item.cidades;
            for(var e = 0; e < cidades.length; e++){
              var option = document.createElement("option");
              option.setAttribute("value", cidades[e]);
              option.innerHTML = cidades[e];
              selector.appendChild(option); 
            }
          }
        }
      }
    });
}

$(document).ready(function () {
		
	var cidadeestado = new CidadeEstado();
	cidadeestado.listarEstados({
		selector: "ddlEstado"
	});

	 $("#ddlEstado").on("change", function(){
	 	/*selectClear("ddlCidade");*/
	 	var idEstado = $(this).val();
	 	cidadeestado.listarCidades({
	 		selector: "ddlCidade", 
	 		estado: idEstado
	 	})
	});

});
