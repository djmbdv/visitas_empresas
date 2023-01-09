<?php
class HomeTemplate extends Template{

	function config(){
		$this->set_parent("layout");
		$this->add_part("pin","pin");
	}

	function render(){
		/*

*/	$this->add_part("campoVisitado","campo",
		 array('name' => "visitado" ,
		 		'autocomplete' => false,
		 		'required' => true,
		 		'placeholder'=> "Nombre de la persona a visitar",
		 		'end_point'=> '/api/employees/',
		 		'autocomplete_att'=>'s',
		 		'add_class' => 'col-md-12',
		 		'form_type' => 'select',
		 		'attributes'=>  array('s' => "" ),
		 		'size'=> 'lg'
		  )
		);
$this->add_part("campoSection","campo",
		 array('name' => "section" ,
		 		'autocomplete' => false,
		 		'required' => true,
		 		'placeholder'=> "Oficina donde se dirige",
		 		'end_point'=> '/api/sections/',
		 		'autocomplete_att'=>'s',
		 		'clase'=> 'section',
		 		'add_class' => 'col-md-6',
		 		'form_type' => 'select',
		 		'attributes'=>  array('s' => "" ),
		 		'size'=> 'lg',
		 		'children' => ['inputVisitado']
		  )
		);
$this->add_part("campoWorkspace","campo",
		 array('name' => "workspace" ,
		 		'autocomplete' => false,
		 		'required' => true,
		 		'placeholder'=> "Torre a donde se dirige",
		 		'end_point'=> '/api/workspaces/',
		 		'autocomplete_att'=>'s',
		 		'clase'=> 'workspace',
		 		'add_class' => 'col-md-6',
		 		'form_type' => 'select',
		 		'size'=> 'lg',
		 		'autoload'=>true,
		 		'attributes'=>  array('s' => "" ),
		 		'children' => ['inputSection']
		  )
		);

	$this->render_part("pin");
		?>

<div class="fullscreen bg-white">
<a class="btn btn-sm" href="/logout/"><i class="fa fa-sign-out fa-sm fa-fw mr-2 text-gray-400"></i></a>
<a class="btn btn-sm btn-pin-modal" href="#"><i class="fa fa-cog fa-sm fa-fw mr-2 text-gray-400"></i></a>
<div class="container">
<h1 class="text-center  mt-3 mb-2">Control de Visitas</h1>
<div class="row" style="border-top: solid 1px  #007bff;">
	<div class="col-md-6 text-center">
		<h4 class="text-center p-3 mt-3"><?=  $this->T("user")->titulo  ?? "Complejo Habitacional RPS" ?></h4>
		<img class="img-fluid shadow-2-strong"  src="<?=  $this->T("user")->image  ?? $this->S("images/casita.png") ?>" style="box-shadow: 1px 3px; max-width: 80%; margin: 40px;background-color: white;">
	</div>

	<div class="col-md-6">
		<h4 class="text-center p-3 mt-3">DATOS</h4> 
		<form  class="form-row" action="/foto" method="post">

			<?php $this->render_part("campoWorkspace");?>
			<?php $this->render_part("campoSection");?>
			<?php $this->render_part("campoVisitado");?>
			<div class="form-group  col-md-12">
				<input class="form-control form-control-lg " type="text" name="nombre" placeholder="Su Nombre y Apellido" required="" />
			</div>
			<div class="form-group  col-md-12">
				<input class="form-control form-control-lg " type="text" name="identificacion" placeholder="Numero de Identificacion" required="" />
			</div>
			<div class="form-group  col-md-12">
				<input class="form-control btn-primary" type="submit" name="" value="Tomar Foto" />
			</div>
		</form>
	</div>
</div>

</div>
</div>
<?php 

	}
}