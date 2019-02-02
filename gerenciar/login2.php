<?php session_start();
	if ((isset($_POST['userLogin']))&&(isset($_POST['userLogin']))):
		if(($_POST['userLogin']=="wdezoito")&&($_POST['userSenha']=="listamed")):
			$_SESSION['logado'] = "5Yf2bM5pbpYZ7eJAOxf0bUvfsLTaRPu2u5muYjl90MvkkwMJci";
			header("Location: index.php");
		else:
			$msg = "Login invalido! Tente novamente!";
		endif;
	endif;
?>
<div class="content-wrapper">
	<div class="container">
		<div class="row">
		   <div class="col-md-12">
				<?php if(isset($msg)):?>
					<div class="alert alert-success">
						<?php echo $msg; ?>
					</div>
				<?php endif; ?>
		   </div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="page-head-line">Efetuar o login </h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<form action="login.php" method="post">
					<label>Login:</label>
					<input name="userLogin" type="text" class="form-control" />
					<label>Senha:</label>
					<input name="userSenha" type="password" class="form-control" />
					<hr />
					<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-user"></span> Logar</button>
				</form>
			</div>
		</div>
	</div>
</div>
