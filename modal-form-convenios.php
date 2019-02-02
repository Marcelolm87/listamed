<div id="listamed-modals-medicos-convenios" class="modal fade">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body medico">
				<div class="medico-convenios">
					<div class="container-fluid">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h2>Convênios</h2>				
						<ul class="medico-convenios-list list list-items--block">
							<?php if(!empty($convenios)): 	?>
								<?php foreach ($convenios as $kConv => $vConv) : ?>
									<li class="list--item"> <?php echo $vConv->nome; ?> </li>
								<?php endforeach; ?>
							<?php endif; ?>

						</ul>						
					</div>
				</div>				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link btn-block" data-dismiss="modal" aria-label="Close">Fechar</button>
			</div>
		</div>
	</div>
</div>
