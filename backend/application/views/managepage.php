<script src="<?php echo base_url('assets/js/lib/jquery-ui-1.10.4.custom.js')?>" type="text/javascript"></script>

<div class="page-header col-lg-10 col-xs-offset-1">
  <h2 class="pull-left">Manage Page</h2>
  <div class="form-group pull-right col-lg-offset-1">
      
      <div class="dropdown pull-right">
            <a href="#" class="glyphicon glyphicon-plus btn btn-primary col-md-offset-1" style="height: 33px;" data-toggle="dropdown"> Add Page <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="<?php echo base_url('page/cover');?>">Cover Page</a>
                </li>
                <li>
                    <a href="<?php echo base_url('page/content');?>">Content Page</a>
                </li>
                <li>
                    <a href="<?php echo base_url('page/clickimage');?>">Click Image Page</a>
                </li>
                
                <li>
                    <a href="<?php echo base_url('page/image');?>">Image Page</a>
                </li>
                
                <li>
                    <a href="<?php echo base_url('page/quiz');?>">Quiz Page</a>
                </li>
            </ul>
        </div>
        <button class="btn btn-primary glyphicon glyphicon-save pull-right" style="height:33px;padding-bottom: 12px;" title="Save page order after drag and drop pages" onclick="savePageOrder()"> Save Order</button>
</div>

</div>
<div class='row col-lg-8 col-xs-offset-1'>
    <div class="alert alert-info"><strong>Note! </strong>Drag and drop rows to order pages.</div>
    <div class="alert alert-success hidden page_order_alert"><strong>Success! </strong>Page order successfully saved.</div>
    <div class="alert alert-success hidden page_delete_alert"><strong>Success! </strong>Page successfully deleted.</div>
    <div class="alert alert-success hidden page_add_alert"><strong>Success! </strong>Page successfully added.</div>
<?php
    
    $this->table->set_template($tmpl);
    
    $this->table->set_heading($heading);
    
    $edit='<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span></button>';

    foreach ($pages as $page){
        $this->table->add_row(array("<label class='trpageid' data-pageid='$page->id'>$page->page_no</label>", $page->title, $page->page_type,
        anchor(base_url('page/editpage/'.$page->page_type."/".$page->id), $edit, 'title="Click to edit pages"'),
        '<button title="Click to delete book" onclick="deletePage(this,'.$page->id.')" type="button" class="aaa btn btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></button>',
        '<button data-toggle="modal" data-target="#myModal" type="button" onclick="previewPageFromBack('.$page->id.')" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-book"></span></button>'        
        ));
    }
    
    
    echo $this->table->generate();
?>
</div>

<?php $this->load->view("common/pagepreview"); ?>

<script type="text/javascript">

function deletePage(self,pageid){
    var result = confirm("Are you sure you want to delete page?");
    if (result==true) {
        //Logic to delete the item
        $.get(window.baseurl+"page/delete/"+pageid,function(){
            $(self).parents('tr').remove();
            savePageOrder();
            $('.page_delete_alert').removeClass('hidden');
          });
     }
}

function savePageOrder(afterdelete){
    if(typeof(afterdelete)==='undefined') afterdelete = null;
    var pages=[];
    $('#pagestable tr .trpageid').each(function(){
        pages.push($(this).data('pageid'));
    });
    $.ajax({
        url: window.baseurl+"/page/saveorder",
        data: "pages="+JSON.stringify(pages),
        method:"POST",
        contentType: 'application/x-www-form-urlencoded',
    }).done(function() {
       window.location=window.baseurl+"page/managepage#pageordered";
        $('.page_order_alert').removeClass('hidden');
    });
}

$(function() {
if (window.location.hash=="#pageadded"){
    $('.page_add_alert').removeClass('hidden');
}
var fixHelperModified = function(e, tr) {
    var $originals = tr.children();
    var $helper = tr.clone();
    $helper.children().each(function(index) {
        $(this).width($originals.eq(index).width())
    });
    return $helper;
},
    updateIndex = function(e, ui) {
        $('td.index', ui.item.parent()).each(function (i) {
            $(this).html(i + 1);
        });
    };

$("#pagestable tbody").sortable({
    helper: fixHelperModified,
    stop: updateIndex
}).disableSelection();
});
</script>