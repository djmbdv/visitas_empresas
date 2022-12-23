<?php
class ErrorTemplate extends Template
{
	
	function config()
	{
		$this->set_parent("layout");
	}
	function render(){?>
	<div class="container p-2">
		<img src="<?= $this->S("images/casita.png") ?>" style="box-shadow: 1px 3px; border-radius: 30%; width: 200px; margin: 100px;">
		<h1>Error 404</h1>
	</div>
	<?php
	}
}