<?php
class HabitantesTemplate extends Template{

	function config(){
		$this->set_parent("layout");
		$this->add_part("paginator","paginator");
		$this->add_part("topbar","topbar");
		$this->add_part("table","table");
		$this->add_part("modalresidente","modalresidente");
		$this->add_part("viewmodal","viewmodal");
		$this->add_part("askmodal","askmodal");
	}

	function render(){
		$c = $this->T("count");
		$p = $this->T("page");
		$this->render_part("topbar"); 
		$this->render_part("modalresidente");
		$this->render_part("viewmodal");
		$this->render_part("askmodal");
		?>

<div class="container">
	<a class="btn " href=".."><i class="fa fa-arrow-left"></i> Menú </a>
	<div class="row">
	<h1 class="text-center"><?= $this->T('title') ?></h1>
	<div class="col-md-3 col-sm-6">
	<a type="button"  data-toggle="modal" data-target="#formModal" class="btn btn-add btn-warning m-3"><i class="fa fa-user"></i> Nuevo Residente</a>
	</div>
	<hr/>
<?php 
if($c > 0): 
	$this->render_part("table");
 else: ?>
	<h1>No hay Registros</h1>
<?php endif; ?>
</div>
<?php $this->render_part("paginator");?>
</div>
<?php 

	}
}