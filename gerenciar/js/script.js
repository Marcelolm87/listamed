(function( $ ) {
	$.widget( "custom.combobox", {
		_create: function() {
			this.wrapper = $( "<span>" )
				.addClass( "custom-combobox" )
				.insertAfter( this.element );

			this.element.hide();
			this._createAutocomplete();
			this._createShowAllButton();
		},

		_createAutocomplete: function() {
			var selected = this.element.children( ":selected" ),
				value = selected.val() ? selected.text() : "";

			this.input = $( "<input>" )
				.appendTo( this.wrapper )
				.val( value )
				.attr( "title", "" )
				.addClass( "form-control custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
				.autocomplete({
					delay: 0,
					minLength: 0,
					source: $.proxy( this, "_source" )
				})
				.tooltip({
					tooltipClass: "ui-state-highlight"
				});

			this._on( this.input, {
				autocompleteselect: function( event, ui ) {
					ui.item.option.selected = true;
					this._trigger( "select", event, {
						item: ui.item.option
					});
				},

				autocompletechange: "_removeIfInvalid"
			});
		},

		_createShowAllButton: function() {
			var input = this.input,
				wasOpen = false;

			$( "<a>" )
				.attr( "tabIndex", -1 )
				.attr( "title", "Show All Items" )
				.tooltip()
				.appendTo( this.wrapper )
				.button({
					icons: {
						primary: "ui-icon-triangle-1-s"
					},
					text: false
				})
				.removeClass( "ui-corner-all" )
				.addClass( "custom-combobox-toggle ui-corner-right" )
				.mousedown(function() {
					wasOpen = input.autocomplete( "widget" ).is( ":visible" );
				})
				.click(function() {
					input.focus();

					// Close if already visible
					if ( wasOpen ) {
						return;
					}

					// Pass empty string as value to search for, displaying all results
					input.autocomplete( "search", "" );
				});
		},

		_source: function( request, response ) {
			var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
			response( this.element.children( "option" ).map(function() {
				var text = $( this ).text();
				if ( this.value && ( !request.term || matcher.test(text) ) )
					return {
						label: text,
						value: text,
						option: this
					};
			}) );
		},

		_removeIfInvalid: function( event, ui ) {

			// Selected an item, nothing to do
			if ( ui.item ) {
				return;
			}

			// Search for a match (case-insensitive)
			var value = this.input.val(),
				valueLowerCase = value.toLowerCase(),
				valid = false;
			this.element.children( "option" ).each(function() {
				if ( $( this ).text().toLowerCase() === valueLowerCase ) {
					this.selected = valid = true;
					return false;
				}
			});

			// Found a match, nothing to do
			if ( valid ) {
				return;
			}

			// Remove invalid value
			this.input
				.val( "" )
				.attr( "title", value + " didn't match any item" )
				.tooltip( "open" );
			this.element.val( "" );
			this._delay(function() {
				this.input.tooltip( "close" ).attr( "title", "" );
			}, 2500 );
			this.input.autocomplete( "instance" ).term = "";
		},

		_destroy: function() {
			this.wrapper.remove();
			this.element.show();
		}
	});
})( jQuery );

$(function() {
	$( "#marca_id" ).combobox();
	$( "#tipo_id" ).combobox();
	$( "#pessoa_id" ).combobox();


	$('#dataTable').DataTable();
	$('#dataTableMobile').DataTable();

	var logic = function( currentDateTime ){
		// 'this' is jquery object datetimepicker
		if( currentDateTime.getDay()==6 ){
			this.setOptions({
				minTime:'11:00'
			});
		}else
			this.setOptions({
				minTime:'8:00'
			});
	};
	jQuery('#inputData').datetimepicker({
		onChangeDateTime:logic,
		onShow:logic
	});

	$('.estado').on('change', function() {
		var estado = $(this).val();
		if(estado != '-'){
			var url = "/api/cidade/estado/"+estado;
			jQuery.getJSON(url, function(json, textStatus) {
				$('.cidade').find('option').remove().end().append('<option value="-">Selecione uma cidade</option>').val('-');
				jQuery.each(json.data , function(index, value){
					$('.cidade').append($('<option>', { 
				        value: value.id,
				        text : value.nome 
				    }));
				});
			});
		}
	});

    $('.btnCep').on('click', function() {
        var cep = $('.cepBuscar').val();
        var medico = $('.idMedico').val();
		var items = [];
		
		$.getJSON( "/gerenciar/ajax-cep.php", { cep: cep }).done(function( data ) {
			if ($.isEmptyObject(data)){
				$('.ulExibirConsultorio').html('');
			 	items.push('<tr><td colspan="3"> Não encontramos nenhum consultório nesse CEP</td></tr>');
				$('.ulExibirConsultorio').append( items.join('') );
				$('.exibirConsultorios').fadeIn("slow");
			}else{
				$('.ulExibirConsultorio').html('');
				console.log(data);
				$.each(data, function(i, item) {
				 	items.push('<tr><td>' + item.id + '</td><td>' + item.nome + ' ( ' + item.endereco + ', ' + item.numero +') ' + '</td><td><a onclick="adicionarConsultorio('+item.id+','+medico+',\''+item.nome+'\')" class="btn btn-xs btn-danger"  >Adicionar</a></td></tr>');
				});
				$('.ulExibirConsultorio').append( items.join('') );
				$('.exibirConsultorios').fadeIn("slow");
			}
		});

    });  

	$('.adicionarEspecialidade').on('click', function() {
		var especialidade = $('.especialidade option:selected').val();
		var codigoMedico  = $('.idMedico').val();
		var especialidadeNome = $('.especialidade option:selected').html();

		$.post( "/gerenciar/ajax-especialidade.php", { acao: 'add', especialidade: especialidade, codigoMedico: codigoMedico }).done(function( data ) {
			
			var text = "<td>"+especialidade+"</td><td>"+especialidadeNome+"</td><td><a class='btn btn-xs btn-danger'>Deletar</a></td>";

			$('.tabelaEspecialidade').append($('<tr>', { 
		        rel: especialidade
		    }));
			$('tr[rel='+especialidade+']').append($('<td>', { html: especialidade }));
			$('tr[rel='+especialidade+']').append($('<td>', { html: especialidadeNome }));
			$('tr[rel='+especialidade+']').append($('<td>', { 
				rel: especialidade
			}));
			$('td[rel='+especialidade+']').append($('<a>', { 
				onclick: 'removerEspecialidade('+especialidade+','+codigoMedico+')', 
				class: 'btn btn-xs btn-danger',
				html: 'Deletar'
			}));

		});
	});
	$('.adicionarConvenio').on('click', function() {
		var convenio = $('.convenio option:selected').val();
		var codigoMedico  = $('.idMedico').val();
		var convenioNome = $('.convenio option:selected').html();

		$.post( "/gerenciar/ajax-convenio.php", { acao: 'add', convenio: convenio, codigoMedico: codigoMedico }).done(function( data ) {
			
			var text = "<td>"+convenio+"</td><td>"+convenioNome+"</td><td><a class='btn btn-xs btn-danger'>Deletar</a></td>";

			$('.tabelaConvenio').append($('<tr>', { 
		        rel: convenio
		    }));
			$('tr[rel='+convenio+']').append($('<td>', { html: convenio }));
			$('tr[rel='+convenio+']').append($('<td>', { html: convenioNome }));
			$('tr[rel='+convenio+']').append($('<td>', { 
				rel: convenio
			}));
			$('td[rel='+convenio+']').append($('<a>', { 
				onclick: 'removerConvenio('+convenio+','+codigoMedico+')', 
				class: 'btn btn-xs btn-danger',
				html: 'Deletar'
			}));

		});
	});


	$('.adicionarConvenioConsultorio').on('click', function() {

		var convenio = $('.convenio option:selected').val();
		var codigoConsultorio  = $('.idConsultorio').val();
		var convenioNome = $('.convenio option:selected').html();

		$.post( "/gerenciar/ajax-consultorio.php", { acao: 'add', convenio: convenio, codigoConsultorio: codigoConsultorio }).done(function( data ) {
			
			var text = "<td>"+convenio+"</td><td>"+convenioNome+"</td><td><a class='btn btn-xs btn-danger'>Deletar</a></td>";

			$('.tabelaConvenio').append($('<tr>', { 
		        rel: convenio
		    }));
			$('tr[rel='+convenio+']').append($('<td>', { html: convenio }));
			$('tr[rel='+convenio+']').append($('<td>', { html: convenioNome }));
			$('tr[rel='+convenio+']').append($('<td>', { 
				rel: convenio
			}));
			$('td[rel='+convenio+']').append($('<a>', { 
				onclick: 'removerConsultorioConvenio('+convenio+','+codigoConsultorio+')', 
				class: 'btn btn-xs btn-danger',
				html: 'Deletar'
			}));

		});
	});




	$('.adicionarConsultorio').on('click', function() {
		var consultorio = $('.consultorio option:selected').val();
		var codigoMedico  = $('.idMedico').val();
		var consultorioNome = $('.consultorio option:selected').html();

		$.post( "/gerenciar/ajax-consultorio.php", { acao: 'add', consultorio: consultorio, codigoMedico: codigoMedico }).done(function( data ) {
			
			var text = "<td>"+consultorio+"</td><td>"+consultorioNome+"</td><td><a class='btn btn-xs btn-danger'>Deletar</a></td>";

			$('.tabelaConsultorio').append($('<tr>', { 
		        rel: consultorio
		    }));
			$('tr[rel='+consultorio+']').append($('<td>', { html: consultorio }));
			$('tr[rel='+consultorio+']').append($('<td>', { html: consultorioNome }));
			$('tr[rel='+consultorio+']').append($('<td>', { 
				rel: consultorio
			}));
			$('td[rel='+consultorio+']').append($('<a>', { 
				onclick: 'removerConsultorio('+consultorio+','+codigoMedico+')', 
				class: 'btn btn-xs btn-danger',
				html: 'Deletar'
			}));

		});
	});

	$('#data_inicial').datepicker({
	    format: "dd/mm/yyyy",
	    endDate: "today",
	    language: "pt-BR",
	    orientation: "bottom auto",
	    dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab']
	});
	$('#data_final').datepicker({
	    format: "dd/mm/yyyy",
	    endDate: "today",
	    language: "pt-BR",
	    orientation: "bottom auto",
	    dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab']
	});	


});

function uploadInput() {
	var $uploadCrop;

	function readFile(input) {
			if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
				$('.upload-demo').addClass('ready');
            	$uploadCrop.croppie('bind', {
            		url: e.target.result
            	}).then(function(){
            		console.log('jQuery bind complete');
            	});
            	
            }
            
            reader.readAsDataURL(input.files[0]);
        }
        else {
	        swal("Sorry - you're browser doesn't support the FileReader API");
	    }
	}

	$uploadCrop = $('#upload-demo').croppie({
		viewport: {
			width: 270,
			height: 270,
			type: 'square'
		},
		enableExif: true
	});

	$('#upload').on('change', function () { readFile(this); });
	$('.upload-result').on('click', function (ev) {
		$uploadCrop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (resp) {
			$('#imagebase64').val(resp);
		});
	});
}

