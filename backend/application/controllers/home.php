<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start();
//we need to call PHP's session object to access it through CI
class Home extends FrontEnd_Controller {

    function __construct() {
        parent::__construct();
        $this -> load -> model('books_model');
    }

    function index() {
        $data['username'] = $this -> session -> userdata('username');
        /*
        $book = $this -> books_model -> readFirstbook();
        $this -> select($book -> id);
        
        $this -> session -> set_userdata('books',$this->books_model->readall());
                        
        
         $bookoptions=array();
         foreach($books as $book){
         $bookoptions[$book->name]=$book->name;
         }
         $selectedbookoptions = array($books[0]->name);
         */

        /*
         $this -> session -> set_userdata('selectedbook',$selectedbookoptions);
         $this -> session -> set_userdata('books',$bookoptions);

         $pages=$this->pages_model->getBookPages($books[0]->id);
         $pageoptions=array();
         foreach($pages as $page){
         $pageoptions[$page->page_no]=$page->page_type;
         }
         $selectedpageoptions = array($pages[0]->page_no);
         $this -> session -> set_userdata('selectedpage',$selectedpageoptions);
         $this -> session -> set_userdata('pages',$pageoptions);
         */
        $data['title'] = "Home";
        $data['content'] = "home_view";
        $this -> load -> view('common/layout', $data);
    }

    function select($bookid) {
        $this -> session -> set_userdata('selectedbookid', $bookid);
    }

}
?>
