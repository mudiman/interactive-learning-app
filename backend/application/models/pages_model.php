<?php
class Pages_model extends CI_Model {

    function Pages_model() {
        parent::__construct();
        $this -> load -> database();
    }

    function create($data) {
        //$pageid = $this -> getPageId($data['page_no'], $data['books_id']);
        //if ($pageid == null) {
            $this -> db -> set('books_id', $data['books_id']);
            $this -> db -> set('page_type', $data['page_type']);
            $this -> db -> set('page_no', $data['page_no']);
            if (isset($data['title']))
                $this -> db -> set('title', $data['title']);
            if (isset($data['image']))
                $this -> db -> set('image', $data['image']);
            if (isset($data['body']))
                $this -> db -> set('body', $data['body']);
            if (isset($data['click_positions']))
                $this -> db -> set('click_positions', $data['click_positions']);
            if (isset($data['sound_file']))
                $this -> db -> set('sound_file', $data['sound_file']);
            $this -> db -> insert('pages');

            return $this -> db -> affected_rows();
        //} else {
          //  $this -> update($pageid, $data);
//        }
    }
    
    function getLastPageNo($bookid) {
        $this->db->order_by("page_no desc"); 
        $this->db->limit(1);
        $this->db->select('page_no');
        $this -> db -> where('books_id', $bookid);
        $query = $this -> db -> get('pages');
        if ($query -> num_rows() <= 0)
            return 0;
        $temp = $query -> row();
        return $temp -> page_no;
    }
    
    function getPageId($pageno, $bookid) {
        $this -> db -> where('page_no', $pageno);
        $this -> db -> where('books_id', $bookid);
        $query = $this -> db -> get('pages');
        if ($query -> num_rows() < 0)
            return null;
        $temp = $query -> row();
        return $temp -> id;
    }
    
    function getPageNoFromId($pageid) {
        $this -> db -> where('id', $pageid);
        $query = $this -> db -> get('pages');
        if ($query -> num_rows() <= 0)
            return null;
        $temp = $query -> row();
        return $temp -> id;
    }

    function read($id) {
        $this -> db -> where('id', $id);
        //$this -> db -> where('books_id', $id);
        $query = $this -> db -> get('pages');

        return $query -> row();
    }

    function getBookPages($bookid) {
        $this -> db -> where('books_id', $bookid);
        $this->db->order_by("page_no", "asc"); 
        $query = $this -> db -> get('pages');

        return $query -> result();
    }

    function readAll() {
        $query = $this -> db -> get('pages');
        return $query -> result();
    }
    
    function updatePageOrderOnly($pageid, $pageno) {
        $this -> db -> where('id', $pageid);
        $this -> db -> set('page_no', $pageno);
        $this -> db -> update('pages');

        return $this -> db -> affected_rows();
    }
    
    function update($id, $data) {
        $this -> db -> where('id', $id);
        $this -> db -> where('books_id', $data['books_id']);
        $this -> db -> set('page_type', $data['page_type']);
        $this -> db -> set('page_no', $data['page_no']);
        if (isset($data['title']))
            $this -> db -> set('title', $data['title']);
        if (isset($data['image']))
            $this -> db -> set('image', $data['image']);
        if (isset($data['body']))
            $this -> db -> set('body', $data['body']);
        if (isset($data['click_positions']))
            $this -> db -> set('click_positions', $data['click_positions']);
        if (isset($data['sound_file']))
            $this -> db -> set('sound_file', $data['sound_file']);
        $this -> db -> update('pages');

        return $this -> db -> affected_rows();
    }

    function delete($id) {
        $pageno=$this->getPageNoFromId($id);
        $this -> db -> where('id', $id);
        $this -> db -> delete('pages');

        return $this -> db -> affected_rows();
    }

}