function removerEspecialidade(especialidade, codigoMedico){
	$.post( "/gerenciar/ajax-especialidade.php", { acao: 'delete', especialidade: especialidade, codigoMedico: codigoMedico }).done(function( data ) {
		$('tr[rel='+especialidade+']').fadeOut('slow');
    });

    $('tr[rel="'+especialidade+'"]').fadeOut("slow");
}
function removerPergunta(pergunta){
	$.post( "/gerenciar/ajax-pergunta.php", { acao: 'delete', pergunta: pergunta }).done(function( data ) {
		$('tr[rel='+pergunta+']').fadeOut('slow');
    });

    $('tr[rel="'+pergunta+'"]').fadeOut("slow");
}

function removerConvenio(convenio, codigoMedico){
	$.post( "/gerenciar/ajax-convenio.php", { acao: 'delete', convenio: convenio, codigoMedico: codigoMedico }).done(function( data ) {
		$('tr[rel='+convenio+']').fadeOut('slow');
    });
    $('tr[rel="'+convenio+'"]').fadeOut("slow");
}
function removerConsultorioConvenio(convenio, codigoConsultorio){
	$.post( "/gerenciar/ajax-consultorio.php", { acao: 'delete', convenio: convenio, codigoConsultorio: codigoConsultorio }).done(function( data ) {
		$('tr[rel='+convenio+']').fadeOut('slow');
    });
    $('tr[rel="'+convenio+'"]').fadeOut("slow");
}

