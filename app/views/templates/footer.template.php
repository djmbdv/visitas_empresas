<?php

class FooterTemplate extends Template{
	function render(){?>
      <footer class="pt-4 my-md-10 pt-md-10  border-top text-center">
        <div class="row">
          <div class="col-12 col-md">
            <h5 class="mb-2" >Control de Visitas</h5>
            <small class="d-block mb-3 text-muted"> Remote PC Solutions &copy; <?= date('Y'); ?></small>
          </div>
        </div>
      </footer>
    <script src="<?= $this->S("js/jquery-3.2.1.min.js") ?>"></script>
    <script src="<?= $this->S("js/popper.min.js") ?>"></script>
    <script src="<?= $this->S("js/bootstrap.bundle.min.js") ?>"></script>
    <script src="<?= $this->SS("js/custom.js") ?>"></script>
  </body>
</html>

<?php	}
}