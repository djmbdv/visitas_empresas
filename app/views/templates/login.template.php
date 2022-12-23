<?php

class LoginTemplate extends Template
{
	
	function config(){
		$this->set_parent("layout");
	}

	function render(){
?>
<style type="text/css">
html,body {
  height: 100%;
}
body {
  display: -ms-flexbox;  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
}
.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}
.form-signin .checkbox {
  font-weight: 400;
}
.form-signin .form-control {
  height: auto;
  padding: 10px;
  font-size: 16px;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}</style>
    <div class="text-center">
      <form class="form-signin" method="post">
        <img class="mb-4" src="<?=$this->S("images/casita.png")?>" alt="" style="width: 50px;background-color: blue;">
    <?php
       	if($this->T("error") == 1):?>
       	<h5 class="text-danger">Error en los datos</h5>
    <?php endif; ?>
        <h1 class="h3 mb-3 font-weight-normal">Acceso</h1>
        <label for="inputEmail" class="sr-only">Usuario</label>
        <input type="text" name="username" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    </div>
<?php
	}
}