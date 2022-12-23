<?php
class CampoTemplate extends Template{  
  public function render(){
    $name = $this->T("name"); 
    $add_class = $this->T("add_class");
    $autocomplete = $this->T("autocomplete");
    $required = $this->T("required");
    $placeholder = $this->T("placeholder");
    $end_point = $this->T("end_point");
    $label = $this->T("label");
    $autocomplete_att = $this->T("autocomplete_att");
    $form_type = $this->T("form_type");
    $file = ($form_type == 'file');
    $readonly = $this->T("readonly");
    $r = $readonly? 'v':'';
    $size = $this->T("size");
    $autoload = $this->T("autoload") ?? false;
    $attributes = $this->T("attributes");
    $children = $this->T("children");
    $valor = $this->T("value");
    ?>
    <div class="form-group <?=$autocomplete?'autocomplete':''?> <?= $add_class ?>">
     <?php if($label):?>
       <label for="input<?= $r ?><?= ucfirst($name) ?>"><?= $label ?></label>
     <?php endif; ?>
     <?php if($form_type == "foto"):?>
      <input id="input<?= $r ?><?= ucfirst($name) ?>" type="hidden" name="<?= $name ?>" value=""/>
      <?php if(!$readonly): ?>
       <div id="captura"  class="m-2 p-2" style="border-radius: 10px;min-height: 150px; min-width: 250px;background-color: gray;" >
        <p class="info-foto" style="color: white;">Click para tomar foto</p>
        <video id="video" style="width:100%;border-radius: 10px;min-width: 250px;background-color: gray;"></video>
        <canvas id="canvas" style="display: none;"></canvas>
      </div>
      <div class="button-photo btn-sm m-2 btn-primary text-center " style="margin-right: auto;margin-left: auto;" disabled>Tomar Captura</div>
      <?php else:?> 
        <img class="img-reponsive image-buffer" style="max-width: 100%;" fuente="input<?= $r ?><?= ucfirst($name) ?>"  src="">
      <?php endif;?>
      <?php else: ?>
        <?php if(!($readonly && $file)):?> 
          <<?= ($form_type == 'select'?'select':'input') ?> id="input<?= $r ?><?= ucfirst($name) ?>" entrada="input<?= $r ?><?= ucfirst($name) ?>1" class="<?= ($form_type == 'select'?'custom-select':'') ?> form-control<?=$file?'-file':''?><?= $size?'-'.$size:'' ?> " <?= $autocomplete?" data-clase=\"".$this->T('clase').'"':'' ?> type="<?= $form_type ? $form_type : 'text'?>" name="<?= (($autocomplete || $file)?'_':'').$name ?>" placeholder="<?= $placeholder ?>" <?= $required?'required=""':''?>
          <?php if($attributes)foreach ($attributes as $key => $value):?>
            data-<?= $key ?>="<?= $value ?>" 
          <?php endforeach; ?>
          
          <?= $form_type == 'select' && $end_point?'end_point='.$end_point:''?>
           autocomplete="off" <?= $readonly? "readonly":"" ?> autoload=<?= $autoload?"true":"false" ?>  <?= $readonly? "disabled":"" ?> <?= $valor ?'value='."'$valor'":''?> children=<?php if($children) foreach($children as $k => $c)echo (!$k)? $c:",$c" ?> >
          <?php  if($form_type == "select"):?>
          <option disabled="true" value="" selected="true" hidden="true"><?= $placeholder ?></option>
        <?php endif; ?>
          </<?= ($form_type == 'select'?'select':'input')  ?>>
        <?php endif; ?>
        <?php if($autocomplete || $file ): ?>
         <input id="input<?= $r ?><?= ucfirst($name) ?><?= !($file && $readonly)?'1':''?>" class="hidden-input-form<?=$file?'-file':"" ?>" data-show="input<?= $r ?><?= ucfirst($name) ?>" type="hidden" name="<?= $name ?>"/>
         <?php if($readonly && $file): ?>
          <img class="img-reponsive image-buffer" style="max-width: 100%;" fuente="input<?= $r ?><?= ucfirst($name) ?>"   src="">
        <?php endif;
      endif; ?>
    <?php endif; ?>
  </div>
  <?php if($autocomplete): ?>
    <?php if(!$readonly): ?>
      <script type="text/javascript">
       function autocomplete<?=  $name ?>(inp) {
        if(inp === null)return;
        var currentFocus;
        inp.addEventListener("input", function(e) {
          var a, b, i, val = this.value;
          
          closeAllLists();
          inp.classList.remove("input-success");
          inp.classList.add("input-invalid");
          if (!val) { return false;}
          currentFocus = -1;
          a = document.createElement("DIV");
          a.setAttribute("id", this.id + "autocomplete-list");
          a.setAttribute("class", "autocomplete-items");
          this.parentNode.appendChild(a);
          cola = document.createElement("div");
          t = document.createElement("h6");
          t.setAttribute("class","list-item-title");
          cola.appendChild(t);
          cola.setAttribute("class", "col-xs-12");
          
          a.appendChild(cola);
          var rval = RegExp(val,'i');
          $.post("<?= $end_point ?>",{<?=$autocomplete_att ?> : val} ,data=>{       
            console.log(data);
            data.forEach(item => {
             b = document.createElement("div");
             b.classList.add("item-autocomplete");
             b.classList.add("text-center");
             b.innerHTML = "<div>"+item.presentation+"</div>";
             b.innerHTML += "<input type='hidden' value='" + item.id  + "'>";
             b.addEventListener("click", function(e) {
              inp.value = this.getElementsByTagName("div")[0].innerHTML;
              document.getElementById( inp.getAttribute("entrada")).value = this.getElementsByTagName("input")[0].value ;
              inp.classList.remove("input-invalid");
              inp.classList.add("input-success");
              closeAllLists();
            });
             cola.appendChild(b);
           });
          });
        });
        inp.addEventListener("keydown", function(e) {
          var x = document.getElementById(this.id + "autocomplete-list");
          if (x) x = x.getElementsByTagName("div");
          if (e.keyCode == 40) {
            currentFocus++;
            addActive(x);
          } else if (e.keyCode == 38) {
            currentFocus--;
            addActive(x);
          } else if (e.keyCode == 13) {
            e.preventDefault();
            if (currentFocus > -1) {
              if (x) x[currentFocus].click();
            }
          }
        });
        function addActive(x) {
          if (!x) return false;
          removeActive(x);
          if (currentFocus >= x.length) currentFocus = 0;
          if (currentFocus < 0) currentFocus = (x.length - 1);
          x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
          for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
          }
        }
        function closeAllLists(elmnt) {
          var x = document.getElementsByClassName("autocomplete-items");
          for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
              x[i].parentNode.removeChild(x[i]);
            }
          }
        }
      }

      autocomplete<?= $name ?>(document.getElementById("input<?= ucfirst($name) ?>"));
    <?php endif; ?>
  </script>
  <?php
endif;
}
}