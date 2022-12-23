<?php
class ModalresidenteTemplate extends Template{
	public $camara;

function config(){
	$this->camara = false;
	foreach ($this->T("modal_vars") as $v){
		preg_match("/([\S]*)Model/", $this->T("modal_class")::get_attribute_class($v), $matches);
		$campo = array('name' => "$v" ,
				'label' => ucfirst($v),
		 		'autocomplete' => is_subclass_of($this->T("modal_class")::get_attribute_class($v), 'Model') && !isset( $this->T("modal_class")::form_types_array()[$v] ),
		 		'required' => true,
		 		'autoload'=>false,
		 		'placeholder'=> $this->T("modal_class")::search_description($v),
		 		'end_point'=> isset($matches[1])? '/api/'.strtolower($matches[1]).'s/':null,
		 		'autocomplete_att'=>'s',
		 		'form_type' => $this->T("modal_class")::search_attribute_form_type($v),
		 		'clase' => isset($matches[1])?strtolower($matches[1]):""
		  ); 
		if($campo['form_type'] == 'foto')$this->camara = true; 

		$this->add_part("campo".ucfirst($v),"campo", $campo);
	}
	$this->add_part("campoEdificio","campo",
		 array('name' => "edificio" ,
		 		'autocomplete' => false,
		 		'required' => true,
		 		'label' =>"Edificio",
		 		'placeholder'=> "Seleccione un Edificio",
		 		'end_point'=> '/api/edificios/',
		 		'autocomplete_att'=>'s',
		 		'clase'=> 'edificio',
		 	//	'add_class' => 'col-md-6',
		 		'form_type' => 'select',
		 //		'size'=> 'lg',
		 		'autoload'=>true,
		 		'attributes'=>  array('s' => "" ),
		 		'children' => ['inputApartamento']
		  )
		);
}
	
function render(){?>
	<div class="modal <?= $this->camara ? "modal-camara":"" ?>  fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header  bg-warning text-white d-flex ">
	        <h5 class="modal-title" id="formModalLabel">Agregar <?= $this->T("title") ?></h5>
	        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
	        </button>
	      </div>
	      <div class="modal-body">
	        <form id="form-modal" method="post">
	        <?php $this->render_part("campoEdificio"); ?>
			  <?php foreach ($this->T("modal_vars") as $v):
			  	$this->render_part("campo".ucfirst($v));
			  	?>
			  <?php endforeach; ?>
			 </form>
	      </div>
	      <div class="modal-footer d-flex justify-content-center">
	        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Cerrar</button>
	        <button type="button" class="btn btn-warning save-modal">Guardar</button>
	      </div>
	    </div>
	  </div>
	</div>
<?php
	}
}