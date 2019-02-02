<?php if(isset($retorno)):?>
  <div class="row">
      <div class="col-md-12">
					<?php if($retorno):?>
          <div class="alert alert-success">
              Registro salvo com sucesso.
          </div>
					<?php else: ?>
          	<div class="alert alert-danger">
              Não foi possivel salvar esse registro.
            </div>
					<?php endif; ?>
      </div>
  </div>
<?php endif; ?>
<?php if(isset($retornoDel)):?>
  <div class="row">
      <div class="col-md-12">
					<?php if($retornoDel):?>
          <div class="alert alert-success">
              Registro deletado com sucesso.
          </div>
					<?php else: ?>
          	<div class="alert alert-danger">
              Não foi possivel deletar esse registro.
            </div>
					<?php endif; ?>
      </div>
  </div>
<?php endif; ?>
