            <?php require_once("config.php"); ?>
            <?php $conteudo2 =   json_decode(file_get_contents("http://listamed.com.br/api/page", false, stream_context_create($arrContextOptions))); ?>

            <footer class="row page-footer page-footer--position" id="page-footer">
                <div class="row page-footer--cinza">
                    <div class="container center">
                        <div class="col-lg-2 mobile-hide tablet-hide">
                            <a href="<?php echo $caminho; ?>seja">Sou profissional da área</a>
                        </div>
                        <div class="right mobile-hide tablet-hide">
                            <nav class="nav-footer">
                                <ul>
                                    <li><a href="<?php echo $caminho; ?>sobre">Sobre a ListaMed</a></li>
                                    <li><a href="<?php echo $caminho; ?>perguntas-frequentes">Perguntas Frequentes</a></li>
                                    <li><a href="<?php echo $caminho; ?>blog">Blog</a></li>
                                    <li><a href="<?php echo $caminho; ?>contato">Contato</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="text-center mobile-show tablet-show">
                            <nav class="nav-footer">
                                <ul>
                                    <li><a href="<?php echo $caminho; ?>sobre">Sobre a ListaMed</a></li>
                                    <li><a href="<?php echo $caminho; ?>cadastro">Sou profissional da área</a></li>
                                    <li><a href="<?php echo $caminho; ?>perguntas-frequentes">Perguntas Frequentes</a></li>
                                    <li><a href="<?php echo $caminho; ?>blog">Blog</a></li>
                                    <li><a href="<?php echo $caminho; ?>contato">Contato</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row page-footer--branco">
                    <div class="container center">
                        <div class="col-lg-1">
                            <a href="<?php echo $caminho; ?>"><img src="<?php echo $caminhoOnline; ?>images/logo-internas-bot.png" /></a>
                        </div>
                        <div class="page-footer--perfil-cfm mobile-hide tablet-hide">
                            <div class="col-lg-1 page-footer-perfil-img"> 
                                <a href="https://portal.cfm.org.br/" target="_blank"><img src="<?php echo $caminhoOnline; ?>images/logo-cfm.png" alt="" /></a>
                                
                            </div>
                            <div class="col-lg-6 page-footer-perfil-text">
                                <p>ListaMED é desenvolvida dentro das normas e termos do CFM e da CODAME.</p>
                            </div>
                        </div>
                        <div class="right social-icons-align">
                                <a href="<?php echo $conteudo2->instagram; ?>"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
                                <a href="<?php echo $conteudo2->facebook; ?>"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                                <a href="<?php echo $conteudo2->linkedin; ?>"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                        </div> 
                    </div>
                </div>                  
                <div class="row page-footer--escuro">
                    <div class="container center">
                        <div class="col-lg-4 page-footer--copyright mobile-hide tablet-hide">
                            <p>TODOS OS DIREITOS RESERVADOS - LISTAMED <?php echo date('Y'); ?> ®</p>
                        </div>
                        <div class="col-lg-4 page-footer--copyright center mobile-show tablet-show">
                            <p>TODOS OS DIREITOS RESERVADOS - LISTAMED <?php echo date('Y'); ?> ®</p>
                        </div>
                        <div class="right page-footer--dev mobile-hide tablet-hide">
                            <p>Feito por 
                                <a href="http://www.wdezoito.com.br/" target="_blank"><img src="<?php echo $caminho; ?>images/logo-w18.png" /></a>
                            </p>
                        </div>
                        <div class="page-footer--dev center mobile-show tablet-show">
                            <p>Feito por 
                                <a href="http://www.wdezoito.com.br/" target="_blank"><img src="<?php echo $caminho; ?>images/logo-w18.png" /></a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        <script src="/js/jquery-1.12.4.min.js"></script>
        <script src="<?php echo $caminho; ?>js/mapa.js"></script>
        <script src="<?php echo $caminho; ?>js/markerclusterer.js"></script>
    <!--     <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script> -->
        <script src="<?php echo $caminho; ?>js/champs.min.js"></script>
        <script src="<?php echo $caminho; ?>js/form.js"></script>
        <?php if($busca['nome']): ?>
            <script type="text/javascript">
                ga('send', 'pageview', '/medicos.php?q=<?php echo $_GET['buscar']; ?>');
            </script>
        <?php endif; ?>
    </body>
</html>