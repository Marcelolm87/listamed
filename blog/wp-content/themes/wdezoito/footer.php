<?php
/**
 *
 * @package Wdezoito
 */
?>
</div>

<script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.min.js"></script>

<div class="page">
	<footer class="page-footer">
	    <div class="page-footer--light">
	        <div class="container">
	            <div class="row">
	                <div class="col-xs-12 col-sm-2 col-md-3 col-lg-4">
	                    <div class="page-footer--links">
	                        <ul class="list list-items--inline">
	                            <li class="list--item">
	                                <a href="http://listamed.com.br">
	                                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" />
	                                </a>                                    
	                            </li>
	                            <li class="list--item cfm">
	                                <a href="https://portal.cfm.org.br/" target="_blank">
	                                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo-cfm.png" alt="" />
	                                </a>
	                            </li>
	                        </ul>                               
	                    </div>
	                </div>  
	                <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
	                    <p>ListaMED é desenvolvida dentro das normas e termos do CFM e da CODAME.</p>
	                </div>
	                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
	                    <?php $conteudo2 =   json_decode(file_get_contents("http://listamed.com.br/api/page", false, stream_context_create($arrContextOptions))); ?>
	                    <div class="page-footer--links text-right">
	                        <ul class="list list-items--inline">
	                            <li class="list--item">
	                                <a href="<?php echo $conteudo2->instagram; ?>"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>                                      
	                            </li>
	                            <li class="list--item">
	                                <a href="<?php echo $conteudo2->facebook; ?>"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>                                      
	                            </li>
	                            <li class="list--item">
	                                <a href="<?php echo $conteudo2->linkedin; ?>"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>                                      
	                            </li>
	                        </ul>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>                  
	    <div class="page-footer--dark">
	        <div class="container">
	            <div class="row">
	                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
	                    <div class="page-footer--copyright">
	                        <p>Todos os direitos reservados - ListaMED <?php echo date('Y'); ?> ®</p>                               
	                    </div>
	                </div>                      
	                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	                    <div class="page-footer--dev">
	                        <p>
	                            Feito por 
	                            <a href="http://www.wdezoito.com.br/" target="_blank">
	                            	<img src="<?php echo get_template_directory_uri(); ?>/images/logo-w18.png" />
	                            </a>
	                        </p>
	                        
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</footer>	
</div>
</body>
</html>