function removerConsultorio(consultorio, codigoMedico){
	$.post( "/gerenciar/ajax-consultorio.php", { acao: 'delete', consultorio: consultorio, codigoMedico: codigoMedico }).done(function( data ) {
		$('tr[rel='+consultorio+']').fadeOut('slow');
    });
    $('tr[rel="'+consultorio+'"]').fadeOut("slow");
}
function removerServico(servico, codigoConsultorio){
	$.post( "/gerenciar/ajax-servico.php", { acao: 'delete', servico: servico, consultorio: codigoConsultorio }).done(function( data ) {
		$('tr[rel='+servico+']').fadeOut('slow');
    });
    $('tr[rel="'+servico+'"]').fadeOut("slow");
}
function removerExperiencia(experiencia, codigoMedico){
	$.post( "/gerenciar/ajax-experiencia.php", { acao: 'delete', experiencia: experiencia, codigoMedico: codigoMedico }).done(function( data ) {
		$('tr[rel='+experiencia+']').fadeOut('slow');
    });
    $('tr[rel="'+experiencia+'"]').fadeOut("slow");
}

function removerGaleria(imagem, consultorio){
	$.post( "/gerenciar/ajax-galeria.php", { acao: 'delete', consultorio: consultorio, imagem: imagem }).done(function( data ) {
		$('tr[rel='+imagem+']').fadeOut('slow');
    });
    $('tr[rel="'+imagem+'"]').fadeOut("slow");
}


