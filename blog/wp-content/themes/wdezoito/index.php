<?php
/**
 * @package Wdezoito
 */

get_header(); ?>

<div class=" col-lg-9 col-md-9 col-sm-9 col-xs-12" >
	<div class="content">
		<?php 
		    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		    $args = array(
		        'prev_next'          => false,
		        'prev_text'          => '<',
		        'next_text'          => '>',
		        'post_status'        => 'publish',
		        'paged' => $paged,
		    );

		    $posts = query_posts($args);
		    while(have_posts()):
		        the_post();
		        $postId = $post->ID;
		        $titulo = $post->post_title;
		        $categoria = get_the_category( $postId ); 
		        $conteudo = strip_tags (get_the_content());
		?>
		    <div class="boxPost">
		        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12" >
		        	<?php $imagem_destaque = get_field_object( "field_594a80e75b1bb", $postId ); ?>
		            <h1 class="postTitulo"><a class="linkTitulo" href="<?php the_permalink(); ?>" ><?php echo $titulo; ?></a></h1>
		            <div class="traco"> </div>
		            <p class="infoTexto">por <?php echo the_author_meta( 'display_name' , $v->post_author ); ?> / <?php echo $categoria[0]->name; ?> / <?php echo get_the_date( $format, $postId )?></p>
		            <?php if($imagem_destaque['value']!=""):?>
		            	<div class="imagemPost" style="background-image: url('<?php echo $imagem_destaque['value']['url']; ?>')" ></div>
		        	<?php endif; ?>
		            <div class="PostText"><?php echo substr($conteudo, 0, 500); ?>...</div>
		        </div>
		        <a class="btnLeiaMais" href="<?php the_permalink(); ?>" > LEIA MAIS </a>
		    </div>
		<?php endwhile; ?>   
		<div class="paginacao">
		    <div class="numeros">
		    <?php if(function_exists('wp_corenavi')) { wp_corenavi(); } ?>
		    </div>   
		    <div class="pageTotal">
		        <?php
		            echo "página ";
		            echo $paged;
		            echo " de ";
		            global $wp_query;
		            echo $wp_query->max_num_pages;
		        ?>
		    </div>   
		</div>   
	</div>
</div>
<div class=" col-lg-3 col-md-3 col-sm-3 col-xs-12" >
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>