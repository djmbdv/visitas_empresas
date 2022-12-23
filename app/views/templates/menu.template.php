<?php
class MenuTemplate extends Template{

	function config(){
		$this->set_parent("layout");
		$this->add_part("topbar","topbar");	
	}

	function render(){?>
<?php $this->render_part("topbar"); ?>
<div class="container mb-4 pb-4">
<h1 class="text-center">
Menú</h1>
<div class="row m-4 pb-4">
	<div class="col">
<a href="/dashboard/" class="btn btn-primary btn-block p-3 mt-4"><i class="fa fa-wrench fa-lg fa-3x m-2"></i><b style="font-size: 1.5rem;">Dashboard</b></a>
</div>
	<div class="col">
<a href="/activec/" class="btn btn-info btn-block p-3 mt-4"> <i class="fa  fa-key fa-lg fa-3x m-2"></i><b style="font-size: 1.5rem;"> Activar Control de Visitas</b></a>
</div>

</div>
</div>
<?php 

	}
}