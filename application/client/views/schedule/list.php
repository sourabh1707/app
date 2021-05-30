<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo translate('list'); ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    
                    <table id="list_datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo translate('name'); ?></th>
                                <th><?php echo translate('schedule_on'); ?></th>
                                <th><?php echo translate('schedule_to'); ?></th>
                                <th><?php echo translate('status'); ?></th>
                                <th><?php echo translate('operations'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th><?php echo translate('name'); ?></th>
                                <th><?php echo translate('schedule_on'); ?></th>
                                <th><?php echo translate('schedule_to'); ?></th>
                                <th><?php echo translate('status'); ?></th>
                                <th><?php echo translate('operations'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div id="send-model" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-send_schedular" method="post" enctype="multipart/form-data" action="<?php echo site_url().'schedular/crud/send' ?>">
                <div class="modal-header">
                    <button type="button" class="close close-model" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Send Schedular to Terminal</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="terminal"><?php echo translate('terminal') ?> <span class="required">*</span></label> 
                                <select class="form-control select2" id="terminal" name="terminal[]" style="width:100%;" data-parsley-errors-container="#error_terminal" required multiple>
                                    <option></option>
                                    <?php
                                        if (isset($terminals) && !empty($terminals)) {
                                            foreach ($terminals as $vkey => $terminal) {
                                                $alise = $terminal->client_alise!='' ? ' (' . $terminal->client_alise. ')' : '';
                                                echo '<option value="' . $terminal->name . '" >' . $terminal->name . $alise . '</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <span id="error_terminal"></span>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12" style="display:none;">
                            <div class="form-group">
                                <label for="loop"><?php echo translate('loop') ?> <span class="required">*</span></label> 
                                <input type="text" class="form-control" id="loop" name="loop" placeholder="<?php echo translate('loop'); ?>" value="0" required >
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="button">&nbsp;</label> <br/>
                                <input type='hidden' name='action' id='action' value='send_command'>
                                <input type='hidden' name='id' id='schedular_id' value=''>
                                <button type="button" data-type="send_schedular" class="btn btn-submit btn-success" data-as='<i class="fa fa-share"></i> <?php echo translate('send'); ?>' data-bs='<i class="fa fa-share"></i> <?php echo translate('sending'); ?>'><i class="fa fa-share"></i> <?php echo translate('send'); ?></button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo translate('close'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/pdfmake/build/vfs_fonts.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/select2/dist/js/select2.full.min.js"></script>
<script>
    $(document).ready(function () {
        $(".select2").select2({placeholder: "<?php echo translate('select'); ?>"});
        $('.form-get_brightness').parsley();
        $('body').on('click', '.btn-submit', function () {
            var here = $(this);
            var type = $(this).data('type');
            if ($('.form-' + type).parsley().validate()) {
                $.ajax({
                    type: 'POST',
                    url: $('.form-' + type).attr('action'),
                    data: $('.form-' + type).serialize(),
                    beforeSend: function () {
                        $(".ajax_loader").hide();
                        here.html(here.data('bs'));
                    },
                    success: function (data) {
                        $('.send-model').hide();
                        here.html(here.data('as'));
                        if (data.status == 200) {
                            $.each(data.details, function (i, v) {
                                notify_success(v);
                            });
                            
                        } else {
                            $.each(data.details, function (i, v) {
                                notify_error(v);
                            });
                        }
                    },
                    error: function (xhr) {
                        notify_error("<?php echo translate('error_occured._please_try_again.'); ?>");
                    },
                    complete: function () {
                        here.html(here.data('as'));
                    }
                });
            }
        });
        $('body').on('click', '.btn-clear', function () {
            $(".api-response").html("");
            $('.btn-response').hide();
        });
    });
</script>
