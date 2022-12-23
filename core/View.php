<?php

require_once "core/Template.php";
class View {

    protected $model;

    public $template;

    public function __construct($model=  array() )  {

        $this->model = $model;
        $this->config();
    }

    public function set_template($template_name){
        require_once "app/views/templates/".$template_name.".template.php";
        $t = ucfirst($template_name)."Template";
        $this->template = new $t($this->model);
    }

    public function config(){

    }

    public function render() {
        if (isset($this->template)) {
            $this->template->draw();
        }
    }
}