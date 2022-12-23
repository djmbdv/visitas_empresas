<?php

/**
 * 
 */
class HeaderTemplate extends Template
{
	
	function render(){?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <link rel="icon" href="<?= $this->S("favicon.png")?>"/>
    <title>Sistema de Control de Visitas</title>
    <link href="<?= $this->S("css/bootstrap.min.css")?>" rel="stylesheet"/>
    <link  href="<?= $this->S("css/mdb.min.css")?>" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link href="<?= $this->S("css/font-awesome.min.css")?>" rel="stylesheet"/>
    <link href="<?= $this->SS("css/custom.css")?>" rel="stylesheet"/>
  </head>
  <body>
<?php	
  }
}