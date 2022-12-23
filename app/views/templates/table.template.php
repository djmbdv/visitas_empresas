<?php

class TableTemplate extends Template{


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
<div class="table-responsive">
<table class="table table-hover">
	<thead class="table-light">
	    <tr>
	    	<!--th>Seleccionar</th-->
<?php
foreach($this->T('table_vars') as  $value): ?>
			<th scope="col"><?= ucfirst( $value) ?></th>
<?php 
endforeach; 
		if(!$hide_create):?>
			<th scope="col">Fecha Creación</th>
		<?php
	endif;
		if(!$hide_modified):?>
			<th scope="col">Fecha Modificación</th>
		<?php
		endif;
		if(!$hide_actions):?> 
			<th scope="col">Acciones</th>
	    <?php endif; ?>
	    </tr>
	</thead>
	<tbody>
<?php
foreach($this->T('items') as $it):
	$it->load();?>
	<tr>
		<!--td class="text-center"><input type="checkbox" name=""></td-->
<?php
	foreach($this->T('table_vars') as $value):
	if(isset($this->T('modal_class')::array_presentation()[$value])):?>
		<td><?= $this->T('modal_class')::presentation_field($it,$value); ?></td>
	<?php
	elseif($it->get_attribute_type($value) == "mediumblob" ):?>
		<td><img src="<?= $it->{$value} ?>" class="image-table"></img></td>
<?php
	elseif(is_subclass_of($it->{$value}, "Model")): 
		 	?>
		<td><?=!is_null( $it->{$value}) && $it->{$value}->exist() ? $it->{$value}->to_str():'' ?></td>
<?php
	else:?>
		<td><?= $it->{$value} ?></td>
<?php
endif; 
endforeach; 
	if(!$hide_create):?>
		<td><?= $it->get_create_at() ?></td>
		<?php
	endif;
		if(!$hide_modified):?>
		<td><?= $it->get_modified_at() ?></td>
	<?php
		endif;
		if(!$hide_actions):?> 
		<td>
			<div class="btn-group" role="group" aria-label="Basic example">
			<button class="btn btn-view btn-info btn-sm" data-model="<?=  get_class($it)::classname() ?>" data-key="<?= $it->get_key() ?>"><i class="fa fa-eye"></i></button>
			<button class="btn btn-edit btn-warning btn-sm" data-model="<?=  get_class($it)::classname()?>" data-key="<?= $it->get_key() ?>"><i class="fa fa-pencil"></i></button>
			<button class="btn btn-delete btn-danger btn-sm" data-model="<?=  get_class($it)::classname()?>" data-key="<?= $it->get_key() ?>">
				<i class="fa fa-trash"></i></button>
			</div>
		</td>
	<?php endif;?>
	</tr>
<?php endforeach; ?>
	</tbody>
</table>
</div>
<?php
	}
}