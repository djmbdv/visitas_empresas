<?php

class PinTemplate extends Template{



	public function render(){
		?>
		<div class="modal fade" id="pinModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header  bg-warning text-white d-flex ">
	        <h5 class="modal-title" >Introduzca Pin de Acceso</h5>
	        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
	        </button>
	      </div>
	      <div class="modal-body">
					<input type="inputPinModal" name=""> <button class="btn-secondary btn"><i class="fa fa-unlock-alt"></i> Acceder</button>
				</div>
				</div>
			</div>
		</div>
		<?php
	}

}