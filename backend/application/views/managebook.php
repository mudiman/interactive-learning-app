<div class='container'>

<div class='row col-lg-8 col-lg-offset-2' >
<?php
    
    $this->table->set_template($tmpl);
    
    $this->table->set_heading($heading);
    
    $edit='<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span></button>';
    $delete='<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></button>';
    
    foreach ($books as $book){
        $this->table->add_row(array($book->id, $book->name, $book->author_name,
        anchor(base_url('page/managepage/'.$book->id), $edit, 'title="Click to edit pages"'),
        anchor(base_url('book/delete/'.$book->id),$delete, 'title="Click to delete book" onclick="return confirm(\'Are you sure you want to delete this book?\')"'),
        '<button data-toggle="modal" data-target="#myModal" type="button" onclick="previewBook('.$book->id.')" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-book"></span></button>'
        ));
    }
    
    echo $this->table->generate();
?>
</div>
</div>

<?php $this->load->view("common/pagepreview"); ?>