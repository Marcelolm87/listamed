<?php
// Do not delete these lines
    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');
 
?>
 
<div id="comments">
    <h3><?php comments_number('0 Comentários', '1 Comentário', '% Comentários' );?></h3>
 
    <?php if ( have_comments() ) : ?>
 
        <ol class="commentlist">
        <?php wp_list_comments('type=comment'); ?>
    </ol>
 
        <?php if ($wp_query->max_num_pages > 1) : ?>
        <div class="pagination">
        <ul>
            <li class="older"><?php previous_comments_link('Anteriores'); ?></li>
            <li class="newer"><?php next_comments_link('Novos'); ?></li>
        </ul>
    </div>
    <?php endif; ?>
 
    <?php endif; ?>
 
    <?php if ( comments_open() ) : ?>
 
    <div id="respond">
            <h3>Deixe o seu comentário!</h3>
 
            <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
            <fieldset>
                <?php if ( $user_ID ) : ?>
 	                <p>Autentificado como <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(); ?>" title="Sair desta conta">Sair desta conta &raquo;</a></p>
                <?php else : ?>
 					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-reset" >
	                	<input type="text" name="author" id="author" placeholder="Nome" value="<?php echo $comment_author; ?>" />
	 				</div>
 					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-reset" >
	                	<input type="text" name="email" id="email" placeholder="E-mail" value="<?php echo $comment_author_email; ?>" />
	 				</div>
                <?php endif; ?>
 
                
                <textarea name="comment" id="comment" rows="" cols=""> Mensagem </textarea>
 
                <input type="submit" class="commentsubmit" value="Enviar Comentário" />
 
                <?php comment_id_fields(); ?>
                <?php do_action('comment_form', $post->ID); ?>
            </fieldset>
        </form>
        <p class="cancel"><?php cancel_comment_reply_link('Cancelar Resposta'); ?></p>
        </div>
     <?php else : ?>
        <h3>Os comentários estão fechados.</h3>
<?php endif; ?>
</div>