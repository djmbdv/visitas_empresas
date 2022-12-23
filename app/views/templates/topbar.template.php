<?php

class TopbarTemplate extends Template{
  function render(){
?><nav class="navbar navbar-expand navbar-dark  bg-dark topbar mb-4 static-top shadow" >
  <div class="container-fluid">
  <a class="navbar-brand mr-0 mr-md-2" href="/menu/" aria-label="Visitas">
    <img src="<?= $this->S('images/casita.png')?>" style="max-height: 50px;border-radius: 10px;" />
  </a>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown no-arrow d-sm-none">
      <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-search fa-fw"></i>
      </a>
    </li>
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-bell fa-fw"></i>
        <span class="badge badge-danger badge-counter">1+</span>
      </a>
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
          Nuevas Visitas
        </h6>
        <a class="dropdown-item text-center small text-gray-500" href="#">Mostrar Todo</a>
      </div>
    </li>
    <div class="topbar-divider d-none d-sm-block">
    </div>
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->T('user')->username ?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="/menu/">
          <i class="fa fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
          Menú 
        </a>
        <a class="dropdown-item" href="/dashboard/">
          <i class="fa fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
          Dashboard 
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="/logout">
          <i class="fa fa-sign-out fa-sm fa-fw mr-2 text-gray-400"></i>
          Salir
        </a>
      </div>
    </li>
  </ul>
</div>
</nav>
<?php }}