<script src="<?php echo base_url('assets/js/lib/jquery.booklet.latest.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/lib/jquery.easing.1.3.js') ?>" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.booklet.latest.css') ?>" />
<script type="text/javascript">
    $('#myModal').remove();
</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width:110%">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Preview</h4>
            </div>
            <div class="modal-body" class="col-lg-10">

                <div id="mybook">
                    <div class="contentpage">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

