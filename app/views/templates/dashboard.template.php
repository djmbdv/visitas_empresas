<?php
class DashboardTemplate extends Template{

	function config(){
		$this->set_parent("layout");
		$this->add_part("topbar","topbar");	
	}

	function render(){?>
<?php $this->render_part("topbar"); ?>
<div class="container mb-4 text-center" style="padding-bottom: 6rem;">
	<h1 class="text-center m-2 p-4">Dashboard</h1>
	<a href="./edificios/" class="btn btn-primary m-2 p-3 px-4" style="height: 3rem;"><i class="fa fa-building fa-lg"></i> Crear Edificio</a>
	<a href="./apartamentos/" class="btn btn-primary m-2 p-3 px-4" style="height: 3rem;"><i class="fa fa-home fa-lg"></i> Crear Apartamento</a>
	<a href="./residentes/" class="btn btn-warning m-2 p-3 px-4" style="height: 3rem;"><i class="fa fa-users fa-lg "></i> Residentes</a>
	<a href="./visitas/" class="btn btn-info m-2 p-3 px-4" style="height: 3rem;"><i class="fa fa-users fa-lg"></i> Ver Visitas</a>
	
<?php
	$t = $this->T("user")->tipo;
	$t->load();
 if( $t->descripcion == "admin"):?>
	<a href="./usuarios/" class="btn btn-dark m-2 p-3" style="height: 3rem;"><i class="fa fa-user fa-lg"></i> Usuarios</a>
	<a href="./administracion/" class="btn btn-danger m-2 p-3" style="height: 3rem;"><i class="fa fa-money fa-lg"></i> Administración</a>
<?php endif;?>
<a href="./account/" class="btn btn-light m-2 p-3" style="height: 3rem;"><i class="fa fa-cog fa-lg"></i> Cuenta</a>
</div>
<?php 
	}
}