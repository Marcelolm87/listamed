<?php

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
	$a['prev_text'] = '<'; //texto para o link "Página seguinte"
    $a['next_text'] = '>'; //texto para o link "Página anterior"
	 
	if ($max > 1) echo '<div>';
		echo $pages . paginate_links($a);
	if ($max > 1) echo '</div>';
}
