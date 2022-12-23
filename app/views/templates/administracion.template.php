<?php
class AdministracionTemplate extends Template{

	function config(){
		$this->set_parent("layout");
		$this->add_part("paginator","paginator");
		$this->add_part("topbar","topbar");	
		$this->add_part("admintable","admintable");

		$this->filtros =  $this->T("filtros");
		

	}

	function render(){
		$c = $this->T("count");
		$p = $this->T("page");
		?>
<?php $this->render_part("topbar"); ?>
<div class="container">
	<a class="btn " href=".."><i class="fa fa-arrow-left"></i> Menú </a>
	<div class="row">
	<h1 class="text-center">Administración</h1>

	<hr/>
<?php $this->render_part("admintable");?>
</div>
<?php $this->render_part("paginator");?>
</div>
<?php 
	}
}