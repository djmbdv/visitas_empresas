<?php
class AskmodalTemplate extends Template{

	public function render(){
?>
<div class="modal" id="askModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header  bg-danger text-white d-flex justify-content-center">
        <h5 class="modal-title">Confirmación</h5>
      </div>
      <div class="modal-body">
        <p>¿Está seguro de realizar esta acción?</p>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger btn-aceptar">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<?php
	}
}