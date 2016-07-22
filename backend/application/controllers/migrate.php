<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Migrate extends FrontEnd_Controller {

    public function index() {
        $this->load->library('migration');

        if (!$this->migration->current()) {
            show_error($this->migration->error_string());
        } else {
            echo "Migration success";
        } 
    }

    public function make_base() { 

        $this->load->library('VpxMigration');

        // All Tables:

       $val =  $this->vpxmigration->generate();
       print_r($val);

    }

}
