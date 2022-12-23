<?php
class PaginatorTemplate extends Template{

  public function l_param(){
    $l = "";
    if($this->T("filtros"))
    foreach ($this->T("filtros") as $key => $value) {
      if(isset($value))$l.="$key=$value\$";
    }
    return $l;
  }
	function render(){
		$c = $this->T("count");
		$p = $this->T("page");
		?>
<ul class="pagination justify-content-center " >
  <li class="page-item <?= ($p - 1  < 1 )?"disabled":"" ?>" >
    <a class="page-link" href="<?= $this->l_param() ?>page=<?= Utils::to_url( $this->l_param().($p-1) ) ?>"  ><i class="fa fa-angle-left"></i>
    </a>
  </li>
<?php
for ($i = 0; $i*20 <  $c; $i++): ?>
  <li class="page-item <?=$p==($i+1)?"active":""?>">
  	<a class="page-link"
     href="<?= Utils::to_url( $this->l_param()."page=".($i+1) )?>" ><?= $i+1 ?></a>
  </li>
<?php endfor; ?>
  <li class="page-item   <?= ($p > $c/20 )?"disabled":"" ?>">
    <a class="page-link" href="<?= Utils::to_url( $this->l_param()."page=".($p+1) )?>">
      <i class="fa fa-angle-right"></i>
    </a>
  </li>
</ul>
<?php
 	}
 }