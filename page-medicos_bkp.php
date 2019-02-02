<?php include 'header.php'; ?>
    <?php 
        $filtro = null;
       if(isset($_GET['filtro'])){
            $filtro = $_GET['filtro'];
        }  

        // Quantidade de posts
        $numposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'medico'");
        if (0 < $numposts) $numposts = number_format($numposts);
    ?>

    <div class="center col-lg-12">
        <a name="inicio"></a>
        <div class="row">
            <div class="container center">
                <div class="row col-lg-9 col-md-8">
                    <div class="btn-medicos--top">
                        <div class="btn-medicos--busca mobile-show tablet-show">
                            <p>
                                Buscando por
                            </p>
                            <h1>Dr. Fernando</h1>
                        </div>
                        <div class="btn-medicos--group">                    
                            <a href="<?php bloginfo('url'); ?>/medicos/?filtro=profissional" class="btn <?php if($filtro != null && $filtro == 'profissional') echo 'active'; ?>"><span>Profissional</span> <strong>(<?php echo $numposts; ?>)</strong></a>  
                            <a href="<?php bloginfo('url'); ?>/medicos/?filtro=centro-medico" class="btn <?php if($filtro != null && $filtro == 'centro-medico') echo 'active'; ?>"> <span>Centros Médicos</span> <strong>(27)</strong></a>  
                            <div class="right mobile-hide tablet-hide notebook-hide">
                                 <div class="nav-pag-header">
                                  <?php 
                                        
                                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                                        $query = "post_type=medico&post_status=publish&paged=$paged";
                                        query_posts($query);

                                        while(have_posts()):
                                            the_post();
                                            $post = get_post();        
                                            $postId = $post->ID;
                                            $nome = $post->post_title;
                                            $tipo = get_post_meta($postId, 'wpcf-tipo', true); 
                                            $foto = get_post_meta($postId, 'wpcf-foto-medico', true); 
                                            $convenios = get_post_meta($postId, 'wpcf-convenios', true);  
                                            $cidade = get_post_meta($postId, 'wpcf-cidade', true);  
                                            $crm = get_post_meta($postId, 'wpcf-crm', true);   
                                            $especializacao = get_post_meta($postId, 'wpcf-especializacao', true); 
                                            $telefone = get_post_meta($postId, 'wpcf-telefone', true); 
                                            $site = get_post_meta($postId, 'wpcf-site', true);

                                            $telefone = substr($telefone, 0, 11)."...Ver Telefone";
                                            $site = substr($site, 0, 15)."...Ver Site";
                                        endwhile;

                                        if (function_exists('wp_corenavi')) {wp_corenavi();  wp_reset_query();}     

                                    ?>                           
                                </div>
                            </div>                      
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="page-medico--destaque col-xs-12 mobile-show tablet-show">
            <div class="container">
                <h3>Destaque</h3>
            </div>
            <div class="center page-medico--destaque-wrapper">
                <div class="container">
                    <div class="col-xs-4">
                        <div class="destaque-img">
                            <a href="<?php the_permalink(); ?>"><img src=" <?php echo $foto; ?>"/></a>
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <div class="destaque-detalhes container">
                            <h1>
                                <?php echo $nome; ?>
                            </h1>
                            <h2>
                                <?php echo $especializacao; ?>
                            </h2>
                            <h3>
                                CRM <?php echo $crm; ?>
                            </h3>
                            <h4>
                                <p>
                                    Avenida Washington Luiz, 3985  Sala 94 | Centro 
                                    Presidente Prudente - SP CEP 098...
                                </p>
                            </h4>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="destaque-button-group row">
                            <a href="<?php the_permalink(); ?>" class="btn"><i class="fa fa-phone"></i>Ligar</a>
                            <a href="<?php the_permalink(); ?>" class="btn"><i class="fa fa-mouse-pointer"></i>Ver site</a>
                            <a href="<?php the_permalink(); ?>" class="btn">Agendar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container center">
                <div class="row">
                    <div class="container col-lg-9 col-md-9 left page-medicos--adapt">
                        <div class="page-medicos--title text-center mobile-hide tablet-hide">
                            <p>
                                Nome | Especialidade
                            </p>
                        </div>
                        <?php 
                            
                            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                            $query = "post_type=medico&post_status=publish&paged=$paged";
                            query_posts($query);

                            while(have_posts()):
                                the_post();
                                $post = get_post();        
                                $postId = $post->ID;
                                $tipo = get_post_meta($postId, 'wpcf-tipo', true); 
                                $foto = get_post_meta($postId, 'wpcf-foto-medico', true); 
                                $convenios = get_post_meta($postId, 'wpcf-convenios', true);  
                                $cidade = get_post_meta($postId, 'wpcf-cidade', true);  
                                $crm = get_post_meta($postId, 'wpcf-crm', true);   
                                $especializacao = get_post_meta($postId, 'wpcf-especializacao', true); 
                                $telefone = get_post_meta($postId, 'wpcf-telefone', true); 
                                $site = get_post_meta($postId, 'wpcf-site', true);


                                $telefone = substr($telefone, 0, 11)."...Ver Telefone";
                                $site = substr($site, 0, 15)."...Ver Site";

                        ?>
                            <div class="page-medicos--detalhes row mobile-hide tablet-hide">
                                <div class="page-medicos--list">
                                    <div class="page-medicos--align container">
                                        <div class="col-lg-8 container">
                                            <div class="col-lg-5">
                                                <div class="page-medicos--img container">
                                                    <a href="<?php the_permalink(); ?>"><img src=" <?php echo $foto; ?>"/></a>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="page-medicos--perfil container">
                                                    <h1>
                                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                    </h1>
                                                    <h2>
                                                        <?php echo $especializacao; ?>
                                                    </h2>
                                                    <h3>
                                                        <p>
                                                            <i class="fa fa-map-marker"></i> <?php echo $cidade; ?>
                                                        </p>
                                                    </h3>
                                                    <h4>
                                                        <p>
                                                            Convênios<br/>
                                                        </p>
                                                        <?php echo $convenios; ?>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-medicos--info text-center">
                                                <a class="btn" href="<?php the_permalink(); ?>"><i class="fa fa-phone"></i><?php echo $telefone; ?></a>
                                            </div>
                                            <div class="page-medicos--info text-center">
                                                <a class="btn" href="<?php the_permalink(); ?>"><i class="fa fa-mouse-pointer"></i><?php echo $site; ?></a>
                                            </div>
                                            <div class="page-medicos--info-pre text-center">
                                                <p>Sua pré-consulta rápida e fácil!</p>
                                                <a class="btn" href="<?php the_permalink(); ?>">Agendar Pré-consulta</a>
                                            </div>  
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="medicos--mobile-border">
                                <div class="page-medicos--mobile-detalhes mobile-show tablet-show row">
                                    <div class="medicos--mobile-container">
                                        <div class="col-xs-4">
                                            <div class="medicos-mobile--img container">
                                                <a href="<?php the_permalink(); ?>"><img src=" <?php echo $foto; ?>"/></a>
                                            </div>
                                        </div>
                                        <div class="col-xs-8">
                                            <div class="medicos-mobile--detalhes container">
                                                <h1>
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h1>
                                                <h2>
                                                    <?php echo $especializacao; ?>
                                                </h2>
                                                <h3>
                                                    CRM <?php echo $crm; ?>
                                                </h3>
                                                <div class="medicos-mobile--button">
                                                    <a href="<?php the_permalink(); ?>" class="btn"><i class="fa fa-phone"></i>Ligar</a>
                                                    <a href="<?php the_permalink(); ?>" class="btn text-center">Agendar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        
                            <div class="page-medicos--pages text-center mobile-hide tablet-hide"> 
                                <div class="nav-pag">
                                    <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
                                </div>
                                <div class="navigation">
                                    <div class="nav-previous left"><?php previous_posts_link( __( '< Anterior', 'listamed' ) ); ?></div>
                                    <div class="nav-next right"><?php next_posts_link ( __( 'Próxima >', 'listamed' ) ); ?></div>
                                </div>  
                            </div>
                    </div>                                                            
                    <div class="col-lg-3 col-md-3 container right mobile-hide tablet-hide">
                        <div class="page-medicos--blocks">         
                        </div>
                        <div class="page-medicos--blocks">               
                        </div>
                        <div class="page-medicos--blocks">          
                        </div>
                    </div>       
                </div>  
                <div class="page-medicos--pages text-center mobile-show tablet-show"> 
                    <div class="nav-pag">
                        <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
                    </div>
                    <div class="navigation">
                        <div class="nav-previous left"><?php previous_posts_link( __( '< Anterior', 'listamed' ) ); ?></div>
                        <div class="nav-next right"><?php next_posts_link ( __( 'Próxima >', 'listamed' ) ); ?></div>
                    </div>  
                </div>  
                <div class="text-center medicos-mobile--ancora mobile-show">
                    <p><a href="#inicio">Voltar ao topo <i class="fa fa-arrow-up"></i></a></p>
                </div>
            </div>
        </div>
    </div>


    

<?php include 'footer.php'; ?>
