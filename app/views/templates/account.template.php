<?php
class AccountTemplate extends Template{

	function config(){
		$this->set_parent("layout");
		$this->add_part("topbar","topbar");
		$this->add_part("campoNombre","campo",
		 array('name' => "name" ,
		 		'autocomplete' => false,
		 		'required' => true,
		 		'label' =>"Nombre",
		 		'placeholder'=> "Nombre Completo",

		 		'clase'=> 'user',
		 		'value' => $this->T('user')->name,
		  )
		);
		$this->add_part("campoPassword","campo",
		 array('name' => "password" ,
		 		'autocomplete' => false,
		 		'required' => false,
		 		'label' =>"Contraseña",
		 		'placeholder'=> "(Sin Cambio)",
		 		'form_type' => "password",
		 		'clase'=> 'user',
		 		'value' => "",
		  )
		);
		$this->add_part("campoTitulo","campo",
		 array('name' => "titulo" ,
		 		'autocomplete' => false,
		 		'required' => true,
		 		'label' =>"Título",
		 		'placeholder'=> "Título",
		 		'clase'=> 'user',
		 		'value' => $this->T('user')->titulo
		  )
		);
	}

	function render(){
		$this->render_part("topbar"); 
		?>
<div class="container pb-4 mb-4">
	<a class="btn " href=".."><i class="fa fa-arrow-left"></i> Menú </a>
<form class="row" id="form-modal" method="put" action="/dashboard/usuarios">
	<div class="container">
	<h1 class="text-center">Account</h1>
	<?php $this->render_part("campoNombre");?>
	<?php $this->render_part("campoPassword");?>
	<?php $this->render_part("campoTitulo");?>
	<input type="hidden" name="key" value="<?= $this->T('user')->get_key() ?>">
	<a class="btn btn-warning save-modal mt-3" name="">Guardar</a>
</div>
</div>		
</div>
<?php 
	}
}
