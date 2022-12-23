<?php

/**
 * 
 */
class FotoTemplate extends Template
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

	<div class="col-md-6">
		<h5 class="text-center p-3 mt-3">TOMAR FOTO</h5> 
		<form class="form-foto" action="/visita/" method="post" >
			<div class="form-group">
				<input type="hidden" name="nombre" value="<?= $this->T('nombre') ?>"/>
				<input type="hidden" name="apartamento" value="<?= $this->T('apartamento') ?>" />
				<input type="hidden" name="visitado" value="<?= $this->T('visitado') ?>" />
				<input type="hidden" name="identificacion" value="<?= $this->T('id') ?>">
				<input id="inputFoto" type="hidden" name="foto" value=""/>
			    <div id="captura"  class="mx-2 p-2" style="border-radius: .2rem;;min-height: 150px; min-width: 250px;background-color: gray;" >
			    	<p class="info-foto text-center" style="color: white;font-weight: bold;"></p>
			    	<video id="video" style="width:100%;border-radius: .2rem;;min-width: 250px;background-color: gray;"></video>
			    	<canvas id="canvas" style="display: none;"></canvas>
			    </div>
			    <div class="button-photo btn-sm mt-2 btn-success text-center " style="margin-right: auto;margin-left: auto;" disabled>Tomar Foto</div>
			</div>
			<div class="form-group">
				<input class="btn-form-foto form-control btn-primary " type="submit" name="" value="Enviar" disabled/>
			</div>
		</form>
	</div>
</div>
</div>
<?php
	}
}