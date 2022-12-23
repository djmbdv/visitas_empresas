<?php

/**
 * 
 */
class SaludoTemplate extends Template
{
	
	function config()
	{
		$this->set_parent("layout");
	}
	function render(){?>
<a class="btn btn-sm" href="/logout/" style="box-shadow: 1px 3px;"><i class="fa fa-sign-out fa-sm fa-fw mr-2 text-gray-400"></i></a>
<div class="container">
<h1 class="text-center  mt-3 mb-2">Control de Visitas</h1>
<div class="row" style="border-top: solid 1px  #007bff; border-radius: 3px;">
	<div class="col-md-6 text-center">
		<h5 class="text-center p-3 mt-3"><?=  $this->T("user")->titulo  ?? "Complejo Habitacional RPS" ?></h5>
		<img class="img-fluid shadow-2-strong"  src="<?=  $this->T("user")->image  ?? $this->S("images/casita.png") ?>" style="box-shadow: 1px 3px; max-width: 80%; margin: 40px;background-color: white;">
	</div>

	<div class="col-md-6 text-center">
		<h4 class="text-center p-3 mt-3">Visita Registrada</h4>
		<img src="data:image/png;base64,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" class="m-3 p-4">
		<h2 class="text-center p-3 mt-3">Gracias</h2> 
		<a class="btn btn-primary mt-3 text-center" href="/">Volver</a>
	</div>
</div>
</div>
<script type="text/javascript">
	setTimeout(function() {
		window.location = "/"
	}, 3000);
</script>


<?php
	}
}