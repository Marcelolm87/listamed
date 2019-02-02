<?php
	add_action('init', 'type_post_medico');
 
	function type_post_medico() { 
		$labels = array(
			'name' => _x('medico', 'post type general name'),
			'singular_name' => _x('medico', 'post type singular name'),
			'add_new' => _x('Adicionar Novo', 'Novo item'),
			'add_new_item' => __('Novo Item'),
			'edit_item' => __('Editar Item'),
			'new_item' => __('Novo Item'),
			'view_item' => __('Ver Item'),
			'search_items' => __('Procurar Itens'),
			'not_found' =>  __('Nenhum registro encontrado'),
			'not_found_in_trash' => __('Nenhum registro encontrado na lixeira'),
			'parent_item_colon' => '',
			'menu_name' => 'Médicos'
		);
 
		$args = array(
			'labels' => $labels,
			'public' => true,
			'public_queryable' => true,
			'show_ui' => true,			
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => null,
			'register_meta_box_cb' => 'servicos_meta_box',		
			'supports' => array('title','editor','thumbnail','comments', 'excerpt', 'custom-fields', 'revisions', 'trackbacks')
          );
 
			register_post_type( 'medico' , $args );
			flush_rewrite_rules();
}

//////////////////////////////////////////////////////////////////////////
///        FUNCAO PARA FAZER PAGINAÇÃO                                  /////
////////////////////////////////////////////////////////////////////////
function wp_corenavi() {
		global $wp_query, $wp_rewrite;
		$pages = '';
		$max = $wp_query->max_num_pages;
		if (!$current = get_query_var('paged')) $current = 1;
		$a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
		$a['total'] = $max;
		$a['current'] = $current;
		 
		$total = 1; //1 - display the text "Page N of N", 0 - not display
		$a['mid_size'] = 5; //how many links to show on the left and right of the current
		$a['end_size'] = 1; //how many links to show in the beginning and end
		 
		if ($max > 1) echo '<div>';
			echo $pages . paginate_links($a);
		if ($max > 1) echo '</div>';
	}

////////////////////////////////////////////////////////////////////
/////// FUNÇÃO PARA CONTROLE DA API
////////////////////////////////////////////////////////////////////
function getFullMedico($id){
	$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_PORT => "82",
		  CURLOPT_URL => "http://projetos.wdezoito.com.br:82/listamed-back/dev2/medico/".$id."/full",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		));

		$response = json_decode(curl_exec($curl));
		$err = curl_error($curl);

		curl_close($curl);
	    return $response->data;
}
	
?>
