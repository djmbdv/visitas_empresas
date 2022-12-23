<?php

class EdificiosgridTemplate extends Template{


	function render(){ 
		$c = $this->T("count");
		$p = $this->T("page");

    $hide_create =$this->T("hide_create");
    $hide_modified = $this->T("hide_modified");
    $hide_actions = $this->T("hide_actions");
		?>
<div class="modal  fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	   <div class="modal-body">
	   	<img id="imageTable" style="width: 100%" src=""/>
	   </div>
	   <div class="modal-footer d-flex justify-content-center">
	        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Cerrar</button>
	        
	      </div>
	    </div>
	   
	   </div>
</div>
<div class="d-flex flex-wrap">

<?php
foreach($this->T('items') as $it):
	$it->load();?>
	<div class="card text-center border-dark mb-2 py-1">
		<img style="width: 100px;" class="px-auto mx-auto " src="<?= $this->S("images/edificio.png") ?>" class="card-img-top" alt="<?= $it->nombre ?>">
  		<div class="card-body">	
		
		 <h5 class="card-title"><?= $it->nombre ?></h5>

	
		
			<div class="btn-group" role="group" aria-label="Basic example">
			<button class="btn btn-view btn-info btn-sm" data-model="<?=  get_class($it)::classname() ?>" data-key="<?= $it->get_key() ?>"><i class="fa fa-eye"></i></button>
			<button class="btn btn-edit btn-warning btn-sm" data-model="<?=  get_class($it)::classname()?>" data-key="<?= $it->get_key() ?>"><i class="fa fa-pencil"></i></button>
			<button class="btn btn-delete btn-danger btn-sm" data-model="<?=  get_class($it)::classname()?>" data-key="<?= $it->get_key() ?>">
				<i class="fa fa-trash"></i></button>
			</div>
		
	</div>
</div>
<?php endforeach; ?>
</div>
<?php
	}
}