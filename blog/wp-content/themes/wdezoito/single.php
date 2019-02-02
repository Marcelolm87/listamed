<?php
/**
 * @package Wdezoito
 */
get_header(); ?>
<div class=" col-lg-9 col-md-9 col-sm-9 col-xs-12" >
	<div class="content single">
		<?php 
			while (have_posts()) :
				the_post();
				$postID = get_the_ID();
				$categoria = get_the_category($postID);
				$data = get_the_date( $format, $postID );
				$autor = get_the_author();
				$posttags = get_the_tags();
				$categoria = get_the_category( $postID ); 
				$conteudo = get_the_content();

		        $imagem = get_field_object( "field_594a7c0020809", $postID );
		        $imagem_destaque = get_field_object( "field_594a80e75b1bb", $postID );
		?>

 		    	<div class="boxPost">
		            <h1 class="postTitulo"><?php the_title(); ?></h1>
		            <div class="traco"> </div>
		            <p class="infoTexto">por <?php echo the_author_meta( 'display_name' , $v->post_author ); ?> / <?php echo $categoria[0]->name; ?> / <?php echo get_the_date( $format, $postId )?></p>
		            <?php if($imagem_destaque['value']!=""): ?>
		            <div class="imagemPost" style="background-image: url('<?php echo $imagem_destaque['value']['url']; ?>')" ></div>
		            <?php endif; ?>
		            <div class="PostText"><?php the_content(); ?></div>
		        </div>

		<?php endwhile; ?> 
		<?php comments_template(); ?>
	</div>
</div>
<div class=" col-lg-3 col-md-3 col-sm-3 col-xs-12" >
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
<script async src="//static.addtoany.com/menu/page.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".owl-carousel").owlCarousel();
	});
</script>