<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php include 'header-pages.php'; ?>
<?php
	require_once "classes/pagseguro.php";
	$sessionCode = PagSeguro::getSessionCode()->getResult();
?>
	<!-- DESKTOP -->
	<div class="page-bg page-bg--index layout-control--js layout-height--full layout-container--center " style="min-height: 450px;">
		<div class="col-lg-12 col-md-12 col-sm-12 container center cadastro row">
			<div class="text-center col-reset cadastro-block--text container center">
				<h1>Sua solicitação foi enviada com sucesso!</h1>
			</div>
			<div class="row">
				<label> Aguarde nosso contato! </label>
			</div>
		</div>
	</div>
	<!-- DESKTOP -->

<?php include 'footer-pages.php'; ?>
<style type="text/css">
.cadastro-block--text h1 {
    color: #01abeb;
    float: left;
    font-size: 22px;
    padding: 0;
    margin: 70px 0 15px 0;
    display: inline-block;
    text-align: center;
}
</style>