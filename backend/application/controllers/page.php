<?php

class Page extends  FrontEnd_Controller {

    function __construct() {
        parent::__construct();
        $this -> load -> model('pages_model');
    }

    function cover($error = null) {
        $data['error'] = $error;
        $data['title'] = "Add Cover Page";
        $data['content'] = "coverpage";
        $this -> load -> view('common/layout', $data);
    }

    function image($error = null) {
        $data['error'] = $error;
        $data['title'] = "Add Image Page";
        $data['content'] = "imagepage";
        $this -> load -> view('common/layout', $data);
    }

    function clickimage($error = null) {
        $data['error'] = $error;
        $data['title'] = "Add Click Image Page";
        $data['content'] = "clickimagepage";
        $this -> load -> view('common/layout', $data);
    }

    function quiz($error = null) {
        $data['error'] = $error;
        $data['title'] = "Add Quiz Page";
        $data['content'] = "quizpage";
        $this -> load -> view('common/layout', $data);
    }
    
    function preview($pageid) {
      //$data['content']="pagepreview";
      $data=$this->pages_model->read($pageid);
      echo json_encode($data);

    }
    
    
    function edit($pagetype, $pageid) {

    }

    function delete($pageid) {
        $this -> pages_model -> delete($pageid);
        // $data['status']="Success";
        // $data['message']="Deleted page successfully";
        // $data['content']="messageview";
        // $this -> load -> view('common/layout',$data);
        $this -> session -> set_flashdata('pagedelete', true);
    }

    function content() {
        //$data['title']="Add Content Page";
        $data['content'] = "contentpage";
        $this -> load -> view('common/layout', $data);
    }

    function managepage($bookid = null) {
        if (isset($bookid))
            $this -> session -> set_userdata("selectedbookid", $bookid);
        $bookid = $this -> session -> userdata("selectedbookid");

        $this -> load -> library('table');
        $data['tmpl'] = array('table_open' => '<table id="pagestable" class="table  sorted_table">', 'row_start' => '<tr>', 'row_end' => '</tr>');

        $data['heading'] = array('Page No', 'Title', 'Page Type', 'Edit', 'Delete', 'Preview');
        $data['content'] = "managepage";
        $data['pages'] = $this -> pages_model -> getBookPages($bookid);
        $this -> load -> view('common/layout', $data);
    }

    function imageUpload() {
        $bookid = $this -> session -> userdata("selectedbookid");
        $pageno = $this -> pages_model -> getLastPageNo($bookid) + 1;
        $this -> load -> library('upload');

        $data = array('upload_data' => $this -> upload -> data());
        $new_file_name = random_string('alnum', 15) . $data['upload_data']['file_name'];
        $config['upload_path'] = './booksdata/' . $bookid;
        $config['allowed_types'] = 'jpg|png';
        $config['overwrite'] = TRUE;
        $config['max_size'] = '600';
        $config['max_width'] = '1144';
        $config['max_height'] = '1574';
        $config['file_name'] = $new_file_name;
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777);
        }
        $this -> upload -> initialize($config);

        if (!$this -> upload -> do_upload()) {
            $this -> image($this -> upload -> display_errors());
        }
        $data = $this -> upload -> data();

        $pagedata = array("image" => $data['file_name'], "books_id" => $bookid, "page_no" => $pageno);
        $this -> session -> set_userdata("pageData", $pagedata);
        echo base_url() . "booksdata/$bookid/" . $data['file_name'];
    }

    function __resizeImage($path, $filename) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path . "/" . $filename;

        $config['maintain_ratio'] = TRUE;
        $config['width'] = 75;
        $config['height'] = 50;

        $this -> load -> library('image_lib', $config);

        if (!$this -> image_lib -> resize()) {
            echo $this -> image_lib -> display_errors();
        }
    }

    function addcoverpage() {
        $pagedata = $this -> session -> userdata("pageData");
        $pagedata['page_type'] = "COVER_PAGE";
        $this -> pages_model -> create($pagedata);
        //generate_message_view("Success", "Cover page added");
        redirect('page/managepage#pageadded');
    }

    function addImagePage() {
        $pagedata = $this -> session -> userdata("pageData");
        $pagedata['page_type'] = "IMAGE_PAGE";
        $this -> pages_model -> create($pagedata);
        redirect('page/managepage#pageadded');
    }

    function addContentPage() {
        $bookid = $this -> session -> userdata("selectedbookid");
        $pageno = $this -> pages_model -> getLastPageNo($bookid) + 1;

        $pagedata = array("page_type" => "CONTENT_PAGE", "body" => $this -> input -> get_post('body', TRUE), "books_id" => $bookid, "page_no" => $pageno);
        $this -> pages_model -> create($pagedata);
        //generate_message_view("Success", "Image page added");
        redirect('page/managepage#pageadded');
    }

    function saveOrder() {
        $pages = json_decode($this -> input -> post('pages'));
        $i = 1;
        foreach ($pages as $page) {
            $this -> pages_model -> updatePageOrderOnly($page, $i);
            $i++;
        }
        //redirect('page/managepage');
    }

    function addQuizPage() {
        $bookid = $this -> session -> userdata("selectedbookid");
        $pageno = $this -> pages_model -> getLastPageNo($bookid) + 1;
        //$quiz = json_decode($this -> input -> post('quiz'));
        $data = array("body" => $this -> input -> post('quiz'), "page_no" => $pageno, "books_id" => $bookid, "page_type" => "QUIZ_PAGE");
        $this -> pages_model -> create($data);

    }

    function addClickImagePage() {
        $pagedata = $this -> session -> userdata("pageData");
        $pagedata['page_type'] = "CLICKIMAGE_PAGE";
        $pagedata['body'] = $this -> input -> post('tags');
        $this -> pages_model -> create($pagedata);
        redirect('page/managepage#pageadded');
    }

}
