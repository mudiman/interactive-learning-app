<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FrontEnd_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        
        $exceptions=array("login","login/index","login/logout","login/verify");

        if (!in_array(uri_string(), $exceptions)){
            if (!$this->session->userdata('logged_in'))
                redirect("login");
        }
        
    }

    
}
?>