function removerBanner(id){
	$.post( "/gerenciar/ajax-banner.php", { acao: 'delete', id: id }).done(function( data ) {
		$('tr[rel='+id+']').fadeOut('slow');
    });
    $('tr[rel="'+id+'"]').fadeOut("slow");
}


function adicionarConsultorio(consultorio, medico, consultorio_nome){
	var consultorio = consultorio;
	var codigoMedico  = medico;
	var consultorioNome = consultorio_nome;

	$.post( "/gerenciar/ajax-consultorio.php", { acao: 'add', consultorio: consultorio, codigoMedico: codigoMedico }).done(function( data ) {
		var retorno = JSON.parse(data);
		if(retorno.status==200){

		}else{
			var text = "<td>"+consultorio+"</td><td>"+consultorioNome+"</td><td><a class='btn btn-xs btn-danger'>Deletar</a></td>";
			$('.tabelaConsultorio').append($('<tr>', { 
				rel: consultorio
			}));
			$('tr[rel='+consultorio+']').append($('<td>', { html: consultorio }));
			$('tr[rel='+consultorio+']').append($('<td>', { html: consultorioNome }));
			$('tr[rel='+consultorio+']').append($('<td>', { 
				rel: consultorio
			}));
			$('td[rel='+consultorio+']').append($('<a>', { 
				onclick: 'removerConsultorio('+consultorio+','+codigoMedico+')', 
				class: 'btn btn-xs btn-danger',
				html: 'Deletar'
			}));
			
		}

	});
}

function atualizarCidades(estado, cidade){

	var url = "/api/cidade/estado/"+estado;
	jQuery.getJSON(url, function(json, textStatus) {
		$('.cidade').find('option').remove().end().append('<option value="-">Selecione uma cidade</option>').val('-');
		jQuery.each(json.data , function(index, value){
			$('.cidade').append($('<option>', { 
		        value: value.id,
		        text : value.nome 
		    }));
		});

		$('select[name="endereco[tb_cidade_id]"] option').filter(function() { 
		    return ($(this).text() == cidade); 
		}).prop('selected', true);
	});
}

new nicEditor({fullPanel : true}).panelInstance('texto');
/*new nicEditor({fullPanel : true}).panelInstance('texto2');*/
new nicEditor({fullPanel : true}).panelInstance('texto3');
new nicEditor({fullPanel : true}).panelInstance('texto4');
new nicEditor({fullPanel : true}).panelInstance('texto5');
new nicEditor({fullPanel : true}).panelInstance('planos_texto1');
new nicEditor({fullPanel : true}).panelInstance('planos_texto2');
new nicEditor({fullPanel : true}).panelInstance('planos_texto3');
