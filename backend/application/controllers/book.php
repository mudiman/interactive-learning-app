<?php

class Book extends  FrontEnd_Controller {
   
   function __construct() {
        parent::__construct();
        $this -> load -> model('books_model');
    }
   
   function create()
   {
      $data['makecreatebookactive']=true;
      $data['content']="createbook_view";
      $this -> load -> view('common/layout',$data);
   }
   
   function preview($bookid)
   {
      $data['content']="pagepreview";
      $this->__createBookJson($bookid);
      $bookdata=$this->books_model->read($bookid);
      echo $bookdata->json;
   }
   
   function __createBookJson($bookid){
       $this -> load -> model('pages_model');
       $pages=$this->pages_model->getBookPages($bookid);
//       foreach ($pages as &$page){
//           if(isset($page->image)){
//               $page->image="booksdata/$bookid/".$page->image;
//           }
//       }
       $data=array("json"=>json_encode($pages));
       $this->books_model->update($bookid,$data);
   }
   
   function register() {

        $this -> form_validation -> set_rules('name', 'name', 'trim|required|xss_clean');
        $this -> form_validation -> set_rules('author_name', 'Author Name', 'trim|required|xss_clean');

        if ($this -> form_validation -> run() == FALSE) {
            $this -> session -> set_flashdata('name', $this -> input -> post('name'));
            $this -> session -> set_flashdata('author_name', $this -> input -> post('author_name'));
            redirect('/book/createbook');
        } else {
            $data = array('name' => $this -> input -> post('name'), 'author_name' => $this -> input -> post('author_name'));
            $this -> books_model -> create($data);
            $bookid=$this->books_model->getbookId($this -> input -> post('name'));
           
            if (!is_dir('./booksdata/'.$bookid)) {
                mkdir('./booksdata/'.$bookid,0777, TRUE);
            }

            templateView("Success", 'Book created');
        }
    }
   
   function delete($id)
   {
      $this->books_model->delete($id);
      $data['status']="Success";
      $data['message']="Deleted book successfully";
      $data['content']="messageview";
      $this -> load -> view('common/layout',$data);
   }
   
   function updatebook()
   {
      $data['title']="Add Image Page";
      $data['content']="imagepage";
      $this -> load -> view('common/layout',$data);
   }
     
   function managebook()
   {
       $this->load->library('table');
       $data['tmpl'] =array ( 'table_open'  => '<table class="table">' ); 
       $data['heading']=array('#', 'Title', 'Author Name','Manage Page','Delete','Preview');
       $data['makemanagebookactive']=true;
       $data['content']="managebook";
       $data['books']=$this->books_model->readAll();
       $this -> load -> view('common/layout',$data);
   }
   
